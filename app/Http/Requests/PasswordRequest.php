<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => 'required|current_password ',
            'new_password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers()
            ],
            're_password' => 'required|same:new_password'
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => __('Current Password'),
            'new_password' => __('New Password'),
            're_password' => __('Re-Password')
        ];
    }
}
