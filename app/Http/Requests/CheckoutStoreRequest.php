<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_count' => 'required',
            'grand_total' => 'required',
            'payment_method' => 'required',
            'payment_status' => 'required',
            'user_address_id' => 'required|exists:user_addresses,id',
            'cart_id' => 'required'
        ];
    }
}
