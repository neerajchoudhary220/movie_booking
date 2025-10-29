<?php

namespace App\Http\Requests;

use App\Models\Seat;
use Illuminate\Foundation\Http\FormRequest;

class StoreSeatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Seat::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'row_label' => 'required|string|max:3',
            'row_index' => 'required|integer|min:1',
            'col_number' => 'required|integer|min:1',
            'seat_number' => 'required|string|max:10',
            'type' => 'required|in:regular,premium,vip',
            'status' => 'required|in:available,pending,booked,blocked',
            'price_override' => 'nullable|numeric|min:0',
        ];
    }
}
