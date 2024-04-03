<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'nullable',
            'publication_time' => 'required|date',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date', 
        ];
    }
}
