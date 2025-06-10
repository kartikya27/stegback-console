<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id'];

     // Define Coupon Types
     public const TYPE_FLAT = 'flat';
     public const TYPE_PERCENTAGE = 'percentage';

     public const TYPES = [
         self::TYPE_FLAT => 'Flat Discount',
         self::TYPE_PERCENTAGE => 'Percentage Discount',
     ];
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
