<?php

    namespace App\Http\Requests;

    use App\Models\Admin\Establishment;

    class CreateOrUpdateEstablishment extends FormRequest
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

            $userUnique = '';
            $stateRegisterUnique = '';

            /** @var \App\Models\Admin\Establishment The establishment to update */
            $establishment = $this->route()
                ->parameter('establishment');

            // Append parameters for USER AND STATE REGISTRATION validation
            if ($establishment instanceof Establishment) {
                $userUnique = ',user_id,' . $establishment->user_id;
                $stateRegisterUnique = ',state_registration,' . $establishment->user_id;
            }

            $rules = [
                'user_id'               => ['required', 'numeric', 'unique:establishment'. $userUnique],
                'corporate_name'        => ['required', 'min:4', 'max:50'],
                'state_registration'    => ['required', 'min:5', 'max:22', 'unique:establishment'. $stateRegisterUnique],
                'type_license'          => ['required', 'min:1', 'max:1'],
                'status'                => ['required', 'boolean'],
            ];

//            if ($this->user()->role->isAdmin()) {
//                $rules['customer_id'] = 'required';
//            }

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
                'user_id.required'              => 'O cliente deve ser selecionado',
                'user_id.numeric'               => 'O cliente cadastrado deve conter apenas números',
                'user_id.unique'                => 'O cliente não deve conter cadastro em outro estabelecimento',
                'corporate_name.required'       => 'A razão social é obrigatória!',
                'corporate_name.min'            => 'A razão social deve conter no mínimo 4 caracteres',
                'corporate_name.max'            => 'A razão social deve conter no máximo 50 caracteres',
                'state_registration.required'   => 'A inscrição estadual é obrigatória!',
                'state_registration.min'        => 'A inscrição estadual deve conter no mínimo 5 caracteres',
                'state_registration.max'        => 'A inscrição estadual deve conter no máximo 22 caracteres',
                'state_registration.unique'     => 'Inscrição estadual já está sendo utilizada por outro estabelecimento, informe outro!',
                'type_license.required'         => 'Selecione uma opção válida para o tipo de licença do estabelecimento!',
                'type_license.min'              => 'Selecione uma opção válida para o tipo de licença do estabelecimento!',
                'type_license.max'              => 'Selecione uma opção válida para o tipo de licença do estabelecimento!',
                'status.required'               => 'Selecione uma opção válida de Status do estabelecimento!',
                'status.boolean'                => 'Selecione uma opção válida de Status do estabelecimento!',
            ];
        }
    }
