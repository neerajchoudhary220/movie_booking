<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Booking::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function prepareForValidation()
    {
        if (is_string($this->seats)) {
            $this->merge([
                'seats' => array_filter(explode(',', $this->seats))
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'show_id' => ['required', 'exists:shows,id'],
            'seats' => ['required', 'array', 'min:1'],
            'seats.*' => ['exists:seats,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'show_id.required' => 'Show selection is required.',
            'seats.required' => 'Please select at least one seat.',
            'seats.*.exists' => 'One or more selected seats are invalid.',
        ];
    }
}
