<?php

namespace App\Http\Requests;

use App\Models\Screen;
use Illuminate\Foundation\Http\FormRequest;

class StoreScreenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Screen::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'theatre_id' => 'required|exists:theatres,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'rows' => 'required|integer|min:1',
            'cols' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function attributes(): array
    {
        return [
            'theatre_id' => 'theater',
            'name' => 'screen name'
        ];
    }
}
