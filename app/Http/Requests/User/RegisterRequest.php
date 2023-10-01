<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|min:8|max:16|unique:users,username',
            'name' => 'required|string|min:8|max:200',
            'email' => 'required|email:dns|unique:users,email',
            'password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers()
            ],
            're_password' => 'required|same:password'
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => __('Username'),
            'name' => __('Full Name'),
            'email' => __('Email'),
            'password' => __('Password'),
            're_password' => __('Re-Password')
        ];
    }
}
