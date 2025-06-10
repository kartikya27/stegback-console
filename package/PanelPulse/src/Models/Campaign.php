<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';
    protected $guarded = ['id'];

    public function adGroups()
    {
        return $this->hasMany(AdGroup::class, 'campaign_id');
    }
    
}