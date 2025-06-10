<?php

namespace Kartikey\PanelPulse\Http\Controllers\WebSettings;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request; // Ensure this is imported
use Illuminate\Support\Facades\Storage;
use Kartikey\PanelPulse\Models\Category;
use Kartikey\PanelPulse\Models\Order;
use Kartikey\PanelPulse\Models\Slider;
use Kartikey\PanelPulse\Services\BunnyCdnService;


class SliderController extends Controller
{
    public function slider_list()
    {
        $sliders = Slider::get()->map(function ($slider) {
            // Process date formatting
            $uploadDate = Carbon::parse($slider->created_at);
            $now = Carbon::now();

            if ($uploadDate->isToday()) {
                $formattedDate = "Today at " . $uploadDate->format('g:i A');
            } elseif ($uploadDate->isYesterday()) {
                $formattedDate = "Yesterday at " . $uploadDate->format('g:i A');
            } else {
                $formattedDate = $uploadDate->format('l, j M Y'); // Example: Tuesday, 12 Dec 2024
            }

            $slider->formatted_date = $formattedDate;

            // Ensure `desktop_img` exists and is not empty
            $desktopImages = $slider->desktop_img ?? [];

            // Process each image to add size
            $processedImages = array_map(function ($imagePath) {
                try {
                    $fileSizeBytes = Storage::disk('bunnycdn')->size($imagePath); // Get file size in bytes
                    $fileSizeKB = round($fileSizeBytes / 1024, 2); // Convert to KB
                    return [
                        'path' => $imagePath,
                        'size' => "{$fileSizeKB} KB"
                    ];
                } catch (\Exception $e) {
                    return [
                        'path' => $imagePath,
                        'size' => 'Unknown'
                    ];
                }
            }, $desktopImages);

            // Add processed images to the slider object
            $slider->desktop_images = $processedImages;

            return $slider;
        });


        return view('PanelPulse::admin.sliders.list',['sliders' => $sliders]);
    }

    private function formatDate($date)
    {
        $now = now();
        $yesterday = $now->subDay();
        $dateFormatted = '';

        if ($date->isToday()) {
            $dateFormatted = 'Today at ' . $date->format('H:i');
        } elseif ($date->isSameDay($yesterday)) {
            $dateFormatted = 'Yesterday at ' . $date->format('H:i');
        } else {
            $dateFormatted = $date->format('l, j M Y');
        }

        return $dateFormatted;
    }

    public function slider_create()
    {
        return view('PanelPulse::admin.sliders.create');
    }

    public function slider_store(Request $request)
    {
        $validatedData = $request->validate([
            'link' => 'required|url',
            'visiblity' => 'required|boolean',
            'banner' => 'nullable|array',
            'banner.*' => 'file|mimes:jpeg,png,jpg|max:5120',
            'mobile' => 'nullable|array',
            'mobile.*' => 'file|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $bannerUrls = [];
            if($request->has('banner')){
            $bannerUrls = $request->has('banner')
                ? BunnyCdnService::uploadFiles($request->file('banner'))
                : [];
            }
            $mobileUrls = [];
            if($request->has('mobile')){
            $mobileUrls = $request->has('mobile')
                ? BunnyCdnService::uploadFiles($request->file('mobile'))
                : [];
            }

                $slider = Slider::create([
                    'link' => $validatedData['link'],
                    'status' => $validatedData['visiblity'],
                    'desktop_img' => $bannerUrls,
                    'mobile_img' => $mobileUrls,
                ]);

            return redirect()->route('slider.edit',[$slider->id])->with('success', 'Slider added successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function slider_edit($id)
    {
        $slider = Slider::find($id);

        return view('PanelPulse::admin.sliders.edit',['slider' => $slider]);
    }

    // For Update
    public function slider_save()
    {
        //
    }

    public function slider_delete($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->back();
    }



}


