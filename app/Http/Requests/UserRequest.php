<?php

namespace App\Http\Requests;

use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * The name of model instance
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model;

    /**
     * Create a new Eloquent model instance.
     *
     * @param App\Repositories\Transaction\TransactionRepositoryInterface $transactionRepositoryInterface
     * @return   Illuminate\Database\Eloquent\Model
     */
    public function __construct(TransactionRepositoryInterface $transactionRepositoryInterface)
    {
        $this->model = $transactionRepositoryInterface;
    }

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
        if (request()->routeIs('users.store'))
            return [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'min:5', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($this->user())],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user())],
                'phone' => ['required', 'digits_between:10,12'],
                'address' => ['required', 'min:10', 'max:300'],
                'roles' => ['required', 'string', 'size:5', 'in:admin']
            ];

        if (request()->routeIs('users.update'))
            return [
                'roles' => ['required',  'array', 'min:1', 'max:2', 'in:admin,superadmin'],
                'status' => ['required', 'string', 'min:4', 'max:6', 'in:ACTIVE,NONE']
            ];

        if (request()->routeIs('checkout.create'))
            return [
                'username' => [
                    'required',
                    'min:5',
                    'max:255',
                    'alpha_dash',
                    Rule::exists('users', 'username'),
                    Rule::unique('transaction_details', 'username')->where(function ($query) {
                        return $query->where(
                            'transaction_id',
                            $this->model->findOneTransactionByInvoiceNumber($this->transaction)->firstOrNotFound()->transactionDetails->last()->transaction_id
                        );
                    })
                ]
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
