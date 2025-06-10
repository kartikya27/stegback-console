<?php

namespace Kartikey\PanelPulse\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Kartikey\PanelPulse\Models\Order;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::selectRaw('COUNT(id) AS noOfOrders, SUM(grand_total) AS totalSales')->first();
        $todayOrders = Order::selectRaw('COUNT(id) AS noOfOrders, SUM(grand_total) AS totalSales')->whereDate('created_at', Carbon::today())->first();
        $UnfulfillOrders = Order::whereIn('status', ['pending', 'on_hold'])->count();

        return view('PanelPulse::admin.home', ['orders' => $orders, 'todayOrders' => $todayOrders,  'noOfUnfulfillOrders' => $UnfulfillOrders]); //'checkouts' => $checkouts, 'todayCheckouts' => $todayCheckouts,
    }
}
