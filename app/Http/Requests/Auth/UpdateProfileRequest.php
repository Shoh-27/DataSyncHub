<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'timezone' => ['nullable', 'timezone'],
            'language' => ['nullable', 'string', 'size:2'],
            'skills' => ['nullable', 'array', 'max:15'],
            'skills.*' => ['integer', 'exists:skills,id'],
            'profile_visibility' => ['nullable', 'in:public,connections,private'],
            'avatar' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'],
        ];
    }


}
