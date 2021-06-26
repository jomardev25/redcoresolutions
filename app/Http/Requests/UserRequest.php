<?php

namespace App\Http\Requests;

class UserRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PATCH') {
            return [
                'name' => 'required|string|max:255|unique:users,name,' . $this->segment(4) . ',id',
                'email' => 'required|string|max:255|unique:users,email,' . $this->segment(4) . ',id',
                'password' => 'required|string|max:255|confirmed',
                'role_id' => 'required'
            ];
        }
        return [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|max:255|confirmed',
            'role_id' => 'required'
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape',
            'description' => 'trim|escape'
        ];
    }
}
