<?php

namespace App\Http\Requests;

use App\Models\Theatre;
use Illuminate\Foundation\Http\FormRequest;

class StoreTheatreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Theatre::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'state' => ['nullable', 'string', 'max:120'],
            'pincode' => ['nullable', 'string', 'max:10'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function attributes(): array
    {
        return [
            'manager_id' => 'Manager',
        ];
    }
}
