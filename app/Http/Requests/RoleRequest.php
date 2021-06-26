<?php

namespace App\Http\Requests;

class RoleRequest extends BaseFormRequest
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
                'name' => 'required|string|max:255|unique:roles,name,' . $this->segment(4) . ',id',
                'description' => 'required|string|max:255'
            ];
        }
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'required|string|max:255'
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
