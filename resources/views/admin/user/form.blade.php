@extends('adminlte::page')
@section('title', (isset($user->id) ? 'Editar ' : 'Criar ') . 'Usuário · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('user.index') }}">Usuários</a></li>
        <li>
            <a href="{{ (isset($user->id) ? route('user.edit', $user) : route('user.create')) }}">{{ (isset($user->id) ? 'Editar ' : 'Criar ') }}
                Usuário
            </a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($user->id) ? 'Editar Usuário' : 'Cadastrar novo usuário') }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($user, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::label('name','Nome') }} <span class="span-required">*</span>
                            {{ Form::text('name', (isset($user->id) ? $user->name : ''), ['placeholder' => 'Informe nome do usuário', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->has('name'))
                                <div class="text-red">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('email','E-mail') }} <span class="span-required">*</span>
                            {{ Form::email('email', (isset($user->id) ? $user->email : ''), ['placeholder' => 'Informe e-mail', 'class' => 'form-control required']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('cpf_cnpj','CPF/CNPJ') }} <span class="span-required">*</span>
                            {{ Form::text('cpf_cnpj', (isset($user->id) ? $user->cpf_cnpj : ''), ['placeholder' => 'Informe cpf ou cnpj', 'class' => 'form-control required', 'onkeypress' => 'return onlyNumbers(event)']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @if ($errors->has('email'))
                                <div class="text-red">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($errors->has('cpf_cnpj'))
                                <div class="text-red">{{ $errors->first('cpf_cnpj') }}</div>
                            @endif
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::label('user_role','Função Usuário') }} <span class="span-required"></span>
                            {{ Form::select('user_role', $roles, (isset($user->id) ? $user->roles()->pluck('id') : ''), ['class' => 'form-control']) }}
                        </div>
                        <div class="col-lg-6">
                            {{ Form::label('type_user','Tipo Usuário') }} <span class="span-required">*</span>
                            {{ Form::select('type_user', $typeUsers, (isset($user->id) ? $user->type_user : ''), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('password','Nova Senha') }} @if (!isset($user->id))<span class="span-required">*</span> @endif
                            <div class="input-group">
                                {{ Form::password('password', ['placeholder' => 'Informe senha', 'class' => 'form-control required']) }}
                                <span class="input-group-addon">
                                    <i class="fas fa-eye" id="viewPassword"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('confirm_password','Confirme nova Senha') }} @if (!isset($user->id))<span class="span-required">*</span> @endif
                            <div class="input-group">
                                {{ Form::password('confirm_password', ['placeholder' => 'Confirme a senha', 'class' => 'form-control required']) }}
                                <span class="input-group-addon">
                                    <i class="fas fa-eye" id="viewPasswordConfirm"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->has('password'))
                                <div class="text-red">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <br><br>


                    {{ Form::label('zip_code', 'Busca Cidade e Estado pelo CEP') }}
                    <div class="row">
                        <div class="col-lg-3">
                            {{ Form::text('zip_code' , '', ['placeholder' => 'Informe cep para buscar cidade e estado.', 'class' => 'form-control cep', 'onkeypress' => 'return onlyNumbers(event)']) }}
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-info" onclick="searchLocation()">Buscar
                            </button>
                        </div>
                    </div>
                    <br>


                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::label('state_id','Estado') }} <span class="span-required">*</span>
                            {{ Form::select('state_id', $states, (isset($user->id) ? $user->city->state->id : ''), ['class' => 'form-control', 'id' => 'state_id', 'onchange' => 'searchCity()']) }}
                        </div>
                        <div class="col-lg-6">
                            {{ Form::label('city_id','Cidade') }} <span class="span-required">*</span>
                            {{ Form::select('city_id', array('' => 'Selecione'), 0, ['class' => 'form-control', 'id' => 'city_id']) }}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            @if ($errors->has('state_id'))
                                <div class="text-red">{{ $errors->first('state_id') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            @if ($errors->has('city_id'))
                                <div class="text-red">{{ $errors->first('city_id') }}</div>
                            @endif
                        </div>
                    </div>

                    {{ Form::hidden('city', (isset($user->id) ? $user->city_id : ''), ['id' => 'city']) }}
                    {{ Form::hidden('email_verified_at', date('Y-m-d H:i:s')) }}
                    {{ Form::hidden('uc', url('control/citys') . "/", ['id' => 'url_city']) }}
                    {{ Form::hidden('us', url('control/state') . "/", ['id' => 'url_state']) }}

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
                        {{ link_to_route('user.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/user.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection