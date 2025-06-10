<?php

namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoreConfig extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'core_config'; 
    protected $guarded = ['id'];
    protected $hidden = ['token'];


}
