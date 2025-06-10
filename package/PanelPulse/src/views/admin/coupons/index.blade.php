@extends('PanelPulse::admin.layout.header')
@section('title', 'Coupons | ' . env('APP_NAME'))

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

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="heading1">Coupons</h1>
            <a href="{{ route('coupon.create') }}" class="btn btn-sm rounded-3 btn-dark px-3">
                Add Coupon
            </a>
        </div>
        <div class="container info-cont mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Sr No</th>
                        <th scope="col" class="text-center">Code</th>
                        <th scope="col" class="text-center">Coupon Type</th>
                        <th scope="col" class="text-center">Discount Amount</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                    <tr class="table-row">
                        <th scope="row" class="text-center">#{{ $coupon['id'] }}</th>
                        <td class="text-center">{{ $coupon['code'] }}</td>
                        <td class="text-center">{{ $coupon['discount_type'] }}</td>
                        <td class="text-center">{{ $coupon['discount_amount'] }}</td>
                        <td class="text-center">

                            @if ($coupon['status'] === 1)
                                <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">InActive</span>

                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Edit Button -->
                            <a class="btn-secondary btn-sm btn  rounded px-2 small text-primary border-1 border-secondary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;" href="{{ route('coupon.edit', $coupon['id']) }}">
                                Edit
                            </a>

                            <!-- Delete Form -->
                            <form action="{{ route('coupon.delete', $coupon['id']) }}" method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-secondary btn-sm btn  rounded px-2 small text-danger border-1 border-secondary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
