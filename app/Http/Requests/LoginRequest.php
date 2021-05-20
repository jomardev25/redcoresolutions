<?php

namespace App\Http\Requests;


class LoginRequest extends BaseFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function filters()
    {
        return [
            'username' => 'trim|escape'
        ];
    }
}
