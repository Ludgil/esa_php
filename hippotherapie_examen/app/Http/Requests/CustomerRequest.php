<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|max:100',
            'street' => 'nullable|string|max:100',
            'number' => 'nullable|string|max:10',
            'postal_code' => 'required|numeric|min:4|max:4',
            'city' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 50 caractères.',
            
            'email.email' => 'L\'adresse e-mail doit être une adresse valide.',
            'email.max' => 'L\'adresse e-mail ne peut pas dépasser 100 caractères.',
            
            'street.string' => 'La rue doit être une chaîne de caractères.',
            'street.max' => 'La rue ne peut pas dépasser 100 caractères.',
            
            'number.string' => 'Le numéro doit être une chaîne de caractères.',
            'number.max' => 'Le numéro ne peut pas dépasser 10 caractères.',
            
            'postal_code.required' => 'Le code postal est requis.',
            'postal_code.numeric' => 'Le code postal doit être un nombre.',
            'postal_code.min' => 'Le code postal doit contenir exactement 4 chiffres.',
            'postal_code.max' => 'Le code postal doit contenir exactement 4 chiffres.',
            
            'city.string' => 'La ville doit être une chaîne de caractères.',
            'city.max' => 'La ville ne peut pas dépasser 50 caractères.',
            
            'phone.string' => 'Le téléphone doit être une chaîne de caractères.',
            'phone.max' => 'Le téléphone ne peut pas dépasser 20 caractères.',
        ];
    }
}
