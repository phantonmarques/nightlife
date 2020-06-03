<?php

    namespace App\Http\Requests\Api;

    use App\Models\Site\User;


    class CreateOrUpdateUser extends FormRequest
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
            $emailUnique = '';
            $cpfcnpjUnique = '';
            $nameRequired = 'required';
            $emailRequired = 'required';
            $passwordRequired = 'required';
            $favoriteRequired = '';

            /** @var \App\Models\Site\User The user to update */
            $user = auth()->user();

            // Append parameters for EMAIL AND CPF_CNPJ REGISTRATION validation
            if ($user instanceof User) {
                $emailUnique = ',email,' . $user->id;
                $cpfcnpjUnique = ',cpf_cnpj,' . $user->id;
                $passwordRequired = '';
                $nameRequired = '';
                $emailRequired = '';
                $favoriteRequired = 'required';
            }

            $rules = [
                'name' => [$nameRequired, 'string', 'min:3'],
                'email' => [$emailRequired, 'string', 'unique:user' . $emailUnique],
                'password' => [$passwordRequired, 'min:6', 'confirmed'],
                'cpf_cnpj' => ['string', 'min:11', 'unique:user' . $cpfcnpjUnique],
                'city_id' => ['integer', 'digits_between:1,5'],
                'favorite_rhythms' => ['nullable'],
                'favorite_categorys' => ['nullable'],
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
                'name.required' => 'O campo [Nome] é obrigatório, favor preencha!',
                'name.string' => 'O campo [Nome] é obrigatório, favor preencha!',
                'name.min' => 'O campo [Nome] deve conter no mínimo 3 caracteres!',
                'email.required' => 'O campo [E-mail] é obrigatório, favor preencha!',
                'email.string' => 'O campo [E-mail] é obrigatório, favor preencha!',
                'email.unique' => 'Já existe esse e-mail cadastrado, favor informe outro!',
                'password.min' => 'O campo [Senha] deve conter no mínimo 6 caracteres',
                'password.required' => 'O campo [Senha] é obrigatório!',
                'cpf_cnpj.string' => 'O campo [CPF/CNPJ] é obrigatório, favor preencha!',
                'cpf_cnpj.min' => 'O campo [CPF/CNPJ] deve conter no mínimo 11 números!',
                'cpf_cnpj.unique' => 'Já existe esse cpf/cnpj cadastrado, favor informe outro!',
                'city_id.integer' => 'Cidade inválida, favor verifique!',
                'city_id.digits_between' => 'Cidade inválida, favor verifique!',
                'favorite_rhythms.required' => 'Lista de Categoria é obrigatória!',
                'favorite_categorys.required' => 'Lista de Categoria é obrigatória',
            ];
        }
    }
