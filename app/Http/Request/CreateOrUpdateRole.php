<?php

    namespace App\Http\Requests;

    class CreateOrUpdateRole extends FormRequest
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
                'name'          => ['required'],
                'slug'          => ['required'],
                'permission.*'  => ['required'],
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
                'name.required'         => 'Campo [Nome] é obrigatório, favor informe!',
                'slug.required'         => 'Campo [Função] é obrigatório, favor informe!',
                'permission.*.required' => 'Campo [Permissões] é obrigatório, informe pelo menos uma!',
            ];
        }
    }
