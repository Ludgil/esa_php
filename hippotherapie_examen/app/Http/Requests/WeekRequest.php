<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Week;

class WeekRequest extends FormRequest
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
            'year' => 'required|integer|min:2000|max:2099',
        ];
    }

    public function messages()
    {
        return [
            'year.required' => 'L\'année est requise.',
            'year.integer' => 'L\'année doit être un nombre entier.',
            'year.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'year.max' => 'L\'année doit être inférieure ou égale à 2099.',
        ];
    }

}
