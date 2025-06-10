@extends('PanelPulse::admin.layout.header')

@section('title', 'Orders | ' . env('APP_NAME'))

@section('content')
<div class="container-fluid px-4">

    <!-- Back Button -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <h4 class="fw-bold text-back">Order Details</h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-dark shadow-sm px-4 py-2 rounded-pill">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Show Error Message if Exists -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($order))
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-white rounded-top-4" style="background: linear-gradient(45deg, #000, #000);">
            <h5 class="mb-0 fw-bold text-center">Order Number #{{ $order->order_number }}</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th class="py-3">Product Name</th>
                            <th class="py-3">SKU</th>

                            <th class="py-3">Price ($)</th>
                            <th class="py-3">Seller</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="fs-6">
                        @foreach($order->orderItems as $item)
                            <tr class="border-bottom">
                                <td class="text-truncate" style="max-width: 250px;">{{ $item->name }}</td>
                                <td class="fw-semibold">{{ $item->sku }}</td>

                                <td class="fw-bold text-success">${{ number_format($item->price, 2) }}</td>
                                <td>
                                    {{ $item->product->sellers->seller_name ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill
                                        @if($item->status == 'pending') bg-warning text-dark
                                        @elseif($item->status == 'completed') bg-success
                                        @elseif($item->status == 'canceled') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-circle"></i> No order details found.
        </div>
    @endif
</div>
@endsection
