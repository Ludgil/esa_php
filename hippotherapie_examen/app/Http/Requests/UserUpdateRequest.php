<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

     /**
     * Vérifier qu'il reste toujours au moins un administrateur
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Vérifiez si le rôle a changé
            $editedUser = $this->route('user');
            if ($editedUser->role === 'admin' && $this->role === 'user') {

                // Compte le nombre d'autres admins existants
                $adminCount = \App\Models\User::where('role', 'admin')
                               ->where('id', '!=', $editedUser->id)
                               ->count();
                
                // Si aucun autre admin n'est présent, on ajoute l'erreur de validation
                if ($adminCount === 0) {
                    $validator->errors()->add('role', 'Vous ne pouvez pas rétrograder le dernier administrateur.');
                }
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:80',
            'email' => 'required|email|unique:users,email' . $this->route('user')->id,
            'role' => 'required|in:admin,user',
        ];

        if ($this->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 80 caractères.',
        
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être une adresse valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
        
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        
            'role.required' => 'Le rôle est requis.',
            'role.in' => 'Le rôle doit être soit "admin" soit "user".',
        ];
    }
}
