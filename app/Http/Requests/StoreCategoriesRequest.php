<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriesRequest extends FormRequest
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
            'nom_categorie' => "required",
            'color_categorie' => "required",
        ];
    }

    public function messages()
    {
        return [
            'nom_categorie.required' => "Le Nom de la Categorie requis",
            'color_categorie.required' => "La Couleur est requis",
        ];
    }
}
