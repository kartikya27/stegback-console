@extends('PanelPulse::admin.layout.header')
@section('title', 'Coupon create | ' . env('APP_NAME'))
@section('style')

@endsection

@section('content')
<form action="{{route('coupon.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="container">
    <div class="">
        <div class="d-flex align-items-center">
            <h1 class="heading1"><a class="btn btn-secondary btn-sm px-2 me-2" href="{{route('slider.list')}}" ><i class="fas fs-6 fa-arrow-left"></i></a>Add Coupons</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-7">

            <div class="info-cont">

                <div class="col-12 mb-3">
                    <x-PanelPulse::text-input label="CODE" name="code" placeholder="Enter Code" required />
                </div>
                <div class="col-12 mb-3">
                    <x-PanelPulse::select-dropdown label="Select Coupon Type" name="discount_type" :options="$couponTypes" required />
                </div>
                <div class="col-12 mb-3">
                    <x-PanelPulse::text-input label="Discount Amount" name="discount_amount" placeholder="Enter Discount Amount" required />
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="info-cont p-3">
                Status
                <div class="custom-control custom-checkbox">
                    <div class="mt-2">
                        <x-PanelPulse::radio-input class="me-2" type="radio" name="status" label="Active" value="1" :extraAttributes="['checked' => 'checked']" />
                    </div>
                    <div class="mt-2">
                        <x-PanelPulse::radio-input type="radio" class="me-2" name="status" label="InActive" value="0" />
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-sm rounded-3 btn-danger bg-danger text-white px-3 me-2" href="{{route('slider.list')}}">Cancel</a>
                <button class="btn btn-sm rounded-3 btn-dark px-3" type="submit">Save</button>
            </div>

        </div>
    </div>


</div>
</form>

@endsection
