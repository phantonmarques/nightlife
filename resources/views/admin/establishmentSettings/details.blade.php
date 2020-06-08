@extends('adminlte::page')
@section('title', 'Detalhes da Conta ·')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('admin.details') }}">Detalhes da Conta</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalhes da Conta</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Razão Social',
                                'value' => $establishment->company_name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome do estabelecimento',
                                'value' => $establishment->corporate_name
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Inscrição Estadual',
                                'value' => $establishment->state_registration
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo de Licença',
                                'value' => ($establishment->type_license === 'f') ? 'Completa' : 'Básica'
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Situação do Estabelecimento',
                                'value' => ($establishment->status) ? 'Ativo' : 'Inativa'
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $establishment->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => ($establishment->status) ? 'Ultima Atualização' : 'Data Cancelamento',
                                'value' => $establishment->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome',
                                'value' => $establishment->users->name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'CNPJ',
                                'value' => formatCnpjCpf($establishment->users->cpf_cnpj)
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'E-mail',
                                'value' => $establishment->users->email
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo de Usuário',
                                'value' => typeUserDescription($establishment->users->type_user)
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo do Contrato',
                                'value' => ($establishment->type_license === 'f') ? 'Sem quantidade ilimitada para criação de eventos.' : 'Limitado para até 3 eventos agendados.'
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $establishment->users->city->name_visible
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $establishment->users->city->state->name_visible
                            ])
                        </div>
                    </div>

                    @if(sizeof($establishment->establishment_address)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Endereços Cadastrados</h3>
                        </div>

                        @foreach($establishment->establishment_address as $address)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Endereço',
                                        'value' => $address->street_name . " " . $address->building_number . ", " . $address->neighborhood . " - " . $address->city->name_visible
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'CEP',
                                        'value' => formatZipCode($address->zip_code),
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(sizeof($establishment->events)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Eventos Agendados</h3>
                        </div>

                        @foreach($establishment->events as $key => $event)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Nome do Evento',
                                        'value' => $event->name,
                                        'show' => route('event.edit', $event)
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Data da Evento',
                                        'value' => formatDate($event->date_event),
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(sizeof($establishment->establishments_category)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Categoria Cadastrada</h3>
                        </div>

                        @foreach($establishment->establishments_category as $key => $category)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Categoria',
                                        'value' => $category->name
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(sizeof($establishment->establishments_rhythm)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Ritmos Musicais Cadastrados</h3>
                        </div>

                        @foreach($establishment->establishments_rhythm as $key => $rhythm)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Nome Ritmo Musical',
                                        'value' => $rhythm->name
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
