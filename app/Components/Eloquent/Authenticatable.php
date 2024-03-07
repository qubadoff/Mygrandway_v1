<?php

namespace App\Components\Eloquent;

use App\Components\Eloquent\Concerns\HasPasswordAutoHash;
use App\Models\Customer;
use App\Models\Driver;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $password
 * @property string $phone
 */
class Authenticatable extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasApiTokens;
    use HasPasswordAutoHash;
    use \Illuminate\Auth\Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;


    public static function attempt(array $credentials) : ?static
    {
        /** @var static $user */
        $user = static::query()->where('phone',$credentials['phone'])->first();

        if (!$user || !Hash::check($credentials['password'],$user->password)) {
            return null;
        }

        return $user;
    }

    public function isDriver(): bool
    {
        return $this instanceof Driver;
    }

    public function isCustomer(): bool
    {
        return $this instanceof Customer;
    }
}
