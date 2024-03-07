<?php

namespace App\Providers;

use App\Components\Eloquent\Paginator;
use App\Models\PersonalAccessToken;
use App\Support\Contracts\CurrentUser;
use App\Support\Contracts\CustomerUser;
use App\Support\Contracts\DriverUser;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\Sanctum;
use Spatie\NovaTranslatable\Translatable;
use Twilio\Rest\Client;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        Container::getInstance()->bind(
            LengthAwarePaginator::class,
            // is nova request ? use nova paginator : use default paginator
            !request()->is('nova-api/*') ? Paginator::class : LengthAwarePaginator::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Translatable::defaultLocales(['en', 'ru', 'az']);

        Paginator::useBootstrap();

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        if ($this->app->hasDebugModeEnabled()) {
            DB::enableQueryLog();
        }

        Request::macro('perPage',function () {
            /**@var Request $this*/
            return $this->get('per_page', 10) > 1000
                ? 999 :
                $this->get('per_page', 10);
        });

        $this->app->bind(CurrentUser::class, fn() => auth()->user());

        $this->app->bind(DriverUser::class, function () {
            /**@var CurrentUser $user*/
            $user = auth()->user();
            return $user->isDriver() ? $user : null;
        });

        $this->app->bind(CustomerUser::class, function () {
            /**@var CurrentUser $user*/
            $user = auth()->user();
            return $user->isCustomer() ? $user : null;
        });

        $this->app->bind(Client::class, function () {
            return new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );
        });
    }
}
