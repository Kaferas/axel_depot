<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_unit' => ['required', 'min:2', 'string'],
            'description_unit' => 'string|max:255|nullable'
        ];
    }


    public function messages()
    {
        return [
            'name_unit.required' => "L'Unite de Mesure requis",
            'name_unit.min' => "L'Unite de Mesure doit faire 2 caracteres Minimum",
        ];
    }
}
