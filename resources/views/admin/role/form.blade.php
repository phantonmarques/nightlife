@extends('adminlte::page')
@section('title', (isset($role->id) ? 'Editar ' : 'Criar ') . 'Função · ')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Funções</a></li>
        <li><a href="#">{{ (isset($role->id) ? 'Editar ' : 'Criar ') }} Função</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($role->id) ? 'Editar Função' : 'Cadastrar nova Função') }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($role, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('name','Nome') }} <span class="span-required">*</span>
                            {{ Form::text('name', (isset($role->id) ? $role->name : ''), ['placeholder' => 'Informe nome da função', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    @if ($errors->has('name'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('name') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('slug','Função') }} <span class="span-required">*</span>
                            {{ Form::text('slug', (isset($role->id) ? $role->slug : ''), ['placeholder' => 'Informe função', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            {{Form::label('permission', 'Permissões')}} <span class="span-required">*</span>
                            {{Form::select('permission', $permissions, isset($role->id) ? $role->permissions : null, array('multiple' => 'multiple', 'name' => 'permission[]', 'class' => 'form-control select2'))}}
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
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        {{ link_to_route('role.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/role.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection