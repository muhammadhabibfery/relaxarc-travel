<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelGalleryRequest extends FormRequest
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
            'travel_package' => ['required', 'integer', 'exists:travel_packages,id'],
            'image' => ['required', 'file', 'image', 'max:2500']
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
            'travel_package' => 'paket travel',
            'image' => 'gambar'
        ];

        return [
            'travel_package' => 'travel package',
            'image' => 'image',
        ];
    }
}
