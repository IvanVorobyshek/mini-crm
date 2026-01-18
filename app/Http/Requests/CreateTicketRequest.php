<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'description' => ['required', 'max:5000'],
            'files.*' => ['nullable', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,doc,docx'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone number must be in E.164 format',
            'files.*.max' => 'Each file must not exceed 10MB',
            'subject.required' => 'Subject is required',
            'subject.max' => 'Subject must not exceed 255 characters',
            'description.required' => 'Description is required',
            'description.max' => 'Description must not exceed 5000 characters',
        ];
    }
}
