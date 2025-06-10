@extends('PanelPulse::admin.layout.header')

@section('title', 'Edit Coupon | ' . env('APP_NAME'))

@section('content')
<form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="container">
        <div class="d-flex align-items-center">
            <h1 class="heading1">
                <a class="btn btn-secondary btn-sm px-2 me-2" href="{{ route('coupon.list') }}">
                    <i class="fas fs-6 fa-arrow-left"></i>
                </a>
                Edit Coupon
            </h1>
        </div>

        <div class="row">
            <div class="col-7">
                <div class="info-cont">

                    {{-- Coupon Code --}}
                    <div class="col-12 mb-3">
                        <label for="code" style="height: 2rem;">CODE</label>
                        <span class="badge bg-black">{{ $coupon->seller_name }}</span>
                        <x-PanelPulse::text-input
                            name="code"
                            placeholder="Enter Code"
                            value="{{ old('code', $coupon->code) }}"
                            required
                        />
                    </div>
                    {{-- Coupon Type --}}

                    <div class="col-12 mb-3">
                        <x-PanelPulse::select-dropdown
                            label="Select Coupon Type"
                            name="discount_type"
                            :options="$couponTypes"
                            :selected="$coupon->discount_type"
                            required
                        />
                    </div>

                    {{-- Discount Amount --}}
                    <div class="col-12 mb-3">
                        <x-PanelPulse::text-input
                            label="Discount Amount"
                            name="discount_amount"
                            placeholder="Enter Discount Amount"
                            value="{{ old('discount_amount', $coupon->discount_amount) }}"
                            required
                        />
                    </div>
                    <div class="col-12 mb-3">

                    <pre>{{ json_encode(json_decode($coupon->rules, true), JSON_PRETTY_PRINT) }}</pre>


                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="info-cont p-3">
                    <p>Status</p>
                    <div class="custom-control custom-checkbox">
                        {{-- Active Status --}}
                        <div class="mt-2">
                            <x-PanelPulse::radio-input
                            name="status"
                            label="Active"
                            value="1"
                            :checked="old('status', $coupon->status)"
                            />
                        </div>
                        {{-- Inactive Status --}}
                        <div class="mt-2">
                            <x-PanelPulse::radio-input
                            name="status"
                            label="Inactive"
                            value="0"
                            :checked="old('status', $coupon->status)"
                            />
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-12 d-flex justify-content-end mt-3">
                    <a class="btn btn-sm rounded-3 btn-danger bg-danger text-white px-3 me-2" href="{{ route('coupon.list') }}">
                        Cancel
                    </a>
                    <button class="btn btn-sm rounded-3 btn-dark px-3" type="submit">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
