@extends('adminlte::page')
@section('title', (isset($establishment->id) ? 'Editar ' : 'Criar ') . ' Estabelecimento · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('establishment.index') }}">Estabelecimentos</a></li>
        <li>
            <a href="{{ (isset($establishment->id) ? route('establishment.edit', $establishment) : route('establishment.create')) }}">{{ (isset($establishment->id) ? 'Editar ' : 'Criar ') }}
                Estabelecimento
            </a>
        </li>
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

                    <br>

                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('state_registration','Inscrição Estadual ') }} <span
                                    class="span-required">*</span>
                            {{ Form::text('state_registration' , (isset($establishment->id) ? $establishment->state_registration : ''), ['placeholder' => 'Informe a inscrição estadual', 'class' => 'form-control required', 'onkeypress' => 'return onlyNumbers(event)']) }}
                        </div>
                    </div>

                    @if ($errors->has('state_registration'))
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('state_registration') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('type_license','Tipo Conta ') }} <span class="span-required">*</span>
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('category','Categoria Estabelecimento ') }} <span
                                    class="span-required">*</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    &nbsp;{{ Form::radio('type_license', 'b', (isset($establishment->type_license) && $establishment->type_license === 'b') ? true : false, [ 'id' => 'basicAccount']) }}
                                </span>
                                {{ Form::label('basicAccount','Plano Basico', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    {{ Form::radio('type_license', 'f', (isset($establishment->type_license) && $establishment->type_license === 'f') ? true : false, [  'id' => 'fullAccount' ]) }}
                                </span>
                                {{ Form::label('fullAccount','Plano Completo', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{Form::select('category', $categorys, isset($establishment->establishments_category) ? $establishment->establishments_category : null, array('class' => 'form-control'))}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @if ($errors->has('type_license'))
                                <div class="text-red">{{ $errors->first('type_license') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($errors->has('category'))
                                <div class="text-red">{{ $errors->first('category') }}</div>
                            @endif
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('rhythm','Ritmos Musicais ') }} <span class="span-required">*</span>
                            {{Form::select('rhythm', $rhythms, isset($establishment->establishments_rhythm) ? $establishment->establishments_rhythm : null, array('multiple' => 'multiple', 'name' => 'rhythm[]', 'class' => 'form-control select2'))}}
                        </div>
                    </div>

                    @if ($errors->has('rhythm'))
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('rhythm') }}</div>
                            </div>
                        </div>
                    @endif


                    @if (isset($establishment->status) && $establishment->status === 0)
                        <br>

                        <div class="row">
                            <div class="col-md-5">
                                {{ Form::label('status','Status Estabelecimento ') }} <span
                                        class="span-required">*</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1">
                                {{ Form::select('status', [1 => 'Ativo', 0 => 'Inativo'], (isset($establishment->status) && $establishment->status) ? 1 : 0, ['class' => 'form-control']) }}
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
                                    @if(sizeof($users) === 0 && !isset($establishment->users))
                                        <span class="span-required">{{ 'Nenhum usuário do tipo ESTABELECIMENTO cadastrado, faça o cadastro e tente novamente!' }}</span>
                                    @else
                                        <select class="form-control" name="user_id" id="user_id"
                                                onchange="javascript: selectUser(this.value)">
                                            <option value="">---- SELECIONE USUÁRIO ----</option>
                                            @if (isset($establishment->users))
                                                <option value="{{$establishment->users->id}}"
                                                        selected>{{$establishment->users->name}}</option>
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
                    @if(sizeof($users) > 0 || isset($establishment->users))
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
                                            @if (isset($establishment->users))
                                                <option value="{{$establishment->users->id}}"
                                                        selected>{{$establishment->users->email}}</option>
                                            @endif
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->email}}</option>
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
                                            @if (isset($establishment->users))
                                                <option value="{{$establishment->users->id}}"
                                                        selected>{{ formatCnpjCpf($establishment->users->cpf_cnpj) }}</option>
                                            @endif
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{ formatCnpjCpf($user->cpf_cnpj) }}</option>
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

                @if ($message = Session::get('error'))
                    <br>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="text-red">{{ $message }}</div>
                        </div>
                    </div>
                @endif

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        {{ link_to_route('establishment.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
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

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection
