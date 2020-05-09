<?php

    namespace App\Http\Requests\Api;

    class CreateUserRating extends FormRequest
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
                'rating' => ['required', 'integer', 'between:1,5'],
                'establishment_id' => ['required', 'integer'],
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
                'rating.required' => 'Erro, obrigatório preenchimento do nota da avaliação!',
                'rating.integer' => 'Erro ao avaliar, é permitido apenas números!',
                'rating.between' => 'Erro ao avaliar estabelecimento permitido apenas números de 1 a 5!',
                'establishment_id.required' => 'Erro desconhecido ao avaliar, por favor tente novamente!',
                'establishment_id.integer' => 'Erro desconhecido ao avaliar, por favor tente novamente!',
            ];
        }
    }
