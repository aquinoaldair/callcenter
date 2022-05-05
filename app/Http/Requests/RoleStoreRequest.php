<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RoleStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:255']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => Str::slug($this->title),
        ]);
    }
}
