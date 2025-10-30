<?php

namespace App\Http\Requests;

use App\Models\Screen;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('show'));
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
            'screen_id'    => [
                'required',
                'exists:screens,id',
                function ($attribute, $value, $fail) {
                    $user = $this->user();

                    // Only check if user is a Manager
                    if ($user->hasRole('Manager')) {
                        $isAllowed = Screen::where('id', $value)
                            ->whereHas('theatre', fn($q) => $q->where('manager_id', $user->id))
                            ->exists();
                        if (!$isAllowed) {
                            $fail('You are not authorized to create shows for this screen.');
                        }
                    }
                },
            ],
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'base_price' => 'required|numeric|min:0',
            // 'price_map' => 'nullable|array',
            'status' => 'required|in:scheduled,running,completed,cancelled',
            'lock_minutes' => 'nullable|integer|min:1|max:30',
        ];
    }

    public function attributes(): array
    {
        return [
            'movie_id' => 'movie',
            'screen_id' => 'screen'
        ];
    }
}
