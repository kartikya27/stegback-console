@extends('PanelPulse::admin.layout.header')
@section('title', 'Orders | ' . env('APP_NAME'))
@section('style')
<style>
    .admin-menu.orders i {
        color: black;
    }

    .admin-menu1.orders {
        background-color: #eaeaea;
        border-left: 5px solid black;
        color: black;
    }
</style>
@endsection
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
@section('content')
<div class="container">
    <h1 class="heading1">Orders</h1>
    <div class="container info-cont">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"> <a class="nav-link active" id="pills-all-tab" data-toggle="pill"
                    href="#all" role="tab" aria-controls="pills-all" aria-selected="true">All</a>
            </li>
            <li class="nav-item" role="presentation"> <a class="nav-link" id="pills-open-tab" data-toggle="pill"
                    href="#open" role="tab" aria-controls="pills-open" aria-selected="false">Open</a>
            </li>
            <li class="nav-item" role="presentation"> <a class="nav-link" id="pills-closed-tab" data-toggle="pill"
                    href="#closed" role="tab" aria-controls="pills-closed" aria-selected="false">Closed</a>
            </li>
            <li class="nav-item" role="presentation"> <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                    href="#cancelled" role="tab" aria-controls="pills-contact" aria-selected="false">Cancelled</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="pills-all-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center">Payment</th>
                            <th scope="col" class="text-center">Fulfillment</th>
                            <th scope="col" class="text-center">Items</th>
                            <th scope="col">Delivery Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr class="table-row" data-href="{{ route('admin.order', [$order['id']]) }}">
                        {{-- $order['order_number'] --}}
                            <th scope="row">#{{ $order['id'] }}</th>
                            <td>@php
                                    echo date_format($order['created_at'], 'd M');
                                    echo ' at ';
                                    echo date_format($order['created_at'], 'h:i a');
                                @endphp
                            </td>

                            <td>{{ $order['orders_customers']['name'] }}</td>
                            <td class="text-center">{{ (new CommonHelper)->price($order['grand_total']) }}</td>
                            <td class="text-center ">

                                <div class="block2 mr-0">
                                    <i class="far fa-circle"></i>
                                    {{ $order['payment']['method'] }} - {{ $order['payment']['payment_status'] }}
                                </div>
                            </td>
                            <td class="text-center">
                                
                                <div class="block2 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['status'] }}</div>
                            </td>

                            <td class="text-center">{{ $order['total_item_count'] }} </td>
                            <td>
                                @foreach($order['shippments'] as $shippments)
                                <div class="block2 mr-0">
                                    <i class="far fa-circle"></i>{{ $shippments['tracking_number'] }}
                                </div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="open" role="tabpanel" aria-labelledby="pills-open-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center">Payment</th>
                            <th scope="col" class="text-center">Fulfillment</th>
                            <th scope="col" class="text-center">Items</th>
                            <th scope="col">Delivery Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        @if (
                        $order['order_status'] == 'Reviewed' ||
                        $order['order_status'] == 'Partial Shipped' ||
                        $order['order_status'] == 'Shipped')
                        <tr class="table-row" data-href="/admin/orders/{{ $order['id'] }}">
                            <th scope="row">#{{ $order['id'] }}</th>
                            <td>@php
                                echo date_format($order['created_at'], 'd M');
                                echo ' at ';
                                echo date_format($order['created_at'], 'h:i a');
                                @endphp</td>
                            <td>{{ $order['first_name'] }} {{ $order['last_name'] }}</td>
                            <td class="text-center">EUR @php echo number_format($order['total_amount']) @endphp</td>
                            <td class="text-center">
                                @if ($order['payment_status'] == 'Paid')
                                <div class="block1"><i
                                        class="fas fa-circle"></i>{{ $order['payment_status'] }}</div>
                                @else
                                <div class="block2"><i
                                        class="far fa-circle"></i>{{ $order['payment_status'] }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($order['order_status'] == 'Fulfilled')
                                <div class="block1 mr-0"><i
                                        class="fas fa-circle"></i>{{ $order['order_status'] }}</div>
                                @elseif($order['order_status'] == 'Shipped')
                                <div class="block3 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['order_status'] }}</div>
                                @elseif($order['order_status'] == 'Cancelled')
                                <div class="block5 mr-0"><i
                                        class="fas fa-circle"></i>{{ $order['order_status'] }}</div>
                                @else
                                <div class="block2 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['order_status'] }}</div>
                                @endif
                            </td>
                            @php
                                $noOfItems = 0;
                                for ($i = 0; $i < count($order); $i++) {
                                    $noOfItems +=$order[$i]['product_quantity'];
                                    }
                            @endphp
                            <td class="text-center">{{ $noOfItems }}</td>
                            <td>{{ $order['shipping_name'] }}</td>
                            <td>
                                View
                                <i class="far fa-eye"></i>
                            </td>
                                
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="closed" role="tabpanel" aria-labelledby="pills-closed-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center">Payment</th>
                            <th scope="col" class="text-center">Fulfillment</th>
                            <th scope="col" class="text-center">Items</th>
                            <th scope="col">Delivery Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        @if ($order['order_status'] == 'Fulfilled')
                        <tr class="table-row" data-href="/admin/orders/{{ $order['id'] }}">
                            <th scope="row">#{{ $order['id'] }}</th>
                            <td>@php
                                echo date_format($order['created_at'], 'd M');
                                echo ' at ';
                                echo date_format($order['created_at'], 'h:i a');
                                @endphp</td>
                            <td>{{ $order['first_name'] }} {{ $order['last_name'] }}</td>
                            <td class="text-center">EUR @php echo number_format($order['total_amount']) @endphp</td>
                            <td class="text-center">
                                @if ($order['payment_status'] == 'Paid')
                                <div class="block1"><i
                                        class="fas fa-circle"></i>{{ $order['payment_status'] }}</div>
                                @else
                                <div class="block2"><i
                                        class="far fa-circle"></i>{{ $order['payment_status'] }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($order['order_status'] == 'Fulfilled')
                                <div class="block1 mr-0"><i
                                        class="fas fa-circle"></i>{{ $order['order_status'] }}</div>
                                @elseif($order['order_status'] == 'Shipped')
                                <div class="block3 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['order_status'] }}</div>
                                @elseif($order['order_status'] == 'Cancelled')
                                <div class="block5 mr-0"><i
                                        class="fas fa-circle"></i>{{ $order['order_status'] }}</div>
                                @else
                                <div class="block2 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['order_status'] }}</div>
                                @endif
                            </td>
                            @php
                            $noOfItems = 0;
                            for ($i = 0; $i < count($order); $i++) {
                                $noOfItems +=$order[$i]['product_quantity'];
                                }
                                @endphp
                                <td class="text-center">{{ $noOfItems }}</td>
                                <td>{{ $order['shipping_name'] }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="pills-contact-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center">Payment</th>
                            <th scope="col" class="text-center">Fulfillment</th>
                            <th scope="col" class="text-center">Items</th>
                            <th scope="col">Delivery Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        @if ($order['order_status'] == 'Cancelled')
                        <tr class="table-row" data-href="/admin/orders/{{ $order['id'] }}">
                            <th scope="row">#{{ $order['id'] }}</th>
                            <td>@php
                                echo date_format($order['created_at'], 'd M');
                                echo ' at ';
                                echo date_format($order['created_at'], 'h:i a');
                                @endphp</td>
                            <td>{{ $order['first_name'] }} {{ $order['last_name'] }}</td>
                            <td class="text-center">EUR @php echo number_format($order['total_amount']) @endphp</td>
                            <td class="text-center">
                                @if ($order['payment_status'] == 'Paid')
                                <div class="block1"><i
                                        class="fas fa-circle"></i>{{ $order['payment_status'] }}</div>
                                @else
                                <div class="block2"><i
                                        class="far fa-circle"></i>{{ $order['payment_status'] }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($order['order_status'] == 'Fulfilled')
                                <div class="block1 mr-0"><i
                                        class="fas fa-circle"></i>{{ $order['order_status'] }}</div>
                                @elseif($order['order_status'] == 'Shipped')
                                <div class="block3 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['order_status'] }}</div>
                                @elseif($order['order_status'] == 'Cancelled')
                                <div class="block5 mr-0"><i
                                        class="fas fa-circle"></i>{{ $order['order_status'] }}</div>
                                @else
                                <div class="block2 mr-0"><i
                                        class="far fa-circle"></i>{{ $order['order_status'] }}</div>
                                @endif
                            </td>
                            @php
                            $noOfItems = 0;
                            for ($i = 0; $i < count($order); $i++) {
                                $noOfItems +=$order[$i]['product_quantity'];
                                }
                                @endphp
                                <td class="text-center">{{ $noOfItems }}</td>
                                <td>{{ $order['shipping_name'] }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptContent')
<script>
    $('#ordersCollapse').collapse('show');

    $(document).ready(function($) {
        $(".table-row").click(function() {
            window.document.location = $(this).data("href");
        });
    });

    if (document.URL.indexOf("#open") >= 0) {
        document.getElementById('pills-open-tab').click();
    }
</script>
@endsection