<?php

namespace App\Http\Requests\Api\Driver;

use App\Models\Driver;
use App\Support\Http\ApiFormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends ApiFormRequest
{
    public function rulesRegister(): array
    {
        return array_merge($this->rulesLogin(), [
            'full_name' => 'required|string',
//            'phone' => 'required|phone|unique:drivers,phone',
            'phone' => [
                'required',
                'string',
                Rule::unique('customers', 'phone')->withoutTrashed(),
                Rule::unique('drivers', 'phone')->withoutTrashed(),
            ],
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'about' => 'nullable|string',
            'driver_license_no' => 'required|string',
            'truck_type_id' => 'required|exists:truck_types,id',
            'routes' => [
                'array',
                'filled',
            ],
            'routes.*.from_city_id' => 'required|exists:cities,id',
            'routes.*.to_city_id'   => 'required|exists:cities,id|different:routes.*.from_city_id',
            'business_code' => 'max:10'
        ],
            $this->getMediaValidationRules()
        );
    }

    public function rulesLogin(): array
    {
        return [
            'phone' => ['required'],
            'password' => 'required|min:6',
        ];
    }

    protected function getMediaValidationRules(): array
    {
        return [
            Driver::$media_request_keys['DRIVER_LICENSE'] => ['array','filled', 'min:2', 'max:2'],
            Driver::$media_request_keys['TRUCK_PHOTO'] => ['array','filled', 'min:2', 'max:2'],
            Driver::$media_request_keys['TRUCK_PHOTO_TWO'] => ['array','filled', 'min:2', 'max:2'],

            Driver::$media_request_keys['DRIVER_LICENSE'].".*" => 'required|image|mimes:jpeg,png,jpg|max:80960',
            Driver::$media_request_keys['DRIVER_TEX_PASSPORT'] => 'required|image|mimes:jpeg,png,jpg|max:80960',
            Driver::$media_request_keys['DRIVER_PASSPORT'] => 'required|image|mimes:jpeg,png,jpg|max:80960',
            Driver::$media_request_keys['DRIVER_INSURANCE_DOC'] => 'required|image|mimes:jpeg,png,jpg|max:80960',
            Driver::$media_request_keys['TRUCK_PHOTO']."*" => 'required|image|mimes:jpeg,png,jpg|max:80960',
            Driver::$media_request_keys['TRUCK_PHOTO_TWO']."*" => 'required|image|mimes:jpeg,png,jpg|max:80960',
        ];
    }
}
