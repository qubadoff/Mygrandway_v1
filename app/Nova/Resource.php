<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{

    public static array $permissions = [
        'view'   => '*',
        'create' => '*',
        'update' => '*',
        'delete' => '*',
    ];

    public static function authorizable(): bool
    {
        return true;
    }

    public function authorizeToViewAny(Request $request)
    {
        return true;
    }


    public static function authorizedToViewAny(Request $request)
    {
        return true;
    }

    protected static function checkPermission(Request $request,string $permission): bool
    {
        /**@var $admin \App\Models\Admin*/
        $admin = auth()->user();

        if ($admin?->hasRole('Super')) {
            return true;
        }

        return $admin?->hasPermissionTo(static::$permissions[$permission]) ?? false;
    }

    public static function availableForNavigation(Request $request): bool
    {
        return self::checkPermission($request,'view');
    }

    public function authorizedToView($request): bool
    {
        return $this->availableForNavigation($request);
    }

    public function authorizeToView($request): bool
    {
        return $this->availableForNavigation($request);
    }


    public static function authorizedToCreate(Request $request): bool
    {
        return self::checkPermission($request,'create');
    }

    public static function authorizeToCreate(Request $request): bool
    {
        return self::checkPermission($request,'create');
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return self::checkPermission($request,'update');
    }

    public function authorizeToUpdate(Request $request): bool
    {
        return self::checkPermission($request,'update');
    }

    public function authorizedToDelete(Request $request): bool
    {
        return self::checkPermission($request,'delete');
    }

    public function authorizeToDelete(Request $request): bool
    {
        return self::checkPermission($request,'delete');
    }
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }
}
