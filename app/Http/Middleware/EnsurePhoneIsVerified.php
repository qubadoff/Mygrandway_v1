<?php

namespace App\Http\Middleware;

use App\Components\Eloquent\Contracts\MustVerifyPhone;
use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();

        if (! $user || ($user instanceof MustVerifyPhone && ! $user->hasVerifiedPhone())) {
            abort(403, 'Your account is not verified.');
        }

        return $next($request);
    }
}
