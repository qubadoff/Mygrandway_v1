<?php

namespace App\Models;

use App\Components\Eloquent\Authenticatable;
use App\Components\Eloquent\Concerns\CanResetPassword;
use App\Components\Eloquent\Concerns\Filterable;
use App\Components\Eloquent\Concerns\HasMessage;
use App\Components\Eloquent\Concerns\HasVerifyPhone;
use App\Components\Eloquent\Contracts\MustVerifyPhone;
use App\Enums\OrderStatus;
use App\Support\Contracts\CurrentUser;
use App\Support\Contracts\CustomerUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property ?string $fcm_token
 * @property ?Carbon $phone_verified_at
 */
class Customer extends Authenticatable implements MustVerifyPhone,CurrentUser,CustomerUser
{
    use SoftDeletes, HasFactory, Notifiable, HasMessage;
    use HasVerifyPhone;
    use Filterable;
    use CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'password',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'phone_verified_at',
    ];

    protected $appends = [
        'is_verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
    ];

    public function getFilters(): array
    {
        return [
            'fields' => [],
            'filters' => [],
            'sorts' => [],
            'includes' => [

            ],
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function hasActiveOrders(): bool
    {
        return $this->orders()->whereIn('status', [
            OrderStatus::InProgress->value,
            OrderStatus::Chatting->value,
        ])->exists();
    }

    public function routeNotificationForFcm(): ?string
    {
        return $this->fcm_token;
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }
}
