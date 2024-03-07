<?php

namespace App\Models;

use App\Exceptions\OtpException;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Components\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $expires_at
 * @property int $attempts
 * @property ?string $ip
 * @property ?string $user_agent
 * @property mixed $otp
 */
class OtpRequest extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = "otp_requests";

    public $keyType = 'string';

    public $incrementing = false;


    protected $fillable = [
        'phone',
        'otp',
        'ip',
        'user_agent',
        'modelable_type',
        'modelable_id',
        'attempts',
        'expires_at',
        'verified_at',
    ];

    protected $hidden = [
        'id',
        'modelable_type',
        'modelable_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $otpRequest) {
            $otpRequest->expires_at ??= Carbon::now()->addMinutes(5);
            $otpRequest->attempts ??= 0;
            $otpRequest->ip ??= request()->ip();
            $otpRequest->user_agent ??= request()->userAgent();
            $otpRequest->otp ??= random_int(100000, 999999);
        });
    }

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function wasAttemptLimitReached(): bool
    {
        return $this->attempts >= 5;
    }

    public function check(string $token): bool
    {
        if($this->wasAttemptLimitReached()) {
            $this->delete();
            throw new OtpException('Too many attempts');
        }

        if ($this->isExpired()) {
            $this->delete();
            throw new OtpException('Token expired');
        }


        if ($this->otp !== $token) {

            $this->increment('attempts');

            throw new OtpException('Invalid token');
        }

        $this->verified_at = now();

        $this->saveQuietly();

        return true;
    }

}
