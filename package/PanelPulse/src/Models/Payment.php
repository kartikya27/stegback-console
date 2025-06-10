<?php


namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'country',
        'state',
        'payment_mode',
        'min_order_value',
        'max_order_value',
    ];
}
