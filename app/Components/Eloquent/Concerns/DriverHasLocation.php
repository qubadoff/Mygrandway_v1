<?php

namespace App\Components\Eloquent\Concerns;

use App\Enums\DriverStatus;
use App\Enums\OrderStatus;
use App\Models\Driver;
use App\Models\Order;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use MatanYadaev\EloquentSpatial\Objects\Point;


/**
 * @property ?Point $location
 */
trait DriverHasLocation
{
    public static function findNearestDistance(
        Point   $point,
        float   $radius = 10,
        Closure $extraQuery = null
    ): Collection
    {
        return Driver::query()
            ->selectRaw(
                expression: '*,'.distanceSqlExpression($point)
            )
            ->where('status', DriverStatus::APPROVED)
            ->doesntHave('activeOrders')
            ->having('distance', '<=', $radius)
            ->when($extraQuery, fn($query) => $extraQuery($query))
            ->limit(100)
            ->get();
    }

    protected static function bootDriverHasLocation(): void
    {
    }

    public function getPendingOrders(int|float $radius = 50): ?Builder
    {
        if (!$this->location) {
            return null;
        }

        return Order::query()
            ->selectRaw(
                expression: 'orders.*,'.distanceSqlExpression(
                    point: $this->location,
                    latitudeColumn: 'cities.latitude',
                    longitudeColumn: 'cities.longitude'
                )
            )
            ->join('cities', 'cities.id', '=', 'orders.from_city_id')
            ->whereExists(function ($query) {
                $query
                    ->selectRaw('1')
                    ->from('driver_routes')
                    ->where('driver_routes.driver_id', $this->id)
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereRaw('driver_routes.from_city_id=orders.from_city_id')
                                ->whereRaw('driver_routes.to_city_id=orders.to_city_id');
                        })
                        ->orWhere(function ($query) {
                            $query->whereRaw('driver_routes.from_city_id=orders.to_city_id')
                                ->whereRaw('driver_routes.to_city_id=orders.from_city_id');
                        });
                    });
            })
            ->where('status', OrderStatus::Pending)
            ->having('distance', '<=', $radius);
    }

    public function setLocationAttribute(Point $point): void
    {
        $this->attributes['latitude'] = $point->latitude;
        $this->attributes['longitude'] = $point->longitude;
    }

    public function getLocationAttribute(): ?Point
    {
        return $this->latitude ? new Point(
            latitude: $this->latitude,
            longitude: $this->longitude
        ) : null;
    }
}
