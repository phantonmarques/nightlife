<?php

    namespace App\Http\Requests;

    use App\Models\Admin\Called;

    class CreateOrUpdateCalled extends FormRequest
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
            $subjectRequired = 'required';
            $descriptionRequired = 'required';

            /** @var \App\Models\Admin\Establishment The establishment to update */
            $called = $this->route()
                ->parameter('called');

            // Append parameters for SUBJECT AND DESCRIPTION REGISTRATION validation
            if ($called instanceof Called) {
                $subjectRequired = '';
                $descriptionRequired = '';
            }

            $rules = [
                'subject'          => [$subjectRequired, 'min:3'],
                'status'           => ['required'],
                'description'      => [$descriptionRequired, 'min:10'],
                'situation'        => ['min:3'],
                'date_service'     => ['required', 'date_format:Y-m-d', 'date'],
                'time_service'     => ['date_format:H:i'],
                'visible'          => ['boolean']
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
                'name.required'            => 'Campo [Assunto] é obrigatório, favor informe!',
                'name.min'                 => 'Campo [Assunto] deve conter no mínimo 3 caracteres!',
                'status.required'          => 'Erro desconhecido, recarregue a pagina e tente novamente!',
                'description.required'     => 'Campo [Descrição Chamado] é obrigatório, favor informe!',
                'description.min'          => 'Campo [Descrição Chamado] deve conter no mínimo 10 caracteres!',
                'situation.min'            => 'Selecione uma situação referente ao chamado!',
                'date_service.required'    => 'Erro desconhecido, recarregue a pagina e tente novamente!',
                'date_service.date_format' => 'Erro desconhecido, recarregue a pagina e tente novamente!',
                'date_service.date'        => 'Erro desconhecido, recarregue a pagina e tente novamente!',
                'time_service.date_format' => 'Erro desconhecido, recarregue a pagina e tente novamente!',
                'visible.boolean' => 'Erro desconhecido, recarregue a pagina e tente novamente!',
            ];
        }
    }
