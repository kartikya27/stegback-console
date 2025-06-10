<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'language',
        'currency',
        'regular_price',
        'sale_price',
    ];
}
