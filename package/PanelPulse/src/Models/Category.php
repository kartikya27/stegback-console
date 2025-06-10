<?php

namespace Kartikey\PanelPulse\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $table = 'categories';

    protected $casts = [
        'media' => 'array',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('hide',0);
    }

    // Relationship for parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->where('hide',0);
    }
}
