@extends('adminlte::page')
@section('title', (isset($called->id) ? 'Interagir no ' : 'Criar ') . 'Chamado · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('called.index') }}">Chamados</a></li>
        <li>
            <a href="{{ (isset($called->id) ? route('called.edit', $called) : route('called.create')) }}">{{ (isset($called->id) ? 'Interagir no  ' : 'Criar ') }}
                Chamado
            </a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($called->id) ? 'Interagir no Chamado' : 'Cadastrar novo Chamado') }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($called, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('subject','Assunto') }} <span class="span-required">*</span>
                            @can('establishment-employee')
                                {{ Form::text('subject', (isset($called->id) ? $called->name : ''), ['placeholder' => 'Informe assunto do chamado', 'class' => 'form-control required']) }}
                            @else
                                {{ Form::text('subject', (isset($called->id) ? $called->name : ''), ['placeholder' => 'Informe assunto do chamado', 'class' => 'form-control required', 'disabled' => 'disabled']) }}
                            @endcan
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            @if ($errors->has('subject'))
                                <div class="text-red">{{ $errors->first('subject') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row top-separate">
                        <div class="col-md-10">
                            {{ Form::label('description','Descrição Chamado') }} <span class="span-required">*</span>
                            {!! Form::textarea('description', (isset($called->id) ? $called->called_interaction->description : ''), ['class'=>'form-control', 'id' => 'description']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            @if ($errors->has('description'))
                                <div class="text-red">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>

                    @can('manage-called')

                        <div class="row top-separate">
                            <div class="col-md-3">
                                {{ Form::label('situation','Situação do chamado') }} <span class="span-required">*</span>
                                {{ Form::select('situation', $situations, (isset($called->id) ? $called->called_interaction->situation : 'analyze'), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-3">
                                Visivel cliente
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                @if ($errors->has('situation'))
                                    <div class="text-red">{{ $errors->first('situation') }}</div>
                                @endif
                            </div>
                            <div class="col-md-3">
                                @if ($errors->has('seilavisible'))
                                    <div class="text-red">{{ $errors->first('seilavisible') }}</div>
                                @endif
                            </div>
                        </div>


                        <div class="row top-separate">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('time_service','Tempo atendimento') }} <span
                                            class="span-required">*</span>

                                    <div class="input-group">
                                        {{ Form::time('time_service', (isset($event->id) ? formatHour($called->called_interaction->time_service) : '')) }}
                                        <i class="far fa-clock time_style"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                @if ($errors->has('time_service'))
                                    <div class="text-red">{{ $errors->first('time_service') }}</div>
                                @endif
                            </div>
                        </div>

                    @endcan

                    {{ Form::hidden('visible', true, ['id' => 'visible']) }}
                    {{ Form::hidden('date_service', date('Y-m-d')) }}
                    {{ Form::hidden('status', 1, ['id' => 'status']) }}


{{--                    $table->unsignedInteger('establishment_id');--}}
{{--                    $table->unsignedInteger('user_id');--}}
{{--                    $table->string('subject');--}}
{{--                    $table->boolean('status')->default(1);--}}

{{--                    $table->text('description');--}}
{{--                    $table->string('situation');--}}
{{--                    $table->date('date_service')->nullable();--}}
{{--                    $table->time('time_service')->nullable();--}}
{{--                    $table->unsignedInteger('called_id');--}}
{{--                    $table->unsignedInteger('establishment_id');--}}
{{--                    $table->unsignedInteger('user_id');--}}
                </div>

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        {{ link_to_route('called.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/Global/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/Global/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/called.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/jquery.datetimepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/jquery-ui.css') }}"/>
@endsection