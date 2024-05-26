<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepotRequest extends FormRequest
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
            'nom_depot' => "required",
            'localite' => "required",
            'gerant_id' => "required",
            'telephone' => "required"
        ];
    }

    public function messages()
    {
        return [
            'nom_depot.required' => "Le Nom du Depot requis",
            'localite.required' => "L\'adresse du depot requis",
            'gerant_id.required' => "Le gerant requis",
            'telephone.required' => "Numero de Telephone requis"
        ];
    }
}
