@extends('adminlte::page')
@section('title', (isset($rhythm->id) ? 'Editar ' : 'Criar ') . 'Ritmo Musical · ')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Ritmos Musicais</a></li>
        <li><a href="#">{{ (isset($rhythm->id) ? 'Editar ' : 'Criar ') }} Ritmo Musical</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($rhythm->id) ? 'Editar Ritmo Musical' : 'Cadastrar novo Ritmo Musical') }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($rhythm, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::label('name','Nome') }} <span class="span-required">*</span>
                            {{ Form::text('name', (isset($rhythm->id) ? $rhythm->name : ''), ['placeholder' => 'Informe nome do ritmo musical', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->has('name'))
                                <div class="text-red">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>

                    @if ($message = Session::get('error'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $message }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-footer">
                    <div class="col-lg-1" style="margin-left: 83%;">
                        {{ link_to_route('rhythm.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/rhythm.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection