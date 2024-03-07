<?php

namespace App\Http\Requests\Api\Customer;

use App\Support\Http\ApiFormRequest;
use Illuminate\Validation\Rule;

class CustomerAuthRequest extends ApiFormRequest
{
    public function rulesRegister() : array
    {
        return [
            'full_name' => 'required|string|min:3|max:255',
            //'phone' => 'required|string|unique:customers,phone|unique:drivers,phone',
            'phone' => [
                'required',
                'string',
                Rule::unique('customers', 'phone')->withoutTrashed(),
                Rule::unique('drivers', 'phone')->withoutTrashed(),
            ],
            'password' => 'required|string|min:6',
        ];
    }

    public function rulesLogin() : array
    {
        return [
            'phone' => 'required',
            'password' => 'required',
        ];
    }
}
