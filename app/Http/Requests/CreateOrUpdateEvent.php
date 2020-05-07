<?php

    namespace App\Http\Requests;

    use App\Models\Admin\Event;

    class CreateOrUpdateEvent extends FormRequest
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
            $eventName = '';
            $coverPath = 'required';

            /** @var \App\Models\Admin\Establishment The establishment to update */
            $event = $this->route()
                ->parameter('event');

            // Append parameters for EMAIL AND CPF_CNPJ REGISTRATION validation
            if ($event instanceof Event) {
                $eventName = ',name,' . $event->id;
                $coverPath = '';
            }

            $dateLimit =  date("Y-m-d", strtotime('-1 day'));

            $rules = [
                'name'                      => ['required', 'min:5', 'unique:event' . $eventName],
                'cover_path'                => [$coverPath , 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'date_event'                => ['required', 'date_format:Y-m-d', 'date', 'after:' . $dateLimit],
                'start_time'                => ['date_format:H:i'],
                'end_time'                  => ['date_format:H:i'],
                'establishment_address_id'  => ['required'],
                'price'                     => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'description'               => ['required', 'min:10'],
                'status'                    => ['required']

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
                'name.min' => 'Campo [Nome] deve conter no mínimo 5 caracteres, favor corrija e tente novamente!',
                'unique.min' => 'Já existe um evento com esse nome, favor informe outro!',
                'cover_path.required' => 'Favor, insira imagem para capa do evento!',
                'cover_path.image' => 'Imagem inválida, favor insira uma imagem no formato correto!',
                'cover_path.mimes' => 'Imagem inválida, favor insira uma imagem no formato correto (jpeg, jpg, png, gif e svg)!',
                'cover_path.max' => 'Imagem inválida, favor insira uma imagem no formato correto!',
                'date_event.required' => 'Informe data do evento!',
                'date_event.date_format' => 'Informe uma data do evento valida!',
                'date_event.date' => 'Informe uma data do evento valida!',
                'date_event.after.*' => 'Informe uma data do evento valida!',
                'date_event.after' => 'Informe uma data do evento valida!',
                'establishment_address_id.required' => 'Selecione o endereço do evento!',
                'price.required' => 'Informe a partir de qual preço do ingresso do evento!',
                'price.regex' => 'Informe um valor válido para o ingresso do evento!',
                'start_time.date_format' => 'Informe um horário de inicio do evento válido!',
                'end_time.date_format' => 'Informe um horário de fim do evento válido!',
                'description.required' => 'Campo [Descrição do Evento] é obrigatório, favor informe!',
                'description.min' => 'Campo [Descrição do Evento] deve conter no mínimo 10 caracteres, favor corrija e tente novamente!',
            ];
        }
    }
