<?php

namespace Kartikey\PanelPulse\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kartikey\PanelPulse\Models\Product;
use Kartikey\PanelPulse\Models\ProductSetting;
use Kartikey\PanelPulse\Models\CoreConfig as ModelsCoreConfig;
use Kartikey\PanelPulse\App\Enums\Status;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products =  Product::with('descriptions', 'images','prices','sellers','xml_data')->get()->toArray();

        return view('PanelPulse::admin.products.list',['products' => $products]);
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back();
    }
    public function toggleXmlFeedAllClear(Request $request)
    {
        ProductSetting::truncate();
        return response()->json([
            'success' => true,
            'message' => 'XML feed cleared successfully'
        ]);
    }


    public function toggleXmlFeed($id)
    {
        try {
            $existing = ProductSetting::where('product_id', $id)
                        ->where('key', 'xml-enabled')
                        ->first();
        
            if ($existing) {
                $existing->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'XML feed removed successfully'
                ]);
            } else {
                ProductSetting::create([
                    'product_id' => $id,
                    'key'        => 'xml-enabled',
                    'value'      => 1,
                ]);
        
                return response()->json([
                    'success' => true,
                    'message' => 'XML feed added successfully'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update XML feed status'
            ], 500);
        }
    }

    public function toggleXmlFeedAll(Request $request)
    {
        $productIds = $request->input('product_ids');
        if (!is_array($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product IDs format'
            ], 400);
        }
        
        foreach ($productIds as $productId) {
            $this->toggleXmlFeed($productId);
        }
        return response()->json([
            'success' => true,
            'message' => 'XML feed added successfully'
        ]);
    }
    

    public function xmlFeeds()
    {


        $feedReports = ModelsCoreConfig::where('code', 'xml-report-url')
            ->orderBy('created_at', 'DESC')
            ->get();

            foreach ($feedReports as $report) {
                $createdAt = Carbon::parse($report->created_at);

                // If the report was created today
                if ($createdAt->isToday()) {
                    $report->formatted_date = "Today " . $createdAt->format('g:i A');
                }
                // If the report was created yesterday
                elseif ($createdAt->isYesterday()) {
                    $report->formatted_date = "Yesterday " . $createdAt->format('g:i A');
                }
                // Otherwise, use the custom date format
                else {
                    $report->formatted_date = $createdAt->format('d M Y');
                }
            }


        return view('PanelPulse::admin.settings.xml-feeds.view',['feedReports' => $feedReports]);
    }

    public function genrateXML()
    {
        // $products = ProductSetting::where(['key' => 'xml-enabled', 'value' => 1])->with('products','products.images','products.descriptions','products.prices')->get();

        $products = ProductSetting::where(['key' => 'xml-enabled', 'value' => 1])
        ->with('products', 'products.images', 'products.descriptions', 'products.prices','products.product_categories')
        ->get()
        ->pluck('products'); // Extract products collection

        // Step 2: Generate XML content using view
        $feedContent = view('PanelPulse::admin.products.xml-feeds', ['products' => $products])->render();

        $reportId = uniqid('report_', false);
        $directoryPath = storage_path("app/reports");
        $path = "{$directoryPath}/{$reportId}.xml";

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        file_put_contents($path, $feedContent);

        // Step 4: Store the XML report URL in the database
        $reportUrl = url("products/xml/report/{$reportId}");
        ModelsCoreConfig::create([
            'code' => 'xml-report-url',
            'value' => $reportUrl,
        ]);


        $products = ProductSetting::truncate();

        return redirect()->back();
        // Step 5: Return the XML response
        return response($feedContent)->header('Content-Type', 'text/xml');

    }
    public function view($id)
    {

        try {
            $statuses = Status::all();
            $product = Product::with('descriptions', 'images', 'prices', 'sellers','product_categories','taxes')->findOrFail($id);
            return view('PanelPulse::admin.products.view', ['product' => $product,'statuses' => $statuses]);
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('error', 'Failed to retrieve product details.');
        }
    }

}
