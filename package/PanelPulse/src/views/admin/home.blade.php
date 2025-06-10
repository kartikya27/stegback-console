@extends('PanelPulse::admin.layout.header')
@section('title', 'Console stegback | Admin CRM and Product management tool Panel | Pulse')
@section('style')
    <style>
        .admin-main-cont {
            padding: 0 15px;
        }

        .admin-menu.home {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }
    </style>
    <style>
    .admin-menu.sellers i {
        color: black;
    }

    .admin-menu1.sellers {
        background-color: #eaeaea;
        border-left: 5px solid black;
        color: black;
    }

    .date-range-picker {
        border: 1px solid #e5e5e5;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .stats-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .stats-card:hover {
        transform: translateY(-2px);
    }

    .stats-card h3 {
        color: #637381;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .stats-card .value {
        font-size: 1.5rem;
        font-weight: 600;
        color: #212B36;
    }

    .table th {
        font-weight: 600;
        color: #637381;
        background-color: #F4F6F8;
    }

    .table td {
        vertical-align: middle;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge.completed {
        background-color: #E8F5E9;
        color: #2E7D32;
    }

    .status-badge.pending {
        background-color: #FFF3E0;
        color: #E65100;
    }

    .breakdown-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #e5e5e5;
    }

    .breakdown-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .breakdown-item:last-child {
        border-bottom: none;
    }

    .breakdown-label {
        color: #637381;
    }

    .breakdown-value {
        font-weight: 500;
        color: #212B36;
    }

    .chart-card {
        background: #fff;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .chart-container {
        height: 250px;
        position: relative;
    }

    .chart-container.small {
        height: 200px;
    }

    .chart-title {
        font-size: 0.9rem;
        color: #637381;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .view-more-btn {
        color: #2196F3;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .view-more-btn:hover {
        color: #1976D2;
    }

    .performance-metric {
        padding: 1rem;
        border-radius: 8px;
        background: #F8FAFC;
        margin-bottom: 1rem;
    }

    .performance-metric h4 {
        font-size: 0.875rem;
        color: #637381;
        margin-bottom: 0.5rem;
    }

    .performance-metric .value {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212B36;
    }

    .progress {
        height: 6px;
        margin-top: 0.5rem;
    }

    .stats-card .trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .stats-card .trend.positive {
        color: #2E7D32;
    }

    .stats-card .trend.negative {
        color: #D32F2F;
    }

    .product-name-tooltip {
        position: relative;
        display: inline-block;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-name-tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 4px;
        font-size: 0.75rem;
        white-space: normal;
        z-index: 1000;
        max-width: 300px;
        text-align: center;
    }

    .bi-info-circle[data-tooltip] {
        position: relative;
        cursor: pointer;
    }
    .bi-info-circle[data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 4px;
        font-size: 0.75rem;
        white-space: normal;
        z-index: 1000;
        max-width: 300px;
        text-align: center;
    }
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-8 home-left">
            <p>Here's what's happening with your store today.</p>
            <div class="row">
                <div class="col-6">
                    <div class="stats-card">
                        <h3 class="info-cont-heading">Total Sales</h3>
                        <p class="value mb-0 fs-6">
                            @if (@$todayOrders['totalSales'] > 0)
                                EUR @php echo number_format(@$todayOrders['totalSales']) @endphp
                            @else
                                No sales yet
                            @endif
                        </p>
                        <div class="info-cont-divider"></div>
                        <p class="value mb-0 fs-6">
                            @if (@$todayOrders['noOfOrders'] > 0)
                                {{ @$todayOrders['noOfOrders'] }} orders
                            @else
                                No orders yet
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stats-card">
                        <h3 class="info-cont-heading">Total Abandoned Checkouts</h3>
                        <p class="value mb-0 fs-6">
                            @if (@$todayCheckouts['totalCheckouts'] > 0)
                                EUR @php echo number_format(@$todayCheckouts['totalCheckouts']) @endphp
                            @else
                                No checkout yet
                            @endif
                        </p>
                        <div class="info-cont-divider"></div>
                        <p class="value mb-0 fs-6">
                            @if (@$todayCheckouts['noOfCheckouts'] > 0)
                                {{ @$todayCheckouts['noOfCheckouts'] }} orders
                            @else
                                No checkout yet
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            


            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="stats-card h-100">
                        <h3>Total Orders</h3>
                        <div class="value">2</div>
                        <div class="trend positive">
                            <i class="bi bi-graph-up"></i>
                            <span>95% vs last month</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card h-100">
                        <h3>Platform Fees</h3>
                        <div class="value">5989</div>
                        <div class="trend positive">
                            <i class="bi bi-graph-up"></i>
                            <span>95% vs last month</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card h-100">
                        <h3>Total Sales Volume</h3>
                        <div class="value">5989</div>
                        <div class="trend positive">
                            <i class="bi bi-graph-up"></i>
                            <span>95% vs last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="chart-card">
                    <h3 class="chart-title">Sales Trend</h3>
                    <div class="chart-container">
                        <!-- Placeholder for future chart implementation -->
                    </div>
                </div>
            </div>

            <div class="mt-3">
                @if (@$noOfUnfulfillOrders > 0)
                    <a href="/admin/orders" style="text-decoration:none;color:#626262;">
                        <div class="container info-cont">
                            <div class="row">
                                <div class="col-9">
                                    <p class="info-cont-heading mb-0"><i
                                            class="fas fa-download mr-3"></i>{{ @$noOfUnfulfillOrders }} orders to fulfill</p>
                                </div>
                                <div class="col-3">
                                    <p class="info-cont-heading text-end mb-0"><i class="fas fa-chevron-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-4 home-right">
            <form class="needs-validation" novalidate>
                <div class="form-row">
                    <div class="col-12">
                        <select class="custom-select">
                            <option value="All Time" selected>All Time</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="info-cont-divider"></div>
            <h3 class="info-cont-subheading">Total sales</h3>
            <p class="mb-0">
                @if (@$orders['totalSales'] > 0)
                    EUR @php echo number_format(@$orders['totalSales']) @endphp
                @else
                    No orders yet
                @endif
            </p>
            <div class="info-cont-divider"></div>
            <h3 class="info-cont-subheading">Total no. of orders</h3>
            <p class="mb-0">
                @if (@$orders['noOfOrders'] > 0)
                    {{ @$orders['noOfOrders'] }} orders
                @else
                    No orders yet
                @endif
            </p>
            <div class="info-cont-divider"></div>
            <h3 class="info-cont-subheading">Platform Fees Earning</h3>
            <p class="mb-0">
               547874$
            </p>
            <div class="info-cont-divider"></div>
            <h3 class="info-cont-subheading">Total no. of abandoned checkouts</h3>
            <p class="mb-0">
                @if (@$checkouts['noOfCheckouts'] > 0)
                    {{ @$checkouts['noOfCheckouts'] }} checkouts
                @else
                    No abandoned checkout yet
                @endif
            </p>
 
        </div>
    </div>
@endsection
@section('scriptContent')
@endsection
@section('endscripts')
@endsection
