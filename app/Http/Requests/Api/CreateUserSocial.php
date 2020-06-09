<?php

    namespace App\Http\Requests\Api;

    class CreateUserSocial extends FormRequest
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
                'displayName' => ['required', 'string', 'min:3'],
                'email' => ['string', 'required'],
                'socialNetwork' => ['required','min:3'],
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
                'name.required' => 'Ocorreu um erro ao conectar a conta!',
                'name.string' => 'Ocorreu um erro ao conectar a conta!',
                'name.min' => 'Ocorreu um erro ao conectar a conta!',
                'email.required' => 'Ocorreu um erro ao conectar a conta! (1)',
                'email.string' => 'Ocorreu um erro ao conectar a conta! (2)',
                'typeSocial.min' => 'Ocorreu um erro ao conectar a conta!',
            ];
        }
    }
