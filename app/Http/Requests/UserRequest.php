<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if (request()->routeIs('users.store')) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'min:5', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($this->user())],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user())],
                'phone' => ['required', 'digits_between:10,12'],
                'address' => ['required', 'min:10', 'max:300'],
                'roles' => ['required', 'string', 'size:5', 'in:admin']
            ];
        }

        if (request()->routeIs('users.update') && request()->roles) {
            return [
                'roles' => ['required',  'array', 'min:1', 'in:admin,superadmin'],
                'status' => ['required', 'string', 'min:4', 'max:6', 'in:ACTIVE,NONE']
            ];
        }

        return [
            'status' => ['required', 'string', 'min:4', 'max:6', 'in:ACTIVE,NONE']
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        if (app()->getlocale() === 'id') return [
            'name' => 'nama',
            'phone' => 'telepon',
            'address' => 'alamat',
            'roles' => 'level'
        ];
    }
}
