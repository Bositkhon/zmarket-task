<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DerecogniseFromBalanceFormRequest extends FormRequest
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
                'min:5',
                function ($attribute, $value, $fail) {
                    if ($value > Auth::user()->wallet->balance) {
                        $fail(__('validation.amount_is_bigger_than_balance', ['attribute' => $attribute]));
                    }
                }
            ]
        ];
    }
}
