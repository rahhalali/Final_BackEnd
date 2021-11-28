<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class StoreUserValidation extends FormRequest
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
            'email'=>'required|email',
            'password'=>'required|min:5',
            'phone_number'=>'required|numeric'
        ];
    }
    public function messages()
    {
     return [
         "first_name.required"=>"firstName must be required",
         "last_name.required"=>"lastName must be required",
         'password.min'=>'password must be greater than 5 characters',
         'phone_number'=>'Must be only Numbers'

     ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors());
        $errors = $errors->collapse();


        $response = response()->json([
            "status"=>400,
            'success' => false,
            'message' => 'Ops! Some errors occurred',
            'errors' => $validator->errors()
        ]);


        throw (new ValidationException($validator, $response));
    }
}
