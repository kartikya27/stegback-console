<?php

namespace Kartikey\PanelPulse\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request; // Ensure this is imported
use Illuminate\Support\Facades\Storage;
use Kartikey\PanelPulse\app\CommonHelper;
use Kartikey\PanelPulse\Models\Category;
use Kartikey\PanelPulse\Models\Order;
use Kartikey\PanelPulse\Services\BunnyCdnService;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function category_list()
    {
        $categories =  Category::get()->toArray();

        $categoryTree = $this->buildCategoryTree($categories, 0);

        return view('PanelPulse::admin.category.list',['categories' => $categoryTree]);
    }

    /**
     * Recursive helper function to build the nested category tree structure (internal use).
     *
     * @param array|object $categories An array or object containing category data.
     * @param int $parentId The ID of the current parent category.
     *
     * @return array An array representing the nested child categories for the given parent.
     */
    private function buildCategoryTree(array|object $categories, int $parentId): array
    {
        $tree = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildCategoryTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                // $tree[] = $category;
                $tree[] = $this->transformCategory($category);
            }
        }
        return $tree;
    }


    private function transformCategory(array $category): array
    {
        // Exclude specific fields
        unset($category['parent_id'],$category['created_at'],$category['updated_at']);

        return $category;
    }

    public function category_edit($id,$slug)
    {

        $category =  Category::where('id',$id)->first();

        $parentCategories =  Category::find($category->parent_id);

        return view('PanelPulse::admin.category.edit',['category' => $category,'parentCategories' => $parentCategories]);
    }

    public function category_save(Request $request, $slug)
    {
        $category = Category::find($request->id);
        $isSlugUpdate = $request->has('slugCheck');
        if($isSlugUpdate)
        {
            $slug = Str::slug($request->name);
            $category->slug = $slug;
        }
        $media = $category->media ?? [];
        //Category Icons
        $thumb_fileUrls = [];
        if($request->has('file')){
            $existingImages = $category->media['thumb_images'] ?? [];

            $category_thumbImg = $request->has('file')
                ? BunnyCdnService::uploadFiles($request->file('file'))
                : [];
            $thumb_fileUrls = (new CommonHelper())->addUrlsWithIds($existingImages, $category_thumbImg);

            $media['thumb_images'] = $thumb_fileUrls;

        }

        //Category Banners
        $banner_fileUrls = [];
        if($request->has('banners')){
            $existingBannerImages = $category->media['banner_images'] ?? [];
            $category_bannerImg = $request->has('banners')
                ? BunnyCdnService::uploadFiles($request->file('banners'))
                : [];
            $banner_fileUrls = (new CommonHelper())->addUrlsWithIds($existingBannerImages, $category_bannerImg);

            $media['banner_images'] = $banner_fileUrls;

        }

        // Category Featured Iocns
        $featuredIcons_fileUrls = [];
        if($request->has('featured_icons')){
            $existingBannerImages = $category->media['featured_icons'] ?? [];
            $category_bannerImg = $request->has('featured_icons')
                ? BunnyCdnService::uploadFiles($request->file('featured_icons'))
                : [];
            $featuredIcons_fileUrls = (new CommonHelper())->addUrlsWithIds($existingBannerImages, $category_bannerImg);

            $media['featured_icons'] = $featuredIcons_fileUrls;
        }

        // Category Featured Banners
        $featuredBanner_fileUrls = [];
        if($request->has('featured_banners')){
            $existingBannerImages = $category->media['featured_banners'] ?? [];
            $category_bannerImg = $request->has('featured_banners')
                ? BunnyCdnService::uploadFiles($request->file('featured_banners'))
                : [];
            $featuredBanner_fileUrls = (new CommonHelper())->addUrlsWithIds($existingBannerImages, $category_bannerImg);

            $media['featured_banners'] = $featuredBanner_fileUrls;
        }

        if(!empty($media))
        {
            $category->media = $media;
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.edit',[$request->id,$slug]);
    }

    public function category_delete($categoryId, $type, $imageId)
    {
        $category = Category::findOrFail($categoryId);
        $media = $category->media ?? [];

        if (isset($media[$type]) && array_key_exists($imageId, $media[$type])) {
            unset($media[$type][$imageId]);
            $category->media = $media;
            $category->save();
        }
        return redirect()->back()->with('success', 'Image removed successfully.');
    }


}
