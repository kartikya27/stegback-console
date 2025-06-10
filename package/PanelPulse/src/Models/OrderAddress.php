<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stegback\Core\Models\Address;

//* This table is created for update orders address this will not take ref from user address.
class OrderAddress extends Model
{
    use SoftDeletes;
    protected $table = 'order_addresses';
    protected $guarded = ['id'];
    
    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
