<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersCustomer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'country', 'shipping_country');
    }
}
