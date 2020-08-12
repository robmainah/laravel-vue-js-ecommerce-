<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            "name" => "required | string",
            // "name" => "required | regex:/^[a-zA-Z\s]+$/",
            "email" => "required|email|unique:customers,email," . $request->id,
            "idNumber" => "required | numeric",
            "phone_number" => "required | numeric|min:7",
            "address" => "required",
            "gender" => "required",
            "active" => "sometimes|required",
            "password" => "sometimes|required|confirmed",
            "password_confirmation" => "sometimes|required",
        ];
    }
}