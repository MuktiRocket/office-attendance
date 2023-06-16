<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRegistrationRequest extends FormRequest
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
            'first_name'    =>  'required|string|max:255',
            'last_name'     =>  'required|string|max:255',
            'email'         =>  'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'phone_number'  =>  'required|numeric|digits:10|unique:users,phone_number,NULL,id,deleted_at,NULL',
            'password'      =>  'required|unique:users,password,NULL,id,deleted_at,NULL',
            'company'       =>  'numeric|nullable',
            'designation'   =>  'required|numeric',
            'branch'        =>  'numeric|nullable'
        ];
    }
}
