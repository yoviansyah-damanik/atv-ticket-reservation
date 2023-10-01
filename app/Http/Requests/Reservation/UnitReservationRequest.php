<?php

namespace App\Http\Requests\Reservation;

use App\Models\Unit;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UnitReservationRequest extends FormRequest
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
            'selected_units' => 'required|array',
            'selected_units.*' => Rule::in(Unit::get()->pluck('id')->toArray())
        ];
    }

    public function attributes()
    {
        return [
            'selected_units' => __('Selected Units'),
            'selected_units.*' => __('Unit'),
        ];
    }
}
