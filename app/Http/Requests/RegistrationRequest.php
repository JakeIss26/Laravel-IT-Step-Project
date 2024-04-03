<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'birth_date' => 'required|date',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'avatar_path' => 'required|string',
        ];
    }
}
