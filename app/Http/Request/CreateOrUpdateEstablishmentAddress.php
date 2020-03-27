<?php

    namespace App\Http\Requests;

    class CreateOrUpdateEstablishmentAddress extends FormRequest
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
            //            if ($this->user()->role->isAdmin()) {
//                $rules['customer_id'] = 'required';
//            }

            $rules = [
                "contact.*.name"        => ['string', 'min:3'],
                "contact.*.phone"       => ['string', 'min:11'],
                "contact.*.whatsapp"    => ['min:1'],
                "zip_code"              => ['required', 'integer', 'digits_between:8,9'],
                "street_name"           => ['required', 'string', 'min:5'],
                "building_number"       => ['required', 'integer'],
                "neighborhood"          => ['required', 'string', 'min:3'],
                "state_id"              => ['required', 'min:2'],
                "city_id"               => ['required', 'integer'],
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
                'contact.*.name.min'            => 'Favor preencha [Nome] e [Telefone] do contato OBRIGATÓRIAMENTE, se não remova!',
                'contact.*.phone.min'           => 'Favor preencha [Nome] e [Telefone] do contato OBRIGATÓRIAMENTE, se não remova!',
                'contact.*.whatsapp.min'        => 'Favor preencha [Nome] e [Telefone] do contato OBRIGATÓRIAMENTE, se não remova!',
                'zip_code.required'             => 'O cep é obrigatório!',
                'zip_code.digits_between'       => 'Informe o cep corretamente!',
                'zip_code.integer'              => 'Informe o cep corretamente!',
                'street_name.required'          => 'O endereço é obrigatório!',
                'street_name.min'               => 'O endereço deve conter no mínimo cinco caracteres',
                'building_number.required'      => 'O número é obrigatório!',
                'building_number.min'           => 'O número deve conter apenas números',
                'neighborhood.required'         => 'Selecione um bairro!',
                'neighborhood.min'              => 'Selecione um bairro!',
                'state_id.required'             => 'Selecione um estado!',
                'state_id.min'                  => 'Selecione um estado!',
                'city_id.required'              => 'Selecione uma cidade!',
                'city_id.integer'               => 'Selecione uma cidade!',
            ];
        }
    }
