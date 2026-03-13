<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StorewalletRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'currency' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom du wallet est obligatoire.'
        ];
    }



public function failedValidation(Validator $validator)
{
    $errors = $validator->errors();

    return response()->json([
        "success" => false,
        'message' => 'Erreur de validation',
        'errors' => $errors->messages()
    ]);
}
}
