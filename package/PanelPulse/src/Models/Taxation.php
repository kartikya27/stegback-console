<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax',
        'country',
        'charge',
    ];
}
