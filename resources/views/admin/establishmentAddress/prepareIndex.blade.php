@extends('adminlte::page')
@section('title', 'Estabelecimentos · ')

@section('content_header')
    <h1>Endereços Estabelecimentos</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), 'Unknow') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6-p">
                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estabelecimentos Cadastrados</h3>
                    </div>
                    <div class="box-body">
                        {{ Form::select('status', [1 => 'Ativo', 0 => 'Inativo'], (isset($establishment->status) && $establishment->status === 1) ? 1 : 0, ['class' => 'form-control-p']) }}

                        <div class="col-md-2 form-save-p" style="margin-left: 83%;">
                            {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishmentAdress.css') }}"/>
@endsection
