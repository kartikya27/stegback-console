@extends('PanelPulse::admin.layout.header')
@section('title', 'Payment Methods | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.settings {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="container mb-4">
            <div class="row">
                <div class="col-md-1">
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-11 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">Payment providers</h2>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <h3 class="info-cont-heading mb-3">Payment providers</h3>
                    <p class="subtext1">Accept payments on your store using providers like Razorpay, third-party services,
                        or other payment methods.</p>
                    <p class="subtext1" style="margin-bottom:5px;">Your store accepts payments with:</p>
                    <p class="subtext1"><b>Razorpay & Bank Transfer</b></p>
                </div>
                <div class="col-8">
                    <div class="container info-cont">
                        <div class="row mb-5">
                            <div class="col-3">
                                <img class="img-fluid" src="{{ asset('images/razorpay-logo.svg') }}" />
                            </div>
                            <div class="col-9 text-right">
                                <a href="https://dashboard.razorpay.com/#/access/signin" target="_blank">Manage</a>
                            </div>
                        </div>
                        <h3 class="info-cont-heading mb-3">Accepted payments</h3>
                        <p>
                            <img style="width:50px;height:auto;border:1px solid #dddddd;border-radius:0.25rem;margin-right:8px;"
                                src="https://cdn.shopify.com/shopifycloud/web/assets/v1/52d3db0594f3166f0aa9898a71d01a22.svg"
                                alt="Visa" title="Visa" />
                            <img style="width:50px;height:auto;border:1px solid #dddddd;border-radius:0.25rem;margin-right:8px;"
                                src="https://cdn.shopify.com/shopifycloud/web/assets/v1/b07d7f70cd57ff74e7e2827f124bd756.svg"
                                alt="Mastercard" title="Mastercard" />
                            <img style="width:50px;height:auto;border:1px solid #dddddd;border-radius:0.25rem;margin-right:8px;"
                                src="https://cdn.shopify.com/shopifycloud/web/assets/v1/868f649ba292cb0f874389ea83bf757d.svg"
                                alt="Maestro" title="Maestro" />
                        </p>
                    </div>
                    <div class="container info-cont">
                        <div class="row mb-0">
                            <div class="col-6">
                                <p class="heading2">Bank Transfer - {{ count($payments->where('payment_mode', 'Bank')) }}
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('admin.settings.payments.methods') }}">Manage</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptContent')
@endsection
