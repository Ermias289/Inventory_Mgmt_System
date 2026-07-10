<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $productId = $this->route('product');


        return [

            'category_id'=>[
                'sometimes',
                'exists:categories,id'
            ],


            'name'=>[
                'sometimes',
                'string',
                'max:255'
            ],


            'sku'=>[
                'sometimes',
                'string',
                'unique:products,sku,'.$productId
            ],


            'description'=>[
                'nullable',
                'string'
            ],


            'cost_price'=>[
                'sometimes',
                'numeric',
                'min:0'
            ],


            'selling_price'=>[
                'sometimes',
                'numeric',
                'gte:cost_price'
            ]

        ];

    }
}
