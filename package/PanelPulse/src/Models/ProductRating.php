<?php

namespace Kartikey\PanelPulse\Models;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Model;
use Kartikey\PanelPulse\Models\User;

class ProductRating extends Model
{
    protected $table = PRODUCT_REVIEW_TABLE;

    protected $guarded = ['id'];

    protected $fillable = [
        'product_id',
        'user_id',
        'ratings',
        'title',
        'description',
        'media',
        'editable',
        'extra',
        'vote',
        'is_verified',
        'status',
    ];

    protected $hidden = ['updated_at', 'deleted_at', 'product_id', 'status', 'user_id'];

    protected $casts = [
        'media' => 'array',
        'extra' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(ModelsUser::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 