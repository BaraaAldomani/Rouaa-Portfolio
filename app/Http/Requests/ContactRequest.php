<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            // Honeypot: real users never see or fill this field.
            'website' => ['nullable', 'prohibited'],
        ];
    }

    public function messages(): array
    {
        return ['website.prohibited' => __('contact.form.spam')];
    }
}
