<?php

namespace Kartikey\PanelPulse\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kartikey\PanelPulse\Models\Campaign;
use Kartikey\PanelPulse\Models\Company;
use Kartikey\PanelPulse\Models\AdGroup;

class CampaignController extends Controller
{
    public function index()
    {
        $seller = json_decode(base64_decode(request()->seller), true);
        if(!$seller)
        {
            return response()->json(['error' => 'Invalid request URL'], 404);
        }

        $emailKey = array_key_first($seller);
        $authKey = $seller[$emailKey];
        $company = Company::where('email',$emailKey)->where('auth_key',$authKey)->exists();

        if(!$company)
        {
            return response()->json(['error' => 'Company not found'], 404);
        }

        $user = Company::where('email', $emailKey)->first();
        //set auth for temprory user only for specific routes
        if ($user && $user->auth_key === $authKey) {
            Auth::guard('seller')->login($user);
            return redirect()->route('ads.campaigns.seller.auth.ads');

        } 
        return response()->json(['error' => 'Invalid request'], 200);
    }
    
    public function lists()
    {
        if(!Auth::guard('seller')->check())
        {
            return response()->json(['error' => 'Invalid request'], 200);
        }

        $sellerAuthId = Auth::guard('seller')->user()->id;

        $campaigns = Campaign::where('seller_id',$sellerAuthId)->get();

        return view('PanelPulse::admin.ads.campaign.campaign',['campaigns' => $campaigns]);
    }

    public function show($campaign_id)
    {
        $campaign = Campaign::where('campaign_id', $campaign_id)
            ->with(['adGroups.ads'])
            ->firstOrFail();

        return view('PanelPulse::admin.ads.ads-set.list',['adgroups' => $campaign->adGroups,'campaign' => $campaign]);
    }

    public function createAds($adgroup_id)
    {
        $adgroup = AdGroup::where('ad_group_id', $adgroup_id)->first();
        return view('PanelPulse::admin.ads.ads-set.form',['adgroup' => $adgroup]);
    }

}