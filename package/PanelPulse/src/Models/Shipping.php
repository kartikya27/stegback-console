<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'name',
        'type',
        'cost',
    ];
}
