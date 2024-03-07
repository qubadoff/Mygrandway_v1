<?php

namespace App\Http\Requests\Api\Driver;

use App\Support\Contracts\DriverUser;
use App\Support\Http\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'string|min:3|max:255',
            'phone' => [
                'string',
                Rule::unique('customers', 'phone')->withoutTrashed(),
                Rule::unique('drivers', 'phone')->withoutTrashed()->ignore(
                    app(DriverUser::class)->getKey(),
                ),
            ],
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'address' => 'string',
            'about' => 'nullable|string',
            'truck_type_id' => 'exists:truck_types,id',
            'routes' => [
                'nullable',
                'array',
                'filled',
            ],
            'routes.*.from_city_id' => [
                'required_with:routes',
                'exists:cities,id',
                'different:routes.*.to_city_id',
            ],
            'routes.*.to_city_id'   => [
                'required_with:routes',
                'exists:cities,id',
                'different:routes.*.from_city_id',
            ]
        ];
    }
}
