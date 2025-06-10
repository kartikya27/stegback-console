<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;

class AdGroup extends Model
{
    protected $table = 'ad_groups';
    protected $guarded = ['id'];

    public function ads()
    {
        return $this->hasMany(Ad::class, 'ad_group_id');
    }

    // public function campaign()
    // {
    //     return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    // }

}