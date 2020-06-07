@extends('adminlte::page')
@section('title', 'Endereço Estabelecimento · Visualização')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('establishmentAddress.index') }}">Endereços Estabelecimentos</a></li>
        <li><a href="{{ route('establishmentAddress.show', $establishmentAddress) }}"> Visualizar endereços</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Endereço do Estabelecimento</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Endereço',
                                'value' => $establishmentAddress->street_name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Número',
                                'value' => $establishmentAddress->building_number
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Complemento',
                                'value' => $establishmentAddress->complement
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cep',
                                'value' => $establishmentAddress->zip_code
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Bairro',
                                'value' => $establishmentAddress->neighborhood
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $establishmentAddress->city->name_visible
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $establishmentAddress->city->state->name_visible
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $establishmentAddress->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $establishmentAddress->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    @if(sizeof($establishmentAddress->establishments_phone)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Telefones</h3>
                        </div>

                        @foreach($establishmentAddress->establishments_phone as $key => $phone)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => ($phone->main) ? 'Nome Contato Principal' : 'Nome Contato ' . $key,
                                        'value' => $phone->name
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => ($phone->main) ? 'Telefone Principal' : 'Telefone ' . $key,
                                        'value' => $phone->phone
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Número tem Whatsapp',
                                        'value' => ($phone->whatsapp) ? 'Sim' : 'Não'
                                    ])
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Data de Criação',
                                        'value' => $phone->created_at->format('d/m/Y - H:i')
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Ultima Atualização',
                                        'value' => $phone->updated_at->format('d/m/Y - H:i')
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('establishmentAddress.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('establishmentAddress.edit', $title = 'Editar', $establishmentAddress, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishmentAddress.css') }}"/>
@endsection
