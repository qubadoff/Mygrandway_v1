<?php

namespace App\Http\Requests;

use App\Support\Http\ApiFormRequest;

class MessageRequest extends ApiFormRequest
{
    public function rulesStore(): array
    {
        return [
            'body' => 'required|string|min:1|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Please enter message body',
            'body.string' => 'Message body must be string',
            'body.min' => 'Message body must be at least :min characters',
            'body.max' => 'Message body must be at most :max characters',
        ];
    }
}
