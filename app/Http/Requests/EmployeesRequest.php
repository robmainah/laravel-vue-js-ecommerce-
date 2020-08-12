<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class EmployeesRequest extends FormRequest
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
            // "name" => "required | regex:/^[a-zA-Z\s]+$/",
            "name" => "required|string",
            "email" => "required|email|unique:admins,email," . $request->id,
            "phone_number" => "required | numeric | digits:10",
            "idNumber" => "required | numeric",
            "dateOfBirth" => "required | date | before:today",
            "gender" => "required",
            "active" => "required",
            "roles" => "required",
        ];
    }
}