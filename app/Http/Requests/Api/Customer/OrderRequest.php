<?php

namespace App\Http\Requests\Api\Customer;

use App\Support\Http\ApiFormRequest;

class OrderRequest extends ApiFormRequest
{
    public function rulesStore(): array
    {
        return [
            'to_city_id' => 'required|exists:cities,id',
            'from_city_id' => 'required|exists:cities,id',
            'truck_type_id' => 'required|exists:truck_types,id',
            'pickup_at' => 'required|date',
            'dropoff_at' => 'required|integer',
            'comment' => 'required|string',
            'price' => 'required|integer',
            'currency_id' => 'required|integer|max:1000'
        ];
    }
}
