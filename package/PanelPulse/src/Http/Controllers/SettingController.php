<?php

namespace Kartikey\PanelPulse\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kartikey\PanelPulse\Models\Payment;
use Kartikey\PanelPulse\Models\Shipping;
use Kartikey\PanelPulse\Models\ShippingCountry;
use Kartikey\PanelPulse\Models\Taxation;
use Kartikey\PanelPulse\Models\ThemeSetting as ModelsThemeSetting;

class SettingController extends Controller
{
    public function index()
    {
        return view('PanelPulse::admin.settings.setting');
    }

    public function shippings()
    {
        $shipping = Shipping::get();
        return view('PanelPulse::admin.settings.shipping', compact('shipping'));
    }

    public function shippings_rates($shippingClass)
    {
        $shippings = ShippingCountry::where('shipping_id', $shippingClass)
            ->with('shipping_class')
            ->get();

        return view('PanelPulse::admin.settings.shipping_list', ['shippings' => $shippings, 'shipping_class' => $shippingClass]);
    }

    public function shipping_add(Request $request)
    {
        Shipping::create([
            'type' => $request->type,
            'name' => $request->name,
            'cost' => $request->cost,
        ]);

        return redirect()->back();
    }

    public function shipping_add_country(Request $request)
    {
        $countryArray = explode('-', "$request->country");
        ShippingCountry::create([
            'shipping_id' => $request->shipping_id,
            'country_id' => $countryArray[0],
            'country_name' => $countryArray[1],
            'state' => $request->state,
            'cost' => $request->cost,
        ]);

        return redirect()->back();
    }

    public function shipping_country_delete(Request $request)
    {
        $ShippingCountry = ShippingCountry::where('id', $request->id)->first();
        $ShippingCountry->delete();
        return true;
    }

    //*TAxation Here
    public function taxes()
    {
        $taxes = Taxation::get();
        return view('PanelPulse::admin.settings.taxes', ['taxes' => $taxes]);
    }
    public function taxes_detail($country)
    {
        $taxes = Taxation::where('country', $country)->first();
        return view('PanelPulse::admin.settings.taxes_edit', ['taxes' => $taxes]);
    }
    public function taxes_store($country, Request $request)
    {

        ($request->charge) ? $charge = "Yes" : $charge = "No";

        Taxation::where('country', $country)->update([
            'tax' => $request->tax,
            'charge' => $charge
        ]);
        return redirect('/admin/settings/taxes');
    }
    public function taxes_delete($id)
    {
        Taxation::where('id', $id)->delete();
        return redirect()->back();
    }
    //*TAxation End Here

    public function payments()
    {
        $payments = Payment::get();
        return view('PanelPulse::admin.settings.payments', ['payments' => $payments]);
    }

    public function payments_method()
    {
        $payments = Payment::where('payment_mode', 'Bank')->get();
        return view('PanelPulse::admin.settings.payment_method', ['payments' => $payments]);
    }

    public function payments_method_add(Request $request)
    {
        $countryArray = explode('-', "$request->country");

        Payment::create([
            'country_id' => $countryArray[0],
            'country' => $countryArray[1],
            'state' => $request->state,
            'payment_mode' => $request->mode,
            'min_order_value' => $request->min_order_value,
            'max_order_value' => $request->max_order_value
        ]);

        Taxation::create(['country' => $countryArray[1],]);

        return back();
    }

    public function payments_method_update(Request $request)
    {
        Payment::where('id', $request->id)->update([
            'state' => $request->stateUpdate,
            'payment_mode' => $request->mode,
            'min_order_value' => $request->min_order_value,
            'max_order_value' => $request->max_order_value
        ]);
        return redirect()->back();
    }

    public function payments_method_delete(Request $request)
    {
        $payment = Payment::where('id', $request->id)->first();
        Taxation::where('country', $payment->country)->delete();
        $payment->delete();
        return true;
    }

    public function theme()
    {
        $theme = ModelsThemeSetting::get();
        return view('PanelPulse::admin.settings.theme', ['theme' => $theme]);
    }

    public function theme_setting($id)
    {
        $theme = ModelsThemeSetting::find($id);
        return view('PanelPulse::admin.settings.theme-setting', ['theme' => $theme]);
    }
}
