<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreEvents extends FormRequest
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
            'title'=>'required|max:50',
            'description'=>'required',
            'picture'=>'required',
            'day'=>'required|numeric',
            'month'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max'=>'Title must not reach 50 characters',
            'day.numeric'=>'phone number has only numbers',
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
