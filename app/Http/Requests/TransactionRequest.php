<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
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
        if (request()->routeIs('transactions.update')) {
            return [
                'status' => ['required', 'string', 'in:IN CART,PENDING,SUCCESS,FAILED'],
            ];
        }

        return [
            'travel_package_id' => ['required', 'integer', 'exists:travel_packages,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'invoice_number' => ['required', 'string', 'size:30', Rule::unique('transactions', 'invoice_number')],
            'total' => ['required', 'min:0', 'regex:/^[0-9]+./'],
            'status' => ['required', 'string', 'in:IN CART,PENDING,SUCCESS,FAILED'],
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
            'travel_package_id' => 'paket travel',
            'user_id' => 'pengguna',
            'invoice_number' => 'nomor invoice'
        ];

        return [
            'travel_package_id' => 'travel package',
            'user_id' => 'user',
            'invoice_number' => 'invoice number'
        ];
    }
}
