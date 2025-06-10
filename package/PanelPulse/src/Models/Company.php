<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use SoftDeletes;
    protected $table = COMPANY_TABLE;
    protected $guarded = ['id'];
    

    public function details()
    {
        return $this->belongsTo(Seller::class,'id','company_id');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class,'company_id');
    }

    protected $hidden = [
        'auth_key',
        'auth_secret',
        'company_id',
        'status',
        'deleted_at',
        'created_at',
        'updated_at',
        'webhook_url'
    ];
}

