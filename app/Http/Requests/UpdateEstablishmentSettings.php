<?php

namespace App\Http\Requests;

class UpdateEstablishmentSettings extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'description' => ['min:10', 'required'],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.min' => 'O campo [Detalhes Estabelecimento] deve conter no mínimo 10 caracteres',
            'description.required' => 'O campo [Detalhes Estabelecimento] é obrigatório!'
        ];
    }
}
