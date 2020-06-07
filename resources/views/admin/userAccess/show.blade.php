@extends('adminlte::page')
@section('title', 'Log Acesso · Visualização')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('logs.index') }}">Logs Usuários</a></li>
        <li><a href="{{ route('logs.show', $log) }}"> Visualizar log usuário</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Log de Acesso</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $log->id
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome Usuário',
                                'value' => $log->users->name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Estabelecimento Conectado',
                                'value' => $log->establishment->corporate_name
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Classe Acessada',
                                'value' => $log->class
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Área Acessada',
                                'value' => $log->description
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data e Hora Acesso',
                                'value' => formatDateHour($log->data_access)
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @include('adminlte::form.input.static', [
                                'label' => 'JSON',
                                'value' => !empty($log->content) ? json_encode($log->content) : '-'
                            ])
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('logs.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection