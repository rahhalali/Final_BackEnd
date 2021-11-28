<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormValication extends FormRequest
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
    public function rules(): array
    {
        return [
            'first_name'=>'required|max:20',
            'last_name'=>'required|max:20',
            'email'=>'required|email|unique:users',
            'phone_number'=>'required|numeric',
            'employee_positions_id'=>'required|numeric',
            'password'=>'required'
        ];
    }

    public function messages(): array
    {
       return [
           'first_name.max'=>'FirstName must not reach 20 characters',
           'last_name.max'=>'FirstName must not reach 20 characters',
           'phone_number.numeric'=>'phone number has only numbers',
           'employee_positions_id.required'=>'You must have to choose a role',
           'email.unique'=>'This email is already taken'
       ];
    }
}
