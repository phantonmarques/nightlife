@extends('adminlte::page')
@section('title', 'Redefinir Senha· ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('settings.changePassword') }}">Redefinir Senha</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Redefinir senha usuário [{{ auth()->user()->name }}]</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::open(array('route' => 'settings.reset', 'method' => 'POST', 'onsubmit' => 'return validateFormPasswordReset(this)')) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('recent_password','Informe senha recente para seguir com a alteração!') }}
                            <span class="span-required">*</span>
                            <div class="input-group">
                                {{ Form::password('recent_password', ['placeholder' => 'Informe senha', 'class' => 'form-control required']) }}
                                <span class="input-group-addon">
                                    <i class="fas fa-eye" id="viewPasswordRecent"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="text-red" id="alertPassword" style="display: none">Senha inválida, tente novamente!</div>
                        </div>
                    </div>

                    @if ($errors->has('recent_password'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('recent_password') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row" id="divPassword" style="display: none;">
                        <div class="col-md-10">
                            {{ Form::label('password','Informe nova senha') }}
                            <span class="span-required">*</span>
                            <div class="input-group">
                                {{ Form::password('password', ['placeholder' => 'Informe senha', 'class' => 'form-control required']) }}
                                <span class="input-group-addon">
                                    <i class="fas fa-eye" id="viewPassword"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('password'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('password') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row" id="divPasswordConfirm" style="display: none;">
                        <div class="col-md-10">
                            {{ Form::label('confirm_password','Confirme nova senha') }}
                            <span class="span-required">*</span>
                            <div class="input-group">
                                {{ Form::password('confirm_password', ['placeholder' => 'Informe senha', 'class' => 'form-control required']) }}
                                <span class="input-group-addon">
                                    <i class="fas fa-eye" id="viewPasswordConfirm"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('confirm_password'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('confirm_password') }}</div>
                            </div>
                        </div>
                    @endif

                    {{ Form::hidden('uv', url('control/valid'), ['id' => 'url_valid']) }}

                </div>

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success', 'id' => 'bt_salvar', 'style' => 'display:none;']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/settings.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection