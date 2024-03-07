<?php

namespace App\Models;


use App\Enums\BusinessStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Business extends Authenticatable
{
    use HasFactory;

    protected $table = 'businesses';

    protected $guard = 'business';

    protected $fillable = [
        'name',
        'password',
        'business_code',
        'description',
        'email',
        'phone',
        'location',
        'status'
    ];

    protected $guarded = [];

    protected $casts = [
        'status' => BusinessStatus::class,
    ];

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'business_code', 'business_code');
    }
}
