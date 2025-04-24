<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingdetailRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string',
					'address' => 'required|string',
					'payment_status' => 'required|string',
					'subtotal' => 'required|string',
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => 'required|string',
					'address' => 'required|string',
					'payment_status' => 'required|string',
					'subtotal' => 'required|string',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
 			'address.required' => 'The address field is required.',
 			'payment_status.required' => 'The payment status field is required.',
 			'subtotal.required' => 'The sub total field is required.',
        ];
    }
}
