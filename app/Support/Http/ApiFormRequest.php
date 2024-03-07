<?php

namespace App\Support\Http;

use Illuminate\Foundation\Http\FormRequest;

class ApiFormRequest extends FormRequest
{
    public function authorize() : bool
    {
        $authorizeMethod = 'authorize' . ucfirst($this->route()->getActionMethod());

        if (method_exists($this, $authorizeMethod)) {
            return $this->{$authorizeMethod}();
        }

        return true;
    }

    public function rules() : array
    {
        $rulesMethod = 'rules' . ucfirst($this->route()->getActionMethod());

        if (method_exists($this, $rulesMethod)) {
            return $this->{$rulesMethod}();
        }

        return [];
    }

    public function messages() : array
    {
        $messagesMethod = 'messages' . ucfirst($this->route()->getActionMethod());

        if (method_exists($this, $messagesMethod)) {
            return $this->{$messagesMethod}();
        }

        return [];
    }

    public function limit() : int
    {
        return $this->get('limit', 10);
    }

    public function actionName(): string
    {
        return $this->route()->getActionMethod();
    }
}
