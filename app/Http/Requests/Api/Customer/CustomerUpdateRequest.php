<?php

namespace App\Http\Requests\Api\Customer;

use App\Models\Customer;
use App\Support\Contracts\CustomerUser;
use App\Support\Http\ApiFormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends ApiFormRequest
{
    public function rules() : array
    {
        return [
            'full_name' => 'string|min:3|max:255',
            'phone' => [
                'string',
                Rule::unique('customers', 'phone')->withoutTrashed()->ignore(
                    app(CustomerUser::class)->getKey(),
                ),
                Rule::unique('drivers', 'phone')->withoutTrashed(),
            ],
            'password' => 'string|min:6',
        ];
    }
}
