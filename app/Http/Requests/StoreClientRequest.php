<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name_client' => "required",
            'prenom_client' => "required",
            'phone_client' => "required",
            'adresse_client' => "string",
            'nif_client' => "string",
        ];
    }
    public function messages()
    {
        return [
            'name_client.required' => "Nom du Client requis",
            'prenom_client.required' => "Prenom Client requis",
            'phone_client.required' => "Numero de Telephone requis",
            'adresse_client.string' => "L\'adresse doit etre une chaine de caractere",
            'nif_client.string' => "Le NIF du Client est requis",
        ];
    }
}
