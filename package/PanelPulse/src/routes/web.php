<?php

use Kartikey\PanelPulse\Http\Controllers\Admin\Ads\AdsController;
use Kartikey\PanelPulse\Http\Controllers\Admin\Ads\CampaignController;
use Kartikey\PanelPulse\Http\Controllers\AjaxController;
use Kartikey\PanelPulse\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Kartikey\PanelPulse\Http\Controllers\Admin\CategoryController;
use Kartikey\PanelPulse\Http\Controllers\Admin\ProductController;
use Kartikey\PanelPulse\Http\Controllers\Admin\SellerController;
use Kartikey\PanelPulse\Http\Controllers\Admin\SellerSalesReportController;
use Kartikey\PanelPulse\Http\Controllers\AdminController;
use Kartikey\PanelPulse\Http\Controllers\AuthController;
use Kartikey\PanelPulse\Http\Controllers\CouponController;
use Kartikey\PanelPulse\Http\Controllers\OrderController;
use Kartikey\PanelPulse\Http\Controllers\WebSettings\SliderController;
use Kartikey\PanelPulse\Services\LanguageService;

$lang = (new LanguageService)->getRouteLocale();
define('lang', $lang);

Route::get('lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});


Route::middleware(['web', 'guest'])->group(function () {
    Route::get('login', function () {
        // return view('auth.login');
        return redirect()->route('home');
    })->name('login');

    Route::get('register', function () {
        return view('auth.login');
    })->name('register');

    Route::post('login', [AuthController::class, 'loggedIn_PostRequest'])->name('login');
});


Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::prefix('admin')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
        Route::get('/customers', [OrderController::class, 'customers'])->name('admin.customers');
        Route::delete('/customers/{id}', [OrderController::class, 'deleteCustomer'])->name('admin.customers.delete');
        Route::get('/order/{order_id}', [OrderController::class, 'order'])->name('admin.order');
        Route::get('/view/{order_id}', [OrderController::class, 'view'])->name('admin.view');

        // Route::get('/products',[ProductController::class,'index'])->name('admin.products');

        Route::prefix('products')->name('admin.')->group(function(){
            Route::controller(ProductController::class)->group(function(){
            Route::get('/list','index')->name('products');
            Route::get('/view/{id}','view')->name('product.view');

            Route::get('/delete/{id}','delete')->name('product.delete');

            Route::get('/xml-feed-add/{id}','toggleXmlFeed')->name('product.xml.toggle');
            Route::post('/xml-feed-add','toggleXmlFeedAll')->name('product.xml.toggle.all');
            Route::get('/xml-feed-add-clear','toggleXmlFeedAllClear')->name('product.xml.toggle.all.clear');

            Route::get('/xml-feeds','xmlFeeds')->name('products.xml');
            Route::get('/genrate-report','genrateXML')->name('products.genrateNewXml');
            });
        });



        //* Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');

        //* Shipping Settings
        Route::get('/settings/shipping', [SettingController::class, 'shippings'])->name('admin.settings.shipping');
        Route::get('/settings/shipping/{country}', [SettingController::class, 'shippings_rates'])->name('admin.settings.shipping.rates');
        Route::post('/settings/shipping/add', [SettingController::class, 'shipping_add'])->name('admin.settings.shipping.add');
        Route::post('/settings/shipping/add-country', [SettingController::class, 'shipping_add_country'])->name('admin.settings.shipping.add-country');
        Route::delete('/settings/shipping/country/delete', [SettingController::class, 'shipping_country_delete'])->name('admin.settings.shipping.country.delete');

        //? Done Taxation Settings
        Route::get('/settings/taxes', [SettingController::class, 'taxes'])->name('admin.settings.taxes');
        Route::get('/settings/taxes/{country}', [SettingController::class, 'taxes_detail'])->name('admin.settings.taxes.detail');
        Route::post('/settings/taxes/{country}', [SettingController::class, 'taxes_store'])->name('admin.settings.taxes.update');
        Route::get('/settings/taxes/delete/{country}', [SettingController::class, 'taxes_delete'])->name('admin.settings.taxes.update');

        //? Payment and method Setting
        Route::get('/settings/payments', [SettingController::class, 'payments'])->name('admin.settings.payments');
        Route::get('/settings/payments/methods', [SettingController::class, 'payments_method'])->name('admin.settings.payments.methods');
        Route::post('/settings/payments/methods/add', [SettingController::class, 'payments_method_add'])->name('admin.settings.payments.methods.add');
        Route::post('/settings/payments/methods/update', [SettingController::class, 'payments_method_update'])->name('admin.settings.payments.methods.update');
        Route::delete('/settings/payments/methods/delete', [SettingController::class, 'payments_method_delete'])->name('admin.settings.payments.methods.delete');

        //? Theme Setting
        Route::get('/settings/theme', [SettingController::class, 'theme'])->name('admin.settings.theme');
        Route::get('/settings/theme/{id}', [SettingController::class, 'theme_setting'])->name('admin.settings.theme.view');

        Route::get('/settings/theme/json/{id}', [SettingController::class, 'theme_setting_json'])->name('admin.settings.theme.json');
        Route::post('/settings/theme/update/{id}', [SettingController::class, 'theme_setting_update'])->name('admin.settings.theme.update');

        // Route::post('/settings/payments/methods/add', [SettingController::class, 'payments_method_add'])->name('admin.settings.payments.methods.add');
        // Route::post('/settings/payments/methods/update', [SettingController::class, 'payments_method_update'])->name('admin.settings.payments.methods.update');
        // Route::delete('/settings/payments/methods/delete', [SettingController::class, 'payments_method_delete'])->name('admin.settings.payments.methods.delete');

        Route::prefix('settings/category/')->group(function(){
            Route::controller(CategoryController::class)->group(function(){
                Route::get('/','category_list')->name('category.list');
                Route::get('/{id}/{slug}/edit','category_edit')->name('category.edit');
                Route::post('/{slug}','category_save')->name('category.save');
                Route::get('/{categoryId}/{media_type}/{imageId}/delete','category_delete')->name('category.delete');
            });
        });

        Route::prefix('settings/web/slider')->group(function(){
            Route::controller(SliderController::class)->group(function(){
                Route::get('/','slider_list')->name('slider.list');
                Route::get('/create','slider_create')->name('slider.create');
                Route::post('/create','slider_store')->name('slider.store');
                Route::get('/{id}/edit','slider_edit')->name('slider.edit');
                Route::post('/{id}/update','slider_save')->name('slider.save');
                Route::get('/{id}/delete','slider_delete')->name('slider.delete');
            });
        });

        Route::prefix('settings/coupons/')->group(function(){
            Route::controller(CouponController::class)->group(function(){
                Route::get('/','index')->name('coupon.list');
                Route::get('/create','create')->name('coupon.create');
                Route::get('/edit/{id}','edit')->name('coupon.edit');
                Route::post('/store','store')->name('coupon.store');
                Route::put('/update/{id}','update')->name('coupon.update');
                Route::delete('/delete/{edit}','delete')->name('coupon.delete');
            });
        });

        Route::prefix('sellers')->name('admin.sellers.')->group(function() {
            Route::controller(SellerController::class)->group(function() {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
            
            Route::controller(SellerSalesReportController::class)->group(function() {
                Route::get('/{id}/sales-report', 'salesReport')->name('show.sales-report');
            });                            

        });

        Route::prefix('ads')->name('admin.ads.')->group(function() {
            Route::controller(AdsController::class)->group(function() {
                Route::get('/', 'index')->name('index');
            });
        });

    });
    Route::get('/admin/sellers/{sellerId}/download-sales-report', [SellerSalesReportController::class, 'downloadSalesReport'])->name('admin.sellers.downloadSalesReport');

    Route::post('getStateByCountry', [AjaxController::class, 'getStateByCountry'])->name('getStateByCountry');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




    // In your routes/web.php or routes/api.php file
    Route::get('products/xml/report/{reportId}', function ($reportId) {
        $filePath = storage_path("app/reports/{$reportId}.xml");

        if (file_exists($filePath)) {
            return response()->download($filePath, 'product_feed.xml', [
                'Content-Type' => 'application/xml',
            ]);
        }

        return response()->json(['error' => 'File not found.'], 404);
    });
});


Route::prefix('seller')->middleware('web')->group(function () {
    Route::prefix('campaigns')->name('ads.campaigns.')->group(function() {
        Route::controller(CampaignController::class)->group(function() {
            
            Route::get('/', 'index')->name('index');

            Route::middleware('seller.auth')->group(function() {
                Route::get('lists', 'lists')->name('seller.auth.ads');
                Route::get('{campaign}', 'show')->name('seller.auth.ads.show');
                Route::get('{adgroupId}/create', 'createAds')->name('seller.auth.ads.create');
            });

        });
    });

});



