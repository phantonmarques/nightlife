@extends('adminlte::page')
@section('title', (isset($news->id) ? 'Editar ' : 'Criar ') . 'Notícia · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('news.index') }}">Notícias</a></li>
        <li>
            <a href="{{ (isset($news->id) ? route('news.edit', $news) : route('news.create')) }}">{{ (isset($news->id) ? 'Editar ' : 'Criar ') }}
                Notícia
            </a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($news->id) ? 'Editar' : 'Cadastrar nova') }} Notícia</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($news, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('title','Titulo') }} <span class="span-required">*</span>
                            {{ Form::text('title', (isset($news->id) ? $news->title : ''), ['placeholder' => 'Informe título da notícia', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    @if ($errors->has('title'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('title') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('description', 'Descrição Notícia') }} <span class="span-required">*</span>
                            {{ Form::textarea('description', (isset($news->id) ? $news->description : ''), ['class'=>'form-control', 'id' => 'description', 'placeholder' => 'Descreva a notícia que será anunciada']) }}
                        </div>
                    </div>

                    @if ($errors->has('description'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('description') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row">
                        <div class="col-lg-2">
                            {{ Form::label('Notícia Importante') }}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    {{ Form::checkbox('important', 1 , ($news->important) ? 'checked' : false, ['id' => 'important']) }}
                                </span>
                                {{ Form::label('important', 'Sim', ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('important'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('important') }}</div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        {{ link_to_route('news.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/news.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection