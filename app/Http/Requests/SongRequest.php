<?php

namespace App\Http\Requests;


class SongRequest extends BaseFormRequest
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
        return [
            'title' => 'required|string|max:255',
            'artist_id' => 'required',
            'lyrics' => 'required'
        ];
    }

    public function filters()
    {
        return [
            'title' => 'trim|escape',
            'lyrics' => 'trim|escape'
        ];
    }
}
