@extends('adminlte::page')
@section('title', 'Estabelecimento · Visualização')

@section('content_header')
    <h1>Estabelecimento</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $establishment) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do estabelecimento</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Razão Social',
                                'value' => $establishment->corporate_name
                            ])
                        </div>
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
                                'value' => ($establishment->status === 1) ? 'Ativo' : 'Inativa'
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
                                'label' => 'Ultima Atualização',
                                'value' => $establishment->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h4 class="lead">Usuário Vínculado</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome',
                                'value' => $userEstablishment->name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'CNPJ',
                                'value' => $userEstablishment->cpf_cnpj
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'E-mail',
                                'value' => $userEstablishment->email
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Login',
                                'value' => $userEstablishment->login
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo de Usuário',
                                'value' => $typeUser
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $cityUser->name_visible
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $stateUser->name_visible
                            ])
                        </div>
                    </div>


                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('establishment.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('establishment.edit', $title = 'Editar', '', ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishment.css') }}"/>
@endsection
