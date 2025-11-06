<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $contact = $this->route('contact');
        return auth()->check() && $contact && $contact->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required','string','max:120'],
            'email' => ['nullable','email','max:120'],
            'phone' => ['required','string','max:30'],
            'image' => ['nullable','image','max:2048'],
            '_remove_image' => ['nullable','boolean'],
        ];
    }
}
