<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticlesRequest extends FormRequest
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
            'article_name' => "required",
            'categorie_id' => "required",
            'price_achat' => "required",
            'price_vente' => "required",
            'unite_mesure' => "required",
            'codebar_article' => "string",
        ];
    }
    public function messages()
    {
        return [
            'article_name.required' => "Le Nom de l'article requis",
            'categorie_id.required' => "La categorie article requis",
            'price_achat.required' => "Le Prix d'achat requis",
            'price_vente.required' => "Le prix de Vente requis",
            'unite_mesure.required' => "L'unite de Mesure requis",
        ];
    }
}
