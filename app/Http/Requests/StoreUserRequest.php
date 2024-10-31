<?php

namespace App\Http\Requests;

use App\Rules\BloomUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                new BloomUnique('user_emails'),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ];
    }
}
