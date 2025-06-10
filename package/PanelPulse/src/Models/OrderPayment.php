<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use SoftDeletes;
    protected $table = 'order_payments';
    protected $guarded = ['id'];
}
