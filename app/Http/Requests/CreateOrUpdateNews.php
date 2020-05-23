<?php

    namespace App\Http\Requests;

    class CreateOrUpdateNews extends FormRequest
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
                'title'        => ['required', 'min:5'],
                'description'  => ['required', 'min:10'],
                'important'    => ['string']
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
                'title.required' => 'Campo [Título] é obrigatório, favor informe!',
                'title.min' => 'Campo [Título] deve conter no mínimo 5 caracteres, favor corrija e tente novamente!',
                'description.required' => 'Campo [Descrição da Notícia] é obrigatório, favor informe!',
                'description.min' => 'Campo [Descrição da Notícia] deve conter no mínimo 10 caracteres, favor corrija e tente novamente!',
                'important' => 'Erro, desconhecido, recarregue a página e tente novamente!'
            ];
        }
    }
