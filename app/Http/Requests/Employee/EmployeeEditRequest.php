<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeEditRequest extends FormRequest
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
            'id'            =>  'required',
            'first_name'    =>  'required|string|max:255',
            'last_name'     =>  'nullable|string|max:255',
            'email'         =>  'nullable|string|email|max:255|unique:users,email,' . $this->id . ',id,deleted_at,NULL',
            'phone_number'  =>  'nullable|numeric|digits:10|unique:users,phone_number,' . $this->id . ',id,deleted_at,NULL',
            'password'      =>  'nullable|unique:users,password'
        ];
    }
}
