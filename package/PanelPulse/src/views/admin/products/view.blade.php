@extends('PanelPulse::admin.layout.header')
@section('title', 'Products View | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.products {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }

        .info-cont {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .product-header {
            padding: 1rem 0;
            border-bottom: 1px solid #e5e5e5;
            margin-bottom: 2rem;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: #212B36;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            background: #F4F6F8;
            color: #637381;
        }

        .status-badge i {
            margin-right: 0.5rem;
        }

        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .media-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e5e5;
            aspect-ratio: 1;
        }

        .media-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #212B36;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #212B36;
            margin-bottom: 0.5rem;
        }

        .sales-channels {
            margin-top: 1rem;
        }

        .channel-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .channel-item:last-child {
            border-bottom: none;
        }

        .channel-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        }

        .description-textarea {
            width: 100%;
            min-height: 150px;
            max-height: 300px;
            overflow-y: auto;
            padding: 1rem;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            resize: vertical;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .description-preview {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 1rem;
            margin-top: 1rem;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid px-4">
        <!-- Product Header -->
        <div class="product-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-icon" onclick="window.location.href='/admin/products/list'">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1 class="product-title">{{@$product->descriptions[0]->product_name}}</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="status-badge">
                    <i class="far fa-circle"></i>
                    {{ $product->listing_type }}
                </span>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Title Section -->
                        <div class="form-section">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" value="{{@$product->descriptions[0]->product_name}}">
                            </div>
                        </div>


                        <!-- Pricing Section -->
                        <div class="form-section">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Regular Pricing</label>
                                        <input type="text" class="form-control" placeholder="Regular price" value="{{@$product->prices[0]['regular_price']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sale Price (if any)</label>
                                        <input type="text" class="form-control" placeholder="Compare at price" value="{{@$product->prices[0]['sale_price']}}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Media Section -->
                        <div class="form-section">
                            <div class="form-group">
                                <label class="form-label">Media</label>
                                <div class="media-grid">
                                    @if(!empty($product->images[0]['gallery_image']))
                                        @foreach($product->images[0]['gallery_image'] as $image)
                                            <div class="media-item">
                                                <img src="{{ $image }}" alt="Product Image">
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="media-item d-flex align-items-center justify-content-center" style="background: #F4F6F8">
                                        <button class="btn btn-light">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="form-section">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <div class="description-textarea" contenteditable="true">
                                    {!! $product->descriptions[0]?->html !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3">
                <!-- Status Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="form-section-title">Status</h6>
                        <select class="form-select">
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Sales Channels -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="form-section-title">Sales channels</h6>
                        <div class="sales-channels">
                            <div class="channel-item">
                                <i class="fas fa-shopping-bag channel-icon"></i>
                                <span>Online Store</span>
                            </div>
                            <div class="channel-item">
                                <i class="fab fa-google channel-icon"></i>
                                <span>Google & YouTube</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="form-section-title">Product organization</h6>
                        <div class="form-group">
                            <label class="form-label">Product type</label>
                            <input type="text" class="form-control" value="{{$product->product_categories[0]['name']}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Vendor</label>
                            <input type="text" class="form-control" value="{{$product->sellers ? $product->sellers->seller_name : ''}}">
                        </div>
                    </div>
                </div>

                <!-- Ratings & Reviews -->
                @if($product->ratings->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="form-section-title">Ratings & Reviews</h6>
                        <div class="rating-summary">
                            <div class="d-flex align-items-center gap-4">
                                <div class="text-center">
                                    <div class="h2 mb-0">{{ number_format($product->ratings->avg('ratings'), 1) }}</div>
                                    <div class="rating-stars mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $product->ratings->avg('ratings') ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ $product->ratings->count() }} reviews</small>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="text-muted me-2" style="width: 40px;">5</div>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            @php
                                                $fiveStars = $product->ratings->where('ratings', 5)->count();
                                                $percentage = $product->ratings->count() > 0 ? ($fiveStars / $product->ratings->count()) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-muted ms-2" style="width: 40px;">{{ $fiveStars }}</div>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="text-muted me-2" style="width: 40px;">4</div>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            @php
                                                $fourStars = $product->ratings->where('ratings', 4)->count();
                                                $percentage = $product->ratings->count() > 0 ? ($fourStars / $product->ratings->count()) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-muted ms-2" style="width: 40px;">{{ $fourStars }}</div>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="text-muted me-2" style="width: 40px;">3</div>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            @php
                                                $threeStars = $product->ratings->where('ratings', 3)->count();
                                                $percentage = $product->ratings->count() > 0 ? ($threeStars / $product->ratings->count()) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-muted ms-2" style="width: 40px;">{{ $threeStars }}</div>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="text-muted me-2" style="width: 40px;">2</div>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            @php
                                                $twoStars = $product->ratings->where('ratings', 2)->count();
                                                $percentage = $product->ratings->count() > 0 ? ($twoStars / $product->ratings->count()) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-muted ms-2" style="width: 40px;">{{ $twoStars }}</div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="text-muted me-2" style="width: 40px;">1</div>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            @php
                                                $oneStar = $product->ratings->where('ratings', 1)->count();
                                                $percentage = $product->ratings->count() > 0 ? ($oneStar / $product->ratings->count()) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-muted ms-2" style="width: 40px;">{{ $oneStar }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

