<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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

    //   protected function getValidatorInstance()
    // {
    //     $validator = parent::getValidatorInstance();
    //     $validator->sometimes('image', 'required', function ($input) { });
    //     return $validator;
    // }
    public function rules(Request $request)
    {
        return [
            'category' => 'required',
            'title' => 'required|max:255|unique:products,title,' . $request->id,
            'description' => 'required',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
    }
}