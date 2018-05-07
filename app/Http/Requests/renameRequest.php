<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class renameRequest extends FormRequest
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

        return $rules;
    }
}