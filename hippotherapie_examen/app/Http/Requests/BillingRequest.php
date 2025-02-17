<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillingRequest extends FormRequest
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
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2024|max:2099',
        ];
    }

    public function messages()
    {
        return [
            'month.required' => 'Le mois est obligatoire.',
            'month.integer' => 'Le mois doit être un entier valide.',
            'month.between' => 'Le mois doit être compris entre 1 et 12.',

            'year.required' => "L'année est obligatoire.",
            'year.integer' => "L'année doit être un entier valide.",
            'year.min' => "L'année doit être au moins égale à 2024.",
            'year.max' => "L'année ne peut pas dépasser 2099.",
        ];
    }
}
