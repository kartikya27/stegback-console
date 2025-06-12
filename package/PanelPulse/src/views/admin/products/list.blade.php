@extends('PanelPulse::admin.layout.header')
@section('title', 'Products | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.settings {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }

        .tree {
            --spacing: 1.5rem;
            --radius: 10px;
        }

        .tree li {
            display: block;
            position: relative;
            padding-left: calc(2 * var(--spacing) - var(--radius) - 2px);
        }

        .tree ul {
            margin-left: calc(var(--radius) - var(--spacing));
            padding-left: 0;
        }

        .tree ul li {
            border-left: 2px solid #ddd;
        }

        .tree ul li:last-child {
            border-color: transparent;
        }

        .tree ul li::before {
            content: '';
            display: block;
            position: absolute;
            top: calc(var(--spacing) / -2);
            left: -2px;
            width: calc(var(--spacing) + 2px);
            height: calc(var(--spacing) + 1px);
            border: solid #ddd;
            border-width: 0 0 2px 2px;
        }

        .tree summary {
            display: block;
            cursor: pointer;
        }

        .tree summary::marker,
        .tree summary::-webkit-details-marker {
            display: none;
        }

        .tree summary:focus {
            outline: none;
        }

        .tree summary:focus-visible {
            outline: 1px dotted #000;
        }

        .tree li::after,
        .tree summary::before {
            content: '';
            display: block;
            position: absolute;
            top: calc(var(--spacing) / 2 - var(--radius));
            left: calc(var(--spacing) - var(--radius) - 1px);
            width: calc(2 * var(--radius));
            height: calc(2 * var(--radius));
            border-radius: 50%;
            background: #ddd;
        }


        .tree details[open]>summary::before {
            background-position: calc(-2 * var(--radius)) 0;
        }


        .tree li {
            padding-left: calc(1.5rem + 16px); /* Tweak spacing here */
            margin-bottom: 8px; /* Adjust vertical spacing */
        }
        .tree summary:hover a {
            visibility: visible;
        }

        .tree summary a {
            visibility: hidden;
        }
    </style>
@endsection
@section('content')

@section('content')
    <div class="container">

    <div class="header header d-flex align-items-center justify-content-between mb-3">
        <h1 class="heading1 mb-0">Products</h1>
        <a class="btn btn-sm rounded-3 btn-dark px-3" href="{{route('admin.products.xml')}}">Genrate XML Feeds</a>
    </div>

        <div class="container info-cont">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation"> <a class="nav-link active" id="pills-all-tab" data-toggle="pill"
                        href="#all" role="tab" aria-controls="pills-all" aria-selected="true">All</a>
                </li>
                <li class="nav-item" role="presentation"> <a class="nav-link" id="pills-open-tab" data-toggle="pill"
                        href="#open" role="tab" aria-controls="pills-open" aria-selected="false">Drafted</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col" class="text-center">Sku</th>
                                <th scope="col" class="text-center">Qty</th>
                                <th scope="col" class="text-center">Seller</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="table-row">
                                    <th scope="row">#{{ $product['id'] }}</th>
                                    <td>{{$product['descriptions'][0]['product_name']}}</td>
                                    <td>{{$product['prices'][0]['regular_price']}}</td>
                                    <td>{{$product['sku']}}</td>
                                    <td>{{$product['stock']}}</td>
                                    <td>{{$product['sellers']['seller_name']}}</td>
                                    <td  class="align-middle">
                                        <div class="d-flex gap-2">
                                            <a href="{{route('admin.product.view',[$product['id']])}}" class="btn-primary btn-sm btn  rounded px-2 small text-white border-1 border-primary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;">
                                                View
                                            </a>
                                            <a href="{{route('admin.product.delete',[$product['id']])}}" class="btn-secondary btn-sm btn  rounded px-2 small text-danger border-1 border-secondary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;">
                                                Delete
                                            </a>
                                            <div class="item-align-center d-flex">
                                                <input type="checkbox" name="xml" value="{{$product['id']}}" 
                                                    class="xml-feed-toggle" 
                                                    data-id="{{$product['id']}}"
                                                    {{ isset($product['xml_data']) && $product['xml_data'] ? 'checked' : '' }}>
                                                <label class="m-1">XML</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
        $('#productsCollapse').collapse('show');

        $(document).ready(function($) {
            // Prevent row click when clicking checkbox
            $('.xml-feed-toggle').on('click', function(e) {
                e.stopPropagation();
            });

            // Handle row click for other areas
            $(".table-row").click(function(e) {
                if (!$(e.target).is('.xml-feed-toggle')) {
                    window.document.location = $(this).data("href");
                }
            });

            // Handle XML feed toggle
            $('.xml-feed-toggle').on('change', function() {
                var productId = $(this).data('id');
                var isChecked = $(this).is(':checked');
                var $checkbox = $(this);
                
                fetch('/admin/products/xml-feed-add/' + productId, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // toastr.success(data.message);
                    } else {
                        // Revert checkbox if failed
                        $checkbox.prop('checked', !isChecked);
                        // toastr.error(data.message || 'Failed to update XML feed status');
                    }
                })
                .catch(error => {
                    // Revert checkbox if failed
                    $checkbox.prop('checked', !isChecked);
                    // toastr.error('Error updating XML feed status');
                });
            });
        });

        if (document.URL.indexOf("#open") >= 0) {
            document.getElementById('pills-open-tab').click();
        }
    </script>
@endsection
