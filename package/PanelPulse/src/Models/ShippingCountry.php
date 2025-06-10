<?php

namespace Kartikey\PanelPulse\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_id',
        'country_id',
        'country_name',
        'state',
        'cost',
    ];

    function shipping_class()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }
}