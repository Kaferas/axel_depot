<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFournisseurRequest extends FormRequest
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
            'nom_fournisseur' => "required",
            'prenom_fournisseur' => "required",
            'telephone' => "required",
            'boite_postal' => "string",
            'email' => "email"
        ];
    }

    public function messages()
    {
        return [
            'nom_fournisseur.required' => "Le Nom du Fournisseur requis",
            'prenom_fournisseur' => "Le Prenom requis",
            'telephone,required' => "Le Numero de Telephone requis",
            'boite_postal.string' => "Boite postal doit etre une chaine de caractere",
            'email.email' => "L'adresse doit etre une adresse Mail valide",
        ];
    }
}
