<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $casts = [
        'product_meta' => 'array',
        'extra' => 'array'
    ];
}

