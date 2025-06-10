<?php

namespace Kartikey\PanelPulse\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = ['id'];
    protected $table = 'sliders';

    protected $casts = [
        'desktop_img' => 'array',
        'mobile_img' => 'array',
    ];

}
