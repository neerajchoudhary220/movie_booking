<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'PUSHER_APP_ID'      => ['required', 'string'],
            'PUSHER_APP_KEY'     => ['required', 'string'],
            'PUSHER_APP_SECRET'  => ['required', 'string'],
            'PUSHER_APP_CLUSTER' => ['required', 'string'],
            'PUSHER_PORT'        => ['required', 'numeric'],
            'PUSHER_SCHEME'      => ['required', 'in:http,https'],

            'MAIL_MAILER'        => ['required', 'string'],
            'MAIL_HOST'          => ['required', 'string'],
            'MAIL_PORT'          => ['required', 'numeric'],
            'MAIL_USERNAME'      => ['required', 'string'],
            'MAIL_PASSWORD'      => ['required', 'string'],
            'MAIL_FROM_ADDRESS'  => ['required', 'email'],
            'MAIL_FROM_NAME'     => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'PUSHER_SCHEME.in' => 'Pusher scheme must be either http or https.',
            'MAIL_FROM_ADDRESS.email' => 'Please provide a valid sender email address.',
        ];
    }
}
