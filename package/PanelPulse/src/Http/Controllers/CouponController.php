<?php

namespace Kartikey\PanelPulse\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kartikey\PanelPulse\Models\Coupon;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the coupons.
     */
    public function index()
    {
        $coupons = Coupon::paginate(10); // Using pagination for better performance
        return view('PanelPulse::admin.coupons.index', ['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        $couponTypes = Coupon::TYPES;
        return view('PanelPulse::admin.coupons.create', ['couponTypes' => $couponTypes]);
    }

    /**
     * Store a newly created coupon in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ], [
            'code.required' => 'The coupon code is required.',
            'code.unique' => 'This coupon code has already been taken. Please use a different code.',
            'discount_type.required' => 'Please select a coupon type.',
            'discount_amount.required' => 'The discount amount is required.',
            'discount_amount.numeric' => 'The discount amount must be a valid number.',
            'discount_amount.min' => 'The discount amount must be at least 0.',
            'status.required' => 'Please select a status.',
            'status.boolean' => 'The status must be either active or inactive.',
        ]);

        Coupon::create($validatedData);

        return redirect()->route('coupon.list')->with('success', 'Coupon created successfully.');
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $sellerName = $coupon->seller->seller_name;
        $coupon['seller_name'] = $sellerName;
        $couponTypes = Coupon::TYPES;

        return view('PanelPulse::admin.coupons.edit', [
            'coupon' => $coupon,
            'couponTypes' => $couponTypes,
        ]);
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validatedData = $request->validate([
            'code' => "required|unique:coupons,code,{$id}",
            'discount_type' => 'required',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ], [
            'code.required' => 'The coupon code is required.',
            'code.unique' => 'This coupon code has already been taken. Please use a different code.',
            'discount_type.required' => 'Please select a coupon type.',
            'discount_amount.required' => 'The discount amount is required.',
            'discount_amount.numeric' => 'The discount amount must be a valid number.',
            'discount_amount.min' => 'The discount amount must be at least 0.',
            'status.required' => 'Please select a status.',
            'status.boolean' => 'The status must be either active or inactive.',
        ]);

        $coupon->update($validatedData);

        return redirect()->route('coupon.list')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function delete($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return redirect()->route('coupon.list')->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('coupon.list')->with('error', 'Failed to delete the coupon.');
        }
    }
}
