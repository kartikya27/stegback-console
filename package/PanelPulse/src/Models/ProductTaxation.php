<?php



namespace Kartikey\PanelPulse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductTaxation extends Model
{
    use SoftDeletes;
    protected $table = 'product_taxation';
    protected $guarded = ['id'];
}
