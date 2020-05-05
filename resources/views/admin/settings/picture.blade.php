@extends('adminlte::page')
@section('title', 'Redefinir Senha· ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('settings.changePicture') }}">Foto de Perfil</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Alterar foto de perfil usuário [{{ auth()->user()->name }}]</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::open(array('route' => 'settings.picture', 'method' => 'POST', 'files' => true)) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-2">
                            <div class="custom-file">
                                @if (!empty(auth()->user()->profile_picture_path))
                                    <img src="{{ asset("storage/" .auth()->user()->profile_picture_path) }}" alt="{{ auth()->user()->name }}"
                                         style="max-width: 30vh;">
                                @endif
                                <br><br>
                            </div>

                            <div class="input-file-container">
                                {{ Form::file('profile_picture_path', ['class' => 'input-file']) }}
                                {{ Form::label('profile_picture_path', (!empty(auth()->user()->profile_picture_path) ? 'Mudar ' : '') . 'Foto de Perfil', ['class' => 'input-file-trigger']) }}
                            </div>
                            <p class="file-return"></p>
                        </div>
                    </div>

                    @if ($errors->has('profile_picture_path'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('profile_picture_path') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/settings.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection