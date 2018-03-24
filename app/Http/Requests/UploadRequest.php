<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required'
        ];
        //$photos = count($this->input('photos'));
        //foreach(range(0, $photos) as $index) {
        //    $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
        //}

        return $rules;
    }
}
