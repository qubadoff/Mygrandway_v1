<?php

namespace App\Http\Requests\Api;

use App\Support\Http\ApiFormRequest;

class PasswordResetRequest extends ApiFormRequest
{
    public function rulesReset(): array
    {
        return [
            'password' => ['required', 'min:6', 'max:100'],
            'reset_key' => ['required'],
        ];
    }


    public function rulesForgot(): array
    {
        return [
            'phone' => ['required'],
        ];
    }


    public function rulesCheck(): array
    {
        return [
            'phone' => ['required'],
            'token' => ['required', 'min:6'],
        ];
    }
}
