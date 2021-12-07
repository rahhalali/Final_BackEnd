<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreFeatures extends FormRequest
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
            'description'=>'required',
            'room_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            "description.required"=>"Description must be filled",
            'room_id.required'=>'You must Select Room first'
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
