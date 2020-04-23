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
            $passwordRequired = 'required';

            /** @var \App\Models\Admin\Establishment The establishment to update */
            $user = $this->route()
                ->parameter('user');

            // Append parameters for EMAIL AND CPF_CNPJ REGISTRATION validation
            if ($user instanceof User) {
                $emailUnique = ',email,' . $user->id;
                $cpfcnpjUnique = ',cpf_cnpj,' . $user->id;
                $passwordRequired = '';
            }

            $rules = [
                'name' => ['required', 'string', 'min:3'],
                'email' => ['required', 'string', 'unique:user' . $emailUnique],
                'password' => ['min:6', $passwordRequired],
                'cpf_cnpj' => ['string', 'min:11', 'unique:user' . $cpfcnpjUnique],
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
                'password.min' => 'O campo [Senha] deve conter no mínimo 3 caracteres',
                'password.required' => 'O campo [Senha] é obrigatório!',
                'cpf_cnpj.required' => 'O campo [CPF/CNPJ] é obrigatório, favor preencha!',
                'cpf_cnpj.string' => 'O campo [CPF/CNPJ] é obrigatório, favor preencha!',
                'cpf_cnpj.min' => 'O campo [CPF/CNPJ] deve conter no mínimo 11 números!',
                'cpf_cnpj.unique' => 'Já existe esse cpf/cnpj cadastrado, favor informe outro!',
            ];
        }
    }
