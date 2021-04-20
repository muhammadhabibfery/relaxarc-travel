<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TravelPackageRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:55', Rule::unique('travel_packages', 'title')->ignore($this->travel_package)],
            'location' => ['required', 'string', 'max:75'],
            'about' => ['required', 'string'],
            'featured_event' => ['required', 'string', 'max:150'],
            'language' => ['required', 'string', 'max:75'],
            'foods' => ['required', 'string', 'max:150'],
            'date_departure' => ['required', 'date_format:"Y-m-d H:i"', 'after:tomorrow'],
            'duration' => ['required', 'string', 'size:2'],
            'type' => ['required', 'string', 'min:9', 'max:13', 'in:Open Trip,Private Group'],
            'price' => ['required', 'min:0', 'regex:/^[0-9]+./']
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {

        if (app()->getLocale() === 'id') return [
            'title' => 'nama',
            'location' => 'lokasi',
            'about' => 'deskripsi',
            'featured_event' => 'acara',
            'language' => 'bahasa',
            'foods' => 'snack/makanan',
            'date_departure' => 'tanggal keberangkatan',
            'duration' => 'durasi',
            'type' => 'tipe',
            'price' => 'harga'
        ];

        return [
            'featured_event' => 'featured event',
            'date_departure' => 'date of departure'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        if (app()->getLocale() === 'id') return ['date_departure.after' => 'Kolom tanggal keberangkatan harus diisi minimal tanggal ' . Carbon::parse(now()->modify('+1 day'))->format('d')];
    }
}
