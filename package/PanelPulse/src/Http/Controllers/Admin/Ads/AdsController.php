<?php

namespace Kartikey\PanelPulse\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function index()
    {
        return view('PanelPulse::admin.ads-set.form');
    }
}