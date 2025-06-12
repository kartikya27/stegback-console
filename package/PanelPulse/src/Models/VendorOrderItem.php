<?php

namespace Kartikey\PanelPulse\Models;

use Arky\Sales\Interfaces\OrderVendor;
use Arky\Sales\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kartikey\PanelPulse\Models\OrderItem as ModelsOrderItem;
use Kartikey\PanelPulse\Models\OrderVendor as ModelsOrderVendor;

class VendorOrderItem extends Model
{
    use SoftDeletes;

    // protected $table = VENDOR_ORDER_ITEM_TABLE;
    protected $guarded = ['id'];

    public function vendorOrder()
    {
        return $this->belongsTo(ModelsOrderVendor::class, 'vendor_order_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(ModelsOrderItem::class, 'order_item_id');
    }
}
