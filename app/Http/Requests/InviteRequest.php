<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.\']+$/',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50|regex:/^[\+\d\s\-\(\)]{7,20}$/',
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'expected_attendance' => 'nullable|integer|min:1|max:10000',
            'message' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.regex' => 'Name should only contain letters, spaces, and basic punctuation.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Please enter a valid phone number (e.g., +27 71 461 1401).',
            'event_name.required' => 'Please enter the event name.',
            'event_date.required' => 'Please select an event date.',
            'event_date.after' => 'Event date must be in the future.',
            'location.required' => 'Please enter the event location.',
            'expected_attendance.min' => 'Expected attendance must be at least 1.',
            'expected_attendance.max' => 'Expected attendance cannot exceed 10,000.',
            'message.max' => 'Message cannot exceed 2000 characters.',
        ];
    }
}