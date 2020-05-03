<?php

namespace App\Http\Requests;

class UpdatePassword extends FormRequest
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
            'password' => ['min:6', 'required'],
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
            'password.min' => 'O campo [Nova Senha] deve conter no mínimo 6 caracteres',
            'password.required' => 'O campo [Nova Senha] é obrigatório!'
        ];
    }
}
