@extends('PanelPulse::admin.layout.header')
@section('title', 'Products | ' . env('APP_NAME'))
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
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
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="filter-form" class="row g-3">
                                <div class="col-md-3">
                                    <label for="product-name-filter" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="product-name-filter" placeholder="Search by product name">
                                </div>
                                <div class="col-md-3">
                                    <label for="category-filter" class="form-label">Category</label>
                                    <select class="form-select select2" id="category-filter" name="category">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="seller-filter" class="form-label">Seller</label>
                                    <select class="form-select select2" id="seller-filter" name="seller">
                                        <option value="">All Sellers</option>
                                        @foreach($sellers as $seller)
                                            <option value="{{ $seller['id'] }}">{{ $seller['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-end justify-content-end gap-2 mb-3">
                <input type="checkbox" id="select-all-xml" class="xml-feed-toggle">
                <label class="">Select All</label>
                <button type="button" id="clear-all-xml" class="btn btn-sm btn-outline-danger">
                    Clear All XML
                </button>
            </div>

            <div class="table-responsive">
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
                            <tr class="table-row" 
                                data-category="{{ $product['product_categories'][0]['id'] ?? '' }}"
                                data-seller="{{ $product['sellers']['id'] ?? '' }}">
                                <th scope="row">#{{ $product['id'] }}</th>
                                <td>{{$product['descriptions'][0]['product_name']}}</td>
                                <td>{{$product['prices'][0]['regular_price']}}</td>
                                <td>{{$product['sku']}}</td>
                                <td>{{$product['stock']}}</td>
                                <td>{{$product['sellers']['seller_name']}}</td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2">
                                        <a href="{{route('admin.product.view',[$product['id']])}}" class="btn-primary btn-sm btn rounded px-2 small text-white border-1 border-primary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;">
                                            View
                                        </a>
                                        <a href="{{route('admin.product.delete',[$product['id']])}}" class="btn-secondary btn-sm btn rounded px-2 small text-danger border-1 border-secondary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;">
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
@endsection
@section('scriptContent')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#productsCollapse').collapse('show');

        $(document).ready(function($) {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Search...",
                allowClear: true
            });

            // Filter functionality
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                var category = $('#category-filter').val();
                var seller = $('#seller-filter').val();
                var productName = $('#product-name-filter').val().toLowerCase();

                $('.table-row').each(function() {
                    var rowCategory = $(this).data('category');
                    var rowSeller = $(this).data('seller');
                    var rowProductName = $(this).find('td:eq(0)').text().toLowerCase();
                    var show = true;

                    if (category && rowCategory != category) {
                        show = false;
                    }
                    if (seller && rowSeller != seller) {
                        show = false;
                    }
                    if (productName && !rowProductName.includes(productName)) {
                        show = false;
                    }

                    $(this).toggle(show);
                });
            });

            // Reset filters
            $('#filter-form').on('reset', function() {
                $('.table-row').show();
                $('.select2').val('').trigger('change');
                $('#product-name-filter').val('');
            });

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

            // Handle select all checkbox
            $('#select-all-xml').on('change', function() {
                var isChecked = $(this).is(':checked');
                // Only select visible checkboxes
                $('.xml-feed-toggle:visible').not(this).prop('checked', isChecked);
                
                // Get all visible product IDs
                var productIds = [];
                $('.xml-feed-toggle:visible').not(this).each(function() {
                    productIds.push($(this).data('id'));
                });

                // Send POST request for all visible products
                fetch('/admin/products/xml-feed-add', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        product_ids: productIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // toastr.success(data.message);
                    } else {
                        // Revert only visible checkboxes if failed
                        $('.xml-feed-toggle:visible').not(this).prop('checked', !isChecked);
                        // toastr.error(data.message || 'Failed to update XML feed status');
                    }
                })
                .catch(error => {
                    // Revert only visible checkboxes if failed
                    $('.xml-feed-toggle:visible').not(this).prop('checked', !isChecked);
                    // toastr.error('Error updating XML feed status');
                });
            });

            // Handle clear all button
            $('#clear-all-xml').on('click', function() {
                // Uncheck only visible checkboxes
                $('.xml-feed-toggle:visible').prop('checked', false);
                
                // Get all visible product IDs
                var productIds = [];
                $('.xml-feed-toggle:visible').not('#select-all-xml').each(function() {
                    productIds.push($(this).data('id'));
                });

                // Send POST request to remove all visible XML feeds
                fetch('/admin/products/xml-feed-add-clear', {
                    method: 'get',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // toastr.success(data.message);
                    } else {
                        // Revert only visible checkboxes if failed
                        $('.xml-feed-toggle:visible').prop('checked', true);
                        // toastr.error(data.message || 'Failed to clear XML feed status');
                    }
                })
                .catch(error => {
                    // Revert only visible checkboxes if failed
                    $('.xml-feed-toggle:visible').prop('checked', true);
                    // toastr.error('Error clearing XML feed status');
                });
            });

            // Handle XML feed toggle
            $('.xml-feed-toggle').on('change', function() {
                var productId = $(this).data('id');
                var isChecked = $(this).is(':checked');
                var $checkbox = $(this);
                
                // Skip API call for select all checkbox
                if ($(this).attr('id') === 'select-all-xml') {
                    return;
                }
                
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
