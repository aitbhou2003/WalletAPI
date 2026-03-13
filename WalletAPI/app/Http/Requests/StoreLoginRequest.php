<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationRuleParser;

class StoreLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRuleParser|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Identifiants incorrects.'
        ];
    }


    public function failedValidation(Validator $validator)
    {


        $error = $validator->errors();
        return response()->json([
            "succes" => false,
            "message" => $error->messages()
        ]);
    }
        
}
