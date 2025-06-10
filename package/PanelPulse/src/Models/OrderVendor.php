<?php

namespace Kartikey\PanelPulse\Models;

use Arky\Sales\Interfaces\OrderVendor as InterfacesOrderVendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stegback\Core\Models\Channel;
use Arky\Sales\Models\VendorOrderItem;
use Kartikey\PanelPulse\Models\VendorOrderItem as ModelsVendorOrderItem;


class OrderVendor extends Model
{
    use SoftDeletes;
    protected $table = VENDOR_ORDER_TABLE;
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function items()
    {
        return $this->hasMany(ModelsVendorOrderItem::class, 'vendor_order_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function calculateVendorTotals()
    {
        $items = $this->items()->with('orderItem')->get();

        $totals = [
            'total_price'      => 0,
            'total_shipping'   => 0,
            'total_tax'        => 0,
            'total_discount'   => 0,
            'total_qty_ordered' => 0,
        ];

        foreach ($items as $item) {
            $totals['total_price'] += $item->orderItem->total;
            $totals['total_shipping'] += $item->orderItem->shipping_amount;
            $totals['total_tax'] += $item->orderItem->tax_amount;
            $totals['total_discount'] += $item->orderItem->discount_amount;
            $totals['total_qty_ordered'] += $item->orderItem->qty_ordered;
        }

        return $totals;
    }



}
