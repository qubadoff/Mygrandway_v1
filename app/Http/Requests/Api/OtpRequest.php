<?php

namespace App\Http\Requests\Api;

use App\Support\Http\ApiFormRequest;


/**
 * Class OtpRequest
 * @package App\Http\Requests\Api
 * @property string $phone
 * @property string $code
 */
class OtpRequest extends ApiFormRequest
{
    public function rulesSend(): array
    {
        return [];
    }

    public function rulesVerify(): array
    {
        return [
            'code' => 'required|digits:4',
        ];
    }
}
