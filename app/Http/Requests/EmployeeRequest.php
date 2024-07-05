<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'firstName' => 'required|min:2|max:50',
            'lastName' => 'required|max:50',
            'email' => 'nullable|email',
            'phone' => 'nullable|min:8|max:20',
        ];
    }
}
