<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'username' => 'required|string|alpha_dash|min:8|max:16|unique:users,username,' . Auth::id(),
            'name' => 'required|string|min:8|max:200',
            'email' => 'required|email:dns|unique:users,email,' . Auth::id(),
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => __('Username'),
            'name' => __('Full Name'),
            'email' => __('Email'),
        ];
    }
}
