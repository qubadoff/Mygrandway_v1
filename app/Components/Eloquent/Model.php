<?php

namespace App\Components\Eloquent;


use App\Components\Eloquent\Concerns\ResolveRouteBinding;
use Illuminate\Support\Carbon;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use Throwable;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static static create(array $attributes)
 * @method static static findOrFail($id)
 * @method static ?static find($id)
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use ResolveRouteBinding;

    public static function new(array $attributes = []) : static
    {
        return new static($attributes);
    }

    /**
     * @throws Throwable
     * @noinspection PhpUnused
     */
    public static function createOrFail(array $attributes): static
    {
        $model = new static($attributes);

        $model->saveOrFail();

        return $model;
    }

    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }

    public function getPerPage()
    {
        return request()?->perPage() ?? parent::getPerPage();
    }
}
