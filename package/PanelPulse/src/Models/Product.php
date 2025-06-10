<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function descriptions()
    {
        return $this->hasMany(ProductDescription::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function sellers(){
        return $this->belongsTo(Seller::class,'seller');
    }

    public function product_categories()
    {
        // return $this->belongsToMany(ProductCategory::class, 'product_id');
        return $this->belongsToMany(
            Category::class,                  // Related model
            'product_categories',             // Pivot table name
            'product_id',                     // Foreign key on the pivot table for this model
            'category_id'                     // Foreign key on the pivot table for the related model
        );
    }

    public function taxes()
    {
        return $this->hasOne(ProductTaxation::class, 'product_id');
    }


    public function ratings()
    {
        return $this->hasMany(ProductRating::class, 'product_id');
    }

}


