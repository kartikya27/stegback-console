@extends('PanelPulse::admin.layout.header')
@section('title', 'Sellers | ' . env('APP_NAME'))
@push('style')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@section('style')
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
<div class="container-fluid px-4">
    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Sales Report - {{ $seller->seller_name }}</h1>
        <div class="d-flex gap-3">
            <div class="date-range-picker">
                <i class="bi bi-calendar3"></i>
                <span id="dateRange">{{ $date_range['start']->format('M d, Y') }} - {{ $date_range['end']->format('M d, Y') }}</span>
            </div>

            <button class="btn btn-sm rounded-3 btn-dark px-3" onclick="window.location.href='{{ route('admin.sellers.downloadSalesReport', $seller->id) }}'">
                <i class="bi bi-download me-2"></i>Download Report
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stats-card h-100">
                <h3>Total Sales</h3>
                <div class="value">€{{ number_format($total_sales, 2) }}</div>
                <div class="trend {{ $total_sales > 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>{{ $last_month_sales > 0 ? number_format(($total_sales / $last_month_sales - 1) * 100, 1) : ($total_sales > 0 ? '100.0' : '0.0') }}% vs last month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <h3>Total Orders</h3>
                <div class="value">{{ $total_orders }}</div>
                <div class="trend {{ $total_orders > 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>{{ $last_month_orders > 0 ? number_format(($total_orders / $last_month_orders - 1) * 100, 1) : ($total_orders > 0 ? '100.0' : '0.0') }}% vs last month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <h3>Average Order Value</h3>
                <div class="value">€{{ number_format($average_order_value, 2) }}</div>
                <div class="trend {{ $average_order_value > 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>{{ $last_month_aov > 0 ? number_format(($average_order_value / $last_month_aov - 1) * 100, 1) : ($average_order_value > 0 ? '100.0' : '0.0') }}% vs last month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <h3>Net Profit
                    <i class="bi bi-info-circle" data-toggle="tooltip" data-placement="top" title="Expenses include: Shipping Costs, Returns/Refunds, and other operational costs. Note: Tax and Platform Fees are calculated separately."></i>
                </h3>
                <div class="value">€{{ number_format($net_profit, 2) }}</div>
                <small class="text-muted">(Gross Sales - Total Expenses)</small>
                <div class="trend {{ $net_profit > 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>{{ $last_month_profit > 0 ? number_format(($net_profit / $last_month_profit - 1) * 100, 1) : ($net_profit > 0 ? '100.0' : '0.0') }}% vs last month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <h3>Platform Fees</h3>
                <div class="value">-€{{ number_format($price_breakdown['platform_fees'], 2) }}</div>
                <small class="text-muted">7.5% of Gross Sales</small>
            </div>
        </div>
    </div>

    <!-- Charts & Analytics -->
    <div class="row mb-4">
        <!-- Sales Trend Chart -->
        <div class="col-md-8">
            <div class="chart-card h-100">
                <h5 class="mb-3">Sales Trend</h5>
                <div class="chart-container">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="col-md-4">
            <div class="chart-card h-100">
                <h5 class="mb-3">Performance Metrics</h5>
                
                <div class="performance-metric">
                    <h4>Conversion Rate</h4>
                    <div class="value">{{ $total_orders > 0 ? number_format(($total_orders / $seller->products->count()) * 100, 1) : '0.0' }}%</div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $total_orders > 0 ? ($total_orders / $seller->products->count()) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="performance-metric">
                    <h4>Average Order Value</h4>
                    <div class="value">€{{ $average_order_value > 0 ? number_format($average_order_value, 2) : '0.0' }}</div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: {{ $average_order_value > 0 ? min(($average_order_value / 200) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>

                <div class="performance-metric">
                    <h4>Profit Margin</h4>
                    <div class="value">{{ $total_sales > 0 ? number_format(($net_profit / $total_sales) * 100, 1) : '0.0' }}%</div>
                    <small class="text-muted">(Net Profit / Total Sales) * 100</small>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $total_sales > 0 ? ($net_profit / $total_sales) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Performance -->
    <div class="row mb-4">
        <!-- Top Products Chart -->
        <div class="col-md-6">
            <div class="chart-card h-100">
                <h5 class="chart-title">Top Products</h5>
                <div class="chart-container small">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales by Category -->
        <div class="col-md-6">
            <div class="chart-card h-100">
                <h5 class="chart-title">Sales by Category</h5>
                <div class="chart-container small">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Price Breakdown -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Price Breakdown</h5>
                </div>  
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Gross Sales</span>
                                <span class="breakdown-value">€{{ number_format($price_breakdown['gross_sales'], 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Platform Fees (7.5%)</span>
                                <span class="breakdown-value">-€{{ number_format($price_breakdown['platform_fees'], 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Tax</span>
                                <span class="breakdown-value">-€{{ number_format($price_breakdown['tax'], 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Shipping Costs</span>
                                <span class="breakdown-value">-€{{ number_format($price_breakdown['shipping_costs'], 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Returns/Refunds</span>
                                <span class="breakdown-value">-€{{ number_format($price_breakdown['returns_refunds'], 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Net Profit</span>
                                <span class="breakdown-value">€{{ number_format($price_breakdown['net_profit'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Orders</h5>
                    <a href="/admin/sellers/orders" class="view-more-btn">
                        View All Orders
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}/{{ $order->order->order_number }}</td>
                                    <td>
                                        <div class="product-name-tooltip" data-tooltip="{{ $order->items->first()->orderItem->name ?? 'N/A' }}">
                                            {{ $order->items->first()->orderItem->sku ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>{{ $order->order->customer_name ?? 'N/A' }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>€{{ number_format($order->calculateVendorTotals()['total_price'], 2) }}</td>
                                    <td>
                                        <span class="status-badge {{ $order->status === 'completed' ? 'completed' : 'pending' }}">
                                            {{ $order->order->getStatusLabel() }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptContent')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(function() {
    // Date Range Picker
    $('#dateRange').daterangepicker({
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment('{{ $date_range['start']->format('Y-m-d') }}'),
        endDate: moment('{{ $date_range['end']->format('Y-m-d') }}')
    }, function(start, end, label) {
        $('#dateRange').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        window.location.href = `/admin/sellers/{{ $seller->id }}/sales-report?start=${start.format('Y-m-d')}&end=${end.format('Y-m-d')}`;
    });

    // Sales Trend Chart
    new Chart(document.getElementById('salesTrendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($sales_trend->pluck('date')) !!},
            datasets: [
                {
                    label: 'Sales Count',
                    data: {!! json_encode($sales_trend->pluck('count')) !!},
                    borderColor: '#2196F3',
                    tension: 0.1,
                    fill: false
                },
                {
                    label: 'Sales Volume',
                    data: {!! json_encode($sales_trend->pluck('amount')) !!},
                    borderColor: '#4CAF50',
                    tension: 0.1,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });

    // Top Products Chart
    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($top_products->keys()) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($top_products->pluck('revenue')) !!},
                backgroundColor: '#2196F3'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($sales_by_category->keys()) !!},
            datasets: [{
                data: {!! json_encode($sales_by_category->values()) !!},
                backgroundColor: [
                    '#2196F3',
                    '#4CAF50',
                    '#FFC107',
                    '#9C27B0',
                    '#FF5722'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});

function downloadReport() {
    // Implement report download functionality
    alert('Report download functionality will be implemented here');
}
</script>

@push('scripts')

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection