<?php

namespace Kartikey\PanelPulse\Models;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Stegback\User\Models\User;

class Address extends Model
{
    use SoftDeletes;

    /**
     * Table.
     *
     * @var string
     */
    protected $table = USER_ADDRESS;

    /**
     * Guarded.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Castable.
     *
     * @var array
     */
    protected $casts = [
        'use_for_shipping' => 'boolean',
        'default_address'  => 'boolean',
    ];

    /**
     * Get the customer record associated with the address.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(ModelsUser::class);
    }
}
