<?php

namespace App\Http\Requests;

use App\Models\Show;
use Illuminate\Foundation\Http\FormRequest;

class StoreShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Show::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'screen_id' => 'required|exists:screens,id',
            'starts_at' => 'required|date|after:now',
            'ends_at' => 'nullable|date|after:starts_at',
            'base_price' => 'required|numeric|min:0',
            'price_map' => 'nullable|array',
            'status' => 'required|in:scheduled,running,completed,cancelled',
            'lock_minutes' => 'nullable|integer|min:1|max:30',
        ];
    }
}
