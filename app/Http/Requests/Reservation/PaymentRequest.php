<?php

namespace App\Http\Requests\Reservation;

use App\Models\PaymentVendor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'selected_payment_vendor' => [
                'required',
                Rule::in(PaymentVendor::get()->pluck('id'))
            ],
            'proof_of_payment' => 'nullable|image|max:2048'
        ];
    }

    public function attributes(): array
    {
        return [
            'selected_payment_vendor' => __('Payment Vendor'),
            'proof_of_payment' => __('Proof of Payment'),
        ];
    }
}
