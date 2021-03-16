<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'min:5', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($this->user())],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user())],
            'phone' => ['required', 'digits_between:10,12'],
            'address' => ['required', 'min:10', 'max:300'],
            'image' => ['file', 'image', 'max:2500', 'nullable'],
        ];
    }
}
