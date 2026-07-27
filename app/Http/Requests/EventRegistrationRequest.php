<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.\']+$/',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50|regex:/^[\+\d\s\-\(\)]{7,20}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'Event selection is required.',
            'event_id.exists' => 'Event does not exist.',
            'name.required' => 'Please enter your full name.',
            'name.regex' => 'Name should only contain letters, spaces, and basic punctuation.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Please enter a valid phone number (e.g., +27 71 461 1401).',
        ];
    }
}