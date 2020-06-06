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
                            @if(isset($called->id))
                                {{ Form::text('subject', $called->subject, ['placeholder' => 'Informe assunto do chamado', 'class' => 'form-control required', 'disabled' => 'disabled']) }}
                            @else
                                {{ Form::text('subject', '', ['placeholder' => 'Informe assunto do chamado', 'class' => 'form-control required']) }}
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            @if ($errors->has('subject'))
                                <div class="text-red">{{ $errors->first('subject') }}</div>
                            @endif
                        </div>
                    </div>

                    @if (isset($called->id))
                        <div class="row top-separate">
                            <div class="col-md-10">
                                @can('establishment-employee')
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered table-hover dataTable table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Descrição</th>
                                                    <th>Situação</th>
                                                    <th>Usuário Interação</th>
                                                </tr>
                                            </thead>
                                            @foreach($called->called_interaction as $interaction)
                                                @if ($interaction->visible)
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                {!! $interaction->description !!}
                                                            </td>
                                                            <td>
                                                                {{ formatSituation($interaction->situation) }}
                                                            </td>
                                                            <td>
                                                                {{ $interaction->user->name }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered table-hover dataTable table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Interação</th>
                                                    <th>Descrição</th>
                                                    <th>Situação</th>
                                                    <th>Data Último Atendimento</th>
                                                    <th>Tempo Último Atendimento</th>
                                                    <th>Estabelecimento</th>
                                                    <th>Usuário Interação</th>
                                                    <th>Visível Cliente</th>
                                                </tr>
                                            </thead>
                                            @foreach($called->called_interaction as $key => $interaction)
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {{ '#' . ($key+1) }}
                                                        </td>
                                                        <td>
                                                            {!! $interaction->description !!}
                                                        </td>
                                                        <td>
                                                            {{ formatSituation($interaction->situation) }}
                                                        </td>
                                                        <td>
                                                            {{ formatDate($interaction->date_service) }}
                                                        </td>
                                                        <td>
                                                            {{ $interaction->time_service ? formatHour($interaction->time_service): '00:00' }}
                                                        </td>
                                                        <td>
                                                            {{ $interaction->establishment->corporate_name }}
                                                        </td>
                                                        <td>
                                                            {{ $interaction->user->name . ' [' . $interaction->user->id . ']' }}
                                                        </td>
                                                        <td>
                                                            {{ $interaction->visible ? 'Sim' : 'Não' }}
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            @endforeach
                                        </table>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    @endif

                    <div class="row top-separate">
                        <div class="col-md-10">
                            {{ Form::label('description', (isset($called->id) ? 'Descrição da Interação' : 'Descrição do Chamado' )) }}
                            <span class="span-required">*</span>
                            {!! Form::textarea('description', '', ['class'=>'form-control', 'id' => 'description']) !!}
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
                                {{ Form::label('situation','Situação do chamado') }} <span
                                        class="span-required">*</span>
                                {{ Form::select('situation', $situations, (isset($called->id) ? $called->called_interaction()->orderBy('id', 'DESC')->first()->situation : 'analyze'), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('visibleUser','Visível para Usuário') }}
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                {{ Form::checkbox('visibleUser', 1, (isset($called->id)) ? $called->called_interaction()->orderBy('id', 'DESC')->first()->visible : false, ['id' => 'visibleUser', 'onClick' => 'visibleInput(this.checked)']) }}
                                            </span>
                                    {{ Form::label('visibleUser', 'Sim', ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                @if ($errors->has('situation'))
                                    <div class="text-red">{{ $errors->first('situation') }}</div>
                                @endif
                            </div>
                            <div class="col-md-3">
                                @if ($errors->has('visible'))
                                    <div class="text-red">{{ $errors->first('visible') }}</div>
                                @endif
                            </div>
                        </div>


                        <div class="row top-separate">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('time_service','Tempo atendimento') }} <span
                                            class="span-required">*</span>

                                    <div class="input-group">
                                        {{ Form::time('time_service', (isset($event->id) ? formatHour($called->called_interaction->first()->time_service) : '')) }}
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