@extends('adminlte::page')
@section('title', 'Foto Perfil · ')

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
                </div>

                {{ Form::open(array('route' => 'settings.picture', 'method' => 'POST', 'files' => true)) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="pull-center">
                            <div class="custom-file">
                                @if (!empty(auth()->user()->profile_picture_path))
                                    <img src="{{ asset("storage/" . auth()->user()->profile_picture_path) }}" alt="{{ auth()->user()->name }}"
                                         class="img_settings">
                                @endif
                                <br><br>
                            </div>
                        </div>
                    </div>
                    @if (!empty(auth()->user()->profile_picture_path))
                        <div class="row">
                            <div class="pull-center">
                                <div class="input-file-container">
                                    <a class="btn btn-block btn-warning btn-lg font-button" onclick="removePicture()">Remover Foto</a>
                                    {!! Form::hidden('urlRemove', route('settings.removePicture')) !!}
                                </div>
                            </div>
                            <p class="file-return pull-center"></p>
                        </div>
                    @endif
                    <div class="row">
                        <div class="pull-center top-separate">
                            <div class="input-file-container">
                                {{ Form::file('profile_picture_path', ['class' => 'input-file']) }}
                                {{ Form::label('profile_picture_path', (!empty(auth()->user()->profile_picture_path) ? 'Mudar ' : '') . 'Foto de Perfil', ['class' => 'input-file-trigger']) }}
                            </div>
                        </div>
                        <p class="file-return pull-center"></p>
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
    <script type="text/javascript">
        function removePicture() {
            $.ajax({
                url: '{{ route('settings.removePicture') }}',
                headers: {
                    'X-CSRF-Token': document.getElementsByTagName('meta')[2].getAttribute('content')
                },
                type: 'DELETE',
                success: function(data) {
                    if (data.success){
                        swal({
                            title: data.message,
                            icon: 'success',
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 1500);
                    } else {
                        swal({
                            title: data.message,
                            icon: 'error',
                        });
                    }
                },
                error: function() {
                    swal({
                        title: 'Desconhecido, favor recarrega a página e tente novamente!',
                        icon: 'error',
                    });
                },
            });
        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/settings.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection