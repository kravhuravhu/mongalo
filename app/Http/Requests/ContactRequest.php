<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'phone' => 'nullable|string|max:50|regex:/^[\+\d\s\-\(\)]{7,20}$/',
            'subject' => 'required|string|max:255|in:General Enquiry,Book Order,Event Registration,Invite Arthur,Baptism Request,Other',
            'message' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.regex' => 'Name should only contain letters, spaces, and basic punctuation.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.regex' => 'Please enter a valid phone number (e.g., +27 71 461 1401).',
            'subject.required' => 'Please select a subject.',
            'subject.in' => 'Please select a valid subject.',
            'message.required' => 'Please enter your message.',
            'message.max' => 'Message cannot exceed 2000 characters.',
        ];
    }
}