<?php

namespace App\Models;

use App\Components\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $latitude
 * @property mixed $longitude
 */
class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'name',
        'country_id',
        'country_code',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
