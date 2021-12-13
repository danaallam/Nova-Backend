<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Validation\ValidationException;
//use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
        return[
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:3'
        ];
    }

//        protected function failedValidation(Validator $validator)
//    {
//
//        $errors = collect($validator->errors());
//        $response = response()->json([
//            'success' => false,
//            'message' => 'Errors occured',
//            'errors' => $errors
//        ],400);
//
//        throw (new ValidationException($validator,$response));
//
//    }
}
