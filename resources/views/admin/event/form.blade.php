@extends('adminlte::page')
@section('title', (isset($event->id) ? 'Editar ' : 'Criar ') . 'Evento · ')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Eventos</a></li>
        <li><a href="#">{{ (isset($event->id) ? 'Editar ' : 'Criar ') }} Evento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($event->id) ? 'Editar Evento' : 'Cadastrar nova Evento') }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($event, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('name','Nome') }} <span class="span-required">*</span>
                            {{ Form::text('name', (isset($event->id) ? $event->name : ''), ['placeholder' => 'Informe nome do evento', 'class' => 'form-control required']) }}
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

                    $table->string('name');
                    $table->date('date_event');
                    $table->double('price', 10, 2);
                    $table->string('cover_path')->unique();
                    $table->longText('description');
                    $table->boolean('status');
                    $table->unsignedInteger('establishment_address_id');
                    $table->unsignedInteger('establishment_id');
                    $table->timestamps();

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                @if (auth()->user()->image != null)
                                    <img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}" style="max-width: 50px;">
                                @endif

                                <label for="image">Imagem: </label>
                                <input type="file" name="image" class="form-control">
                            </div>
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
                        {{ link_to_route('event.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
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
    <script type="text/javascript" src="{{ asset('assets/admin/js/event.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection