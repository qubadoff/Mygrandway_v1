<?php

namespace App\Providers;

use App\Nova\Admin;
use App\Nova\Business;
use App\Nova\CurrencyType;
use App\Nova\Role;
use App\Nova\SupportData;
use App\Nova\TruckType;
use App\Nova\City;
use App\Nova\Country;
use App\Nova\Customer;
use App\Nova\Dashboards\Main;
use App\Nova\Driver;
use App\Nova\DriverRoute;
use App\Nova\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Permission;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        Nova::mainMenu(function (Request $request){
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),
                MenuSection::make('Country', [
                    MenuItem::resource(Country::class),
                    MenuItem::resource(City::class),
                ])->icon('document-text')->collapsable(),
                MenuSection::make('Order', [
                    MenuItem::resource(Order::class)
                ])->icon('document-text')->collapsable(),
                MenuSection::make('Customer', [
                    MenuItem::resource(Customer::class)
                ])->icon('user')->collapsable(),

                MenuSection::make('Driver', [
                    MenuItem::resource(Driver::class),
                    MenuItem::resource(DriverRoute::class),
                    MenuItem::resource(TruckType::class),
                ])->icon('user')->collapsable(),

                MenuSection::make('Busniess', [
                    MenuItem::resource(Business::class)
                ])
                ->icon('user')->collapsable(),

                MenuSection::make('Role & Permissions', [
                    MenuItem::resource(Role::class),
                    MenuItem::resource(Permission::class),
                    ])->icon('user')->collapsable(),

                MenuSection::make('Setting', [
                    MenuItem::resource(Admin::class),
                    MenuItem::resource(CurrencyType::class),
                    MenuItem::resource(SupportData::class)
                ])->icon('user')->collapsable(),
            ];
        });

        Nova::footer(function ($request) {
            return Blade::render('
               <div class="mt-8 leading-normal text-xs text-gray-500 space-y-1">
                   <p class="text-center">
                       Created by <a class="link-default" target="_blank" href="https://burncode.org">Burncode LLC</a>
                   </p>
                </div>
            ');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                //->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools(): array
    {
        return [
            \Vyuldashev\NovaPermission\NovaPermissionTool::make(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
