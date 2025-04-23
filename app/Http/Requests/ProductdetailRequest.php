<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductdetailRequest extends FormRequest
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
                    'product_id' => '',
                    'unit_id' => '',
                    'unit_value' => 'required|string',
                    'color_id' => '',
                    'size_id' => '',
                    'purchase_price' => 'required|string',
                    'selling_price' => 'required|numeric',
                    'tax' => 'nullable|numeric',
                    'discount' => 'nullable|numeric',
                    'total_price' => 'required|numeric',
                    'image' => 'nullable|mimes:png,jpg,jpeg|max:25048',
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'product_id' => '',
                    'unit_id' => '',
                    'unit_value' => 'required|string',
                    'color_id' => '',
                    'size_id' => '',
                    'purchase_price' => 'required|string',
                    'selling_price' => 'required|numeric',
                    'tax' => 'nullable|numeric',
                    'discount' => 'nullable|numeric',
                    'total_price' => 'required|numeric',
                    // 'image' => 'nullable|mimes:png,jpg,jpeg|max:25048',
                ];
                if ($this->hasFile('image')) {
                    $rules['image'] = 'nullable|file|mimes:png,jpg,jpeg|max:25048';
                } else {

                    $rules['image'] = 'nullable';
                }
                return $rules;
                break;
        }
    }

    public function messages()
    {
        return [
            'product_id.required' => 'The product name field is required.',
            'unit_id.required' => 'The unit name field is required.',
            'unit_value.required' => 'The unit value field is required.',
            'color_id.required' => 'The color name field is required.',
            'size_id.required' => 'The size name field is required.',
            'purchase_price.required' => 'The purchase price field is required.',
            'selling_price.required' => 'The selling price field is required.',
            'tax.nullable' => 'The purchase price field is required.',
            'discount.nullable' => 'The purchase price field is required.',
            'total_price.required' => 'The purchase price field is required.',
        ];
    }
}
