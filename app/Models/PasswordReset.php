<?php

namespace App\Models;

use App\Components\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property mixed $attempts
 * @property Carbon $expires_at
 * @property Customer|Driver $user
 * @property string $token
 * @property string $verification_key
 */
class PasswordReset extends Model
{
    public const EXPIRATION_MINUTES = 5;
    public const ATTEMPTS_LIMIT = 5;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    protected $fillable = [
        'phone',
        'token',
        'verification_key',
        'attempts',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            $model->verification_key = Str::uuid();
            $model->expires_at = now()->addMinutes(self::EXPIRATION_MINUTES);
        });
    }


    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    public static function findUserByPhone($phone): null|Customer|Driver
    {
        return Customer::query()->where('phone', $phone)->firstOr(['*'], function () use($phone){
            return Driver::query()->where('phone', $phone)->first();
        });
    }

    public static function findByVerifyKey($key): ?PasswordReset
    {
        return static::where('verification_key', $key)->first();
    }

    public function incrementAttempts(): int
    {
        return $this->increment('attempts');
    }

    public function isReachedLimit(): bool
    {
        return $this->attempts >= self::ATTEMPTS_LIMIT;
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
