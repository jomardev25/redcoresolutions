<?php

namespace App\Http\Requests;

class ArtistRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape'
        ];
    }
}
