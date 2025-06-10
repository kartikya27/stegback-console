<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'promotional_banners' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class,'seller');
    }

    public function orders()
    {
        return $this->hasMany(OrderVendor::class,'seller_id');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // public function seller_category()
    // {
    //     return $this->hasMany(SellerCategroy::class,'seller_id');
    // }
}
