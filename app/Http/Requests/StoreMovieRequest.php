<?php

namespace App\Http\Requests;

use App\Models\Movie;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Movie::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:movies,title',
            'slug' => 'nullable|string|max:255|unique:movies,slug',
            'category' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:100',
            'duration' => 'nullable|integer|min:1|max:500',
            'release_date' => 'nullable|date',
            'poster_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:active,inactive',
        ];
    }
}
