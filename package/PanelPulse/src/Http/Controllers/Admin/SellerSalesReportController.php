<?php

namespace Kartikey\PanelPulse\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kartikey\PanelPulse\Models\Seller;
use Kartikey\PanelPulse\Models\OrderVendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kartikey\PanelPulse\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;


class SellerSalesReportController extends Controller
{
    private function getDateRange($startDate = null, $endDate = null)
    {
        // Debugging: Log the incoming date strings
        Log::info('Received start date: ' . $startDate);
        Log::info('Received end date: ' . $endDate);

        // Validate and parse the start date
        if (is_string($startDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            $startDate = Carbon::parse($startDate);
        } else if (is_string($startDate)) {
            Log::error('Invalid start date format: ' . $startDate);
            $startDate = null;
        }

        // Validate and parse the end date
        if (is_string($endDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
            $endDate = Carbon::parse($endDate);
        } else if (is_string($endDate)) {
            Log::error('Invalid end date format: ' . $endDate);
            $endDate = null;
        }

        if (!$startDate) {
            $startDate = Carbon::now()->subDays(30);
        }
        if (!$endDate) {
            $endDate = Carbon::now();
        }
        return [$startDate, $endDate];
    }

    private function calculateTotalSales($seller, $startDate, $endDate)
    {
        $orders = $seller->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalSales = 0;
        foreach ($orders as $order) {
            $totals = $order->calculateVendorTotals();
            $totalSales += $totals['total_price'];
        }

        return $totalSales;
    }

    private function calculateTotalOrders($seller, $startDate, $endDate)
    {
        return $seller->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    private function calculateAverageOrderValue($seller, $startDate, $endDate)
    {
        $totalSales = $this->calculateTotalSales($seller, $startDate, $endDate);
        $totalOrders = $this->calculateTotalOrders($seller, $startDate, $endDate);
        
        return $totalOrders > 0 ? $totalSales / $totalOrders : 0;
    }

    private function calculateNetProfit($seller, $startDate, $endDate)
    {
        $orders = $seller->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $netProfit = 0;
        foreach ($orders as $order) {
            $totals = $order->calculateVendorTotals();
            $netProfit += $totals['total_price'] - $totals['total_shipping'] - $totals['total_tax'] - $totals['total_discount'];
        }

        return $netProfit;
    }

    private function getSalesTrend($seller, $startDate, $endDate)
    {
        $orders = $seller->orders()
            ->join('orders', 'order_vendors.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(order_vendors.created_at) as date'), DB::raw('COUNT(*) as count'), DB::raw('SUM(orders.grand_total) as amount'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $orders;
    }

    private function getTopProducts($seller, $startDate, $endDate)
    {
        return $seller->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('items.orderItem')
            ->get()
            ->flatMap(function ($order) {
                return $order->items->map(function ($item) {
                    return [
                        'name' => $item->orderItem->name,
                        'sku' => $item->orderItem->sku,
                        'quantity' => $item->orderItem->qty_ordered,
                        'revenue' => $item->orderItem->total
                    ];
                });
            })
            ->groupBy('sku')
            ->map(function ($items) {
                return [
                    'quantity' => $items->sum('quantity'),
                    'revenue' => $items->sum('revenue')
                ];
            })
            ->sortByDesc('revenue')
            ->take(5);
    }

    private function getSalesByCategory($seller, $startDate, $endDate)
    {
        return $seller->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('items.orderItem.product.product_categories')
            ->get()
            ->flatMap(function ($order) {
                return $order->items->map(function ($item) {
                    return [
                        'category' => $item->orderItem->product->product_categories->first()->name ?? 'Uncategorized',
                        'revenue' => $item->orderItem->total
                    ];
                });
            })
            ->groupBy('category')
            ->map(function ($items) {
                return $items->sum('revenue');
            });
    }

    private function getPriceBreakdown($seller, $startDate, $endDate)
    {
        $orders = $seller->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $breakdown = [
            'gross_sales' => 0,
            'platform_fees' => 0,
            'tax' => 0,
            'shipping_costs' => 0,
            'returns_refunds' => 0,
            'net_profit' => 0
        ];

        foreach ($orders as $order) {
            $totals = $order->calculateVendorTotals();
            $breakdown['gross_sales'] += $totals['total_price'];
            $breakdown['platform_fees'] += $totals['total_price'] * 0.075; // 7.5% platform fee
            $breakdown['tax'] += $totals['total_tax'];
            $breakdown['shipping_costs'] += $totals['total_shipping'];
            $breakdown['returns_refunds'] += $totals['total_discount'];
        }

        $breakdown['net_profit'] = $breakdown['gross_sales'] - 
            $breakdown['platform_fees'] - 
            $breakdown['tax'] - 
            $breakdown['shipping_costs'] - 
            $breakdown['returns_refunds'];

        return $breakdown;
    }

    private function getRecentOrders($seller, $limit = 5)
    {
        return $seller->orders()
            ->with(['items.orderItem.product'])
            ->latest()
            ->take($limit)
            ->get();
    }

    private function getLastMonthData($seller)
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $lastMonthOrders = $seller->orders()
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->get();

        $lastMonthSales = 0;
        $lastMonthProfit = 0;
        foreach ($lastMonthOrders as $order) {
            $totals = $order->calculateVendorTotals();
            $lastMonthSales += $totals['total_price'];
            $lastMonthProfit += $totals['total_price'] - $totals['total_shipping'] - $totals['total_tax'] - $totals['total_discount'];
        }

        $lastMonthAOV = $lastMonthOrders->count() > 0 ? $lastMonthSales / $lastMonthOrders->count() : 0;

        return [
            'sales' => $lastMonthSales,
            'orders' => $lastMonthOrders->count(),
            'aov' => $lastMonthAOV,
            'profit' => $lastMonthProfit
        ];
    }

    public function salesReport($id, Request $request)
    {
        $seller = Seller::findOrFail($id);
        $startDate = $request->query('start');
        $endDate = $request->query('end');
        [$startDate, $endDate] = $this->getDateRange($startDate, $endDate);
        $lastMonthData = $this->getLastMonthData($seller);

        $data = [
            'seller' => $seller,
            'total_sales' => $this->calculateTotalSales($seller, $startDate, $endDate),
            'total_orders' => $this->calculateTotalOrders($seller, $startDate, $endDate),
            'average_order_value' => $this->calculateAverageOrderValue($seller, $startDate, $endDate),
            'net_profit' => $this->calculateNetProfit($seller, $startDate, $endDate),
            'sales_trend' => $this->getSalesTrend($seller, $startDate, $endDate),
            'top_products' => $this->getTopProducts($seller, $startDate, $endDate),
            'sales_by_category' => $this->getSalesByCategory($seller, $startDate, $endDate),
            'price_breakdown' => $this->getPriceBreakdown($seller, $startDate, $endDate),
            'recent_orders' => $this->getRecentOrders($seller),
            'date_range' => [
                'start' => $startDate,
                'end' => $endDate
            ],
            'last_month_sales' => $lastMonthData['sales'],
            'last_month_orders' => $lastMonthData['orders'],
            'last_month_aov' => $lastMonthData['aov'],
            'last_month_profit' => $lastMonthData['profit']
        ];

        // dd($data);

        return view('PanelPulse::admin.sellers.sales-report', $data);
    }

    public function downloadSalesReport($sellerId)
    {
        return Excel::download(new SalesReportExport($sellerId), 'sales_report.xlsx');
    }
}