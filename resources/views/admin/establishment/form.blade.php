@extends('adminlte::page')
@section('title', 'Criar Estabelecimento · ')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Estabelecimento</a></li>
        <li><a href="#">Criar Estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ 'Cadastrar novo estabelecimento' }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($establishment, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('corporate_name','Razão Social ') }} <span class="span-required">*</span>
                            {{ Form::text('corporate_name' , (isset($establishment->id) ? $establishment->corporate_name : ''), ['placeholder' => 'Informe a razão social', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    @if ($errors->has('corporate_name'))
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('corporate_name') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('state_registration','Inscrição Estadual ') }} <span
                                    class="span-required">*</span>
                            {{ Form::text('state_registration' , (isset($establishment->id) ? $establishment->state_registration : ''), ['placeholder' => 'Informe a inscrição estadual', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    @if ($errors->has('state_registration'))
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('state_registration') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-5">
                            {{ Form::label('type_license','Tipo Conta ') }} <span class="span-required">*</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    &nbsp;{{ Form::radio('type_license', 'b', (isset($establishment->type_license) && $establishment->type_license === 'b') ? true : false, [ 'id' => 'basicAccount']) }}
                                </span>
                                {{ Form::label('basicAccount','Básica', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    {{ Form::radio('type_license', 'f', (isset($establishment->type_license) && $establishment->type_license === 'f') ? true : false, [  'id' => 'fullAccount' ]) }}
                                </span>
                                {{ Form::label('fullAccount','Completa', ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('type_license'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('type_license') }}</div>
                            </div>
                        </div>
                    @endif

                    @if (isset($establishment->status) && $establishment->status === 0)
                            <div class="row">
                                <div class="col-md-5">
                                    {{ Form::label('status','Status Estabelecimento ') }} <span
                                            class="span-required">*</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    {{ Form::select('status', [1 => 'Ativo', 0 => 'Inativo'], (isset($establishment->status) && $establishment->status === 1) ? 1 : 0, ['class' => 'form-control']) }}
                                </div>
                            </div>
                    @else
                        {{ Form::hidden('status', 1, array('id' => 'status')) }}
                    @endif


                    @if ($errors->has('status'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('status') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="lead">Dados Usuário a Vincular</h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    {{ Form::label('Nome Usuário') }} <span class="span-required">*</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    @if(sizeof($users) === 0 && !isset($userOld))
                                        <span class="span-required">{{ 'Nenhum usuário do tipo ESTABELECIMENTO cadastrado, faça o cadastro e tente novamente!' }}</span>
                                    @else
                                        <select class="form-control" name="user_id" id="user_id"
                                                onchange="javascript: selectUser(this.value)">
                                            <option value="">---- SELECIONE USUÁRIO ----</option>
                                            @if (isset($userOld))
                                                <option value="{{$userOld->id}}" selected>{{$userOld->name}}</option>
                                            @endif
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(sizeof($users) > 0 || isset($userOld))
                        <div class="row" id="divEmail" style="display:none">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        {{ Form::label('E-mail Usuário') }} <span class="span-required">*</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="userEmail" id="userEmail" disabled>
                                            @if (isset($userOld))
                                                <option value="{{$userOld->id}}" selected>{{$userOld->email}}</option>
                                            @endif
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->email}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divLogin" style="display:none">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        {{ Form::label('Login') }} <span class="span-required">*</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="userLogin" id="userLogin" disabled>
                                            @if (isset($userOld))
                                                <option value="{{$userOld->id}}" selected>{{$userOld->login}}</option>
                                            @endif
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->login}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row" id="divCnpj" style="display:none">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        {{ Form::label('CNPJ') }} <span class="span-required">*</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="userCNPJ" id="userCNPJ" disabled>
                                            @if (isset($userOld))
                                                <option value="{{$userOld->id}}" selected>{{$userOld->cpf_cnpj}}</option>
                                            @endif
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->cpf_cnpj}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                    @if ($errors->has('status'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('status') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-footer">
                    <div class="col-lg-1" style="margin-left: 83%;">
                        {{ link_to_route('establishment.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
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
    <script type="text/javascript" src="{{ asset('assets/admin/js/establishment.js') }}"></script>
@endsection
