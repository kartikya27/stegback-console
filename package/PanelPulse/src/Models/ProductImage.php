<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'gallery_image' => 'array',
    ];
}
