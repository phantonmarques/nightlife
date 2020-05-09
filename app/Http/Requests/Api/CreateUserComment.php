<?php

    namespace App\Http\Requests\Api;

    class CreateUserComment extends FormRequest
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
                'comment' => ['required', 'string'],
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
                'comment.required' => 'Erro, obrigatório preenchimento do comentário!',
                'comment.string' => 'Erro desconhecido ao comentar no estabelecimento, por favor tente novamente!',
                'establishment_id.required' => 'Erro desconhecido ao comentar no estabelecimento, por favor tente novamente!',
                'establishment_id.integer' => 'Erro desconhecido ao comentar no estabelecimento, por favor tente novamente!',
            ];
        }
    }
