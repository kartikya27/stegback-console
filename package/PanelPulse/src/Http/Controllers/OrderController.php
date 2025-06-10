<?php

namespace Kartikey\PanelPulse\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Kartikey\PanelPulse\Models\OrdersCustomer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Kartikey\PanelPulse\Models\Order;
use Kartikey\PanelPulse\Models\OrderItem;
use Kartikey\PanelPulse\Models\OrderVendor;
use Kartikey\PanelPulse\Models\Shipping;
use Kartikey\PanelPulse\Models\VendorOrderItem;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'orders_customers:id,name',
            'payment','shippments'
            // 'customer_shipping'
        ])->orderBy('id', 'desc')->get();

        
        // $orders = $orders->groupBy('id');

        // dd($orders->toarray());
        return view('PanelPulse::admin.orders.list', ['orders' => $orders]); //'checkouts' => $checkouts, 'todayCheckouts' => $todayCheckouts,
    }
    public function customers()
    {
        $customers = User::withCount('orders')->paginate(20);

        return view('PanelPulse::admin.customers.list', ['customers' => $customers]); //'checkouts' => $checkouts, 'todayCheckouts' => $todayCheckouts,
    }


    public function deleteCustomer($customerID)
    {
        $customer = User::find($customerID);

        if ($customer) {
            DB::beginTransaction(); // Start transaction

            try {
                // Get all orders of the customer
                $orders = Order::where('user_id', $customerID)->get();

                foreach ($orders as $order) {
                    // Get all order items related to this order
                    $orderItems = $order->orderItems()->pluck('id')->toArray();

                    if (!empty($orderItems)) {
                        // First, delete order_vendor_items that reference order_items
                        VendorOrderItem::whereIn('order_item_id', $orderItems)->delete();

                        // Then delete order_items
                        OrderItem::whereIn('id', $orderItems)->delete();
                    }

                    // Delete order_vendors related to this order
                    OrderVendor::where('order_id', $order->id)->delete();
                }

                // Delete orders associated with the customer
                Order::where('user_id', $customerID)->delete();

                // Delete addresses related to the customer
                $customer->addresses()->delete();

                // Finally, delete the customer
                $customer->delete();

                DB::commit(); // Commit transaction

                return redirect()->back()->with('success', 'Customer and all associated data have been deleted successfully.');
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction if any error occurs
                return redirect()->back()->with('error', 'Error deleting customer: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Customer not found.');
    }
    public function order($orderID)
    {
        $orders = Order::where('id', $orderID)->with('orders_customers','orderItems','payment','shippments','addresses')->first();
        // dd($orders);
        return view('PanelPulse::admin.orders.detail', ['orders' => $orders]);
    }
    public function view($order_id)
    {
        try {
            $order = Order::with('orderItems.product.sellers')->find($order_id);


            if (!$order) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            return view('PanelPulse::admin.orders.view', compact('order'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
