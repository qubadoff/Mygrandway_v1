<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Components\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverRoute extends Model
{
    use HasFactory;

    protected $table = "driver_routes";

    public $timestamps = false;

    protected $fillable = [
        'driver_id',
        'from_city_id',
        'to_city_id',
    ];


    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function from_city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function to_city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
