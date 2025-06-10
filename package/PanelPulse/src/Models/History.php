<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $casts = [
        'history' => 'array',
    ];

    protected $fillable = [
        'change_type',
        'user_id',
        'order_id',
        'product_id',
        'other_element_id',
        'history',
    ];
}
