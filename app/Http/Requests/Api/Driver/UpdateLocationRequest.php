<?php

namespace App\Http\Requests\Api\Driver;

use App\Support\Http\ApiFormRequest;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @property mixed $latitude
 * @property mixed $longitude
 */
class UpdateLocationRequest extends ApiFormRequest
{

    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }


    public function getPoint(): Point
    {
        return new Point($this->latitude, $this->longitude);
    }
}
