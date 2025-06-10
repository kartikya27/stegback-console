<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = ORDER_ITEM_TABLE;

    public function vendorOrderItems()
    {
        return $this->hasMany(VendorOrderItem::class, 'order_item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
