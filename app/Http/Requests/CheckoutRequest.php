<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:600'],
            'custom_amount' => ['nullable', 'numeric', 'min:1'],
            'honeypot' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'honeypot.size' => 'Ops! Alguma coisa deu errado.',
        ];
    }
}
