<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InvestToDepositFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:10',
                'max:100'
            ],
            'percentage' => [
                'required',
                'numeric',
                'min:0'
            ]
        ];
    }
}
