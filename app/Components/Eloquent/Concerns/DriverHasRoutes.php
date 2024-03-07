<?php

namespace App\Components\Eloquent\Concerns;

use App\Models\DriverRoute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait DriverHasRoutes
 * @package App\Components\Eloquent\Concerns
 * @property DriverRoute[]|Collection<int,DriverRoute> $routes
 */
trait DriverHasRoutes
{
    protected array $routeAttributes = [
        'created' => [],
        'deleted' => [],
    ];

    public static function bootDriverHasRoutes(): void
    {
        static::saved(function ($model) {
            $model->handleRoutes();
        });
    }

    public function initializeDriverHasRoutes(): void
    {
        $this->mergeFillable(['routes']);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(DriverRoute::class, 'driver_id');
    }


    public function setRoutesAttribute(array $routes): void
    {
        $keeps = array_filter(array_column($routes, 'id'));

        $this->routeAttributes['created']  = collect($routes)
            ->filter(fn($route) => empty($route['id']))
            ->mapWithKeys(function ($route) {
                return [
                    $route['from_city_id']."-".$route['to_city_id'] => $route
                ];
            })
            ->values()
            ->toArray();


        $this->routeAttributes['deleted'] = $this->exists
            ? array_diff($this->routes()->pluck('id')->toArray(), $keeps)
            : [];
    }

    protected function handleRoutes(): void
    {
        if (!empty($this->routeAttributes['created'])) {
            $this->routes()->createMany($this->routeAttributes['created']);
        }

        if (!empty($this->routeAttributes['deleted']) && $this->exists) {
            $this->routes()->whereIn('id', $this->routeAttributes['deleted'])->delete();
        }

        $this->routeAttributes = [
            'created' => [],
            'deleted' => [],
        ];
    }
}
