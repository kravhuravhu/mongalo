<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaptismRequest extends FormRequest
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
            'location' => 'required|string|max:255',
            'preferred_date' => 'nullable|date|after:today',
            'message' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.regex' => 'Name should only contain letters, spaces, hyphens, and apostrophes.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Please enter a valid phone number (e.g., +27 71 461 1401).',
            'location.required' => 'Please enter your location.',
            'preferred_date.after' => 'Preferred date must be in the future.',
            'message.max' => 'Message cannot exceed 1000 characters.',
        ];
    }
}