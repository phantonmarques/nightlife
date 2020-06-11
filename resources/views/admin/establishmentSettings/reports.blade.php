@extends('adminlte::page')
@section('title', 'Relatórios Estabelecimento · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('admin.reports') }}">Relatórios Estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Olá, Bem vindo aos relatórios [{{ $establishment->corporate_name }}]</h3>
                </div>

                {{ Form::open(array('route' => 'admin.generateReport', 'method' => 'GET')) }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('typeReport', 'Tipo de relatório') }}
                                <div class="input-group">
                                    {{ Form::select('typeReport', [1 => 'Notas e comentários - PDF', 2 => 'Notas e comentários - XLS'], ['id' => 'typeReport']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            {{ Form::submit('Gerar', ['class' => 'btn btn-sm btn-primary btn-flat']) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}


            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection
