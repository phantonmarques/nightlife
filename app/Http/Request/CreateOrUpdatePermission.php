<?php

    namespace App\Http\Requests;

    class CreateOrUpdatePermission extends FormRequest
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
                'name' => ['required'],
                'slug' => ['required'],
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
                'name.required' => 'Campo [Nome] é obrigatório, favor informe!',
                'slug.required' => 'Campo [Permissão] é obrigatório, favor informe!',
            ];
        }
    }
