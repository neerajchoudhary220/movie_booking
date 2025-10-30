<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $booking = $this->route('booking');
        return $booking && (
            $this->user()->can('confirm', $booking) ||
            $this->user()->can('cancel', $booking)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:confirmed,cancelled'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'A booking status is required.',
            'status.in' => 'Invalid booking status.',
        ];
    }
}
