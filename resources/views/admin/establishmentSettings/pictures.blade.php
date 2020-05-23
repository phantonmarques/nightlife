@extends('adminlte::page')
@section('title', 'Fotos Estabelecimento · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('admin.pictures') }}">Fotos Estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Alterar fotos do estabelecimento [{{ $establishment->corporate_name }}]</h3>
                </div>

                {!! csrf_field() !!}
                <div class="content_glide">
                    @if ($establishment->establishments_photos()->count() > 0)
                        <div id="Glide" class="glide">
                            @if ($establishment->establishments_photos()->count() > 1)
                                <!-- ARROWS -->
                                <div class="glide__arrows">
                                    <button class="glide__arrow prev" data-glide-dir="<">prev</button>
                                    <button class="glide__arrow next" data-glide-dir=">">next</button>
                                </div>
                            @endif
                            <!-- CAROUSEL -->
                            <div class="glide__wrapper">
                                <ul class="glide__track">
                                    @foreach ($establishment->establishments_photos as $photo)
                                        <li class="glide__slide">
                                            <img src="{{ asset('storage/' . $photo->img_path) }}"
                                                class="content_glide" alt="{{ $establishment->corporate_name }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- CAROUSEL DOTS -->
                            <div class="glide__bullets"></div>
                        </div>
                    @endif                      
                </div>

                <div class="box-body pull-center">
                        <div class="col-xs-10">
                            {{ Form::open(['route' => 'admin.updatePictures', 'method' => 'POST', 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'dZone']) }}
        
                            {{ Form::close() }}    
                        </div>
                </div>

                {{ Form::hidden('action', ($establishment->establishments_photos()->count() > 0) ? 'update' : 'new', ['id' => 'action']) }}

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
    <script type="text/javascript" src="{{ asset('assets/Global/js/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/settings.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/glidejs@2/dist/glide.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function () {
            $("#Glide").glide({
                type: "carousel",
                autoplay: "5000"
            });

            let message = '';

            if ($('#action').val() === 'new')
                message = 'para inserir ao perfil do estabelecimento!';
            else
                message = 'para atualizar no estabelecimento!';

            let uploadFile = {};

            $("#dZone").dropzone({ 
                url: '{{ route('admin.updatePictures') }}',
                dictDefaultMessage: 'Clique ou arraste fotos ' + message,
                dictInvalidFileType: 'É aceito apenas imagens para upload!',
                dictFileTooBig: 'Arquivo muito pesado, não aceita arquivos com mais de 3mb!',
                dictMaxFilesExceeded: 'É aceito apenas 10 imagens para o estabelecimento!',
                dictRemoveFile: 'Remover',
                dictCancelUpload: 'Cancelar',
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                maxFilesize: 1,
                maxFiles: 10, 
                resizeQuality: 10,
                parallelUploads: 1,
                success: function(file, response){
                    uploadFile[file.name] = response.path;
                },
                error: function(file, response) {
                    swal({
                        title: response.message,
                        icon: 'error',
                    });
                },
                removedfile: function (file) {
                    $.ajax({
                        url: '{{ route('admin.removePicture') }}',
                        headers: {
                            'X-CSRF-Token': document.getElementsByTagName('meta')[2].getAttribute('content')
                        },
                        type: 'DELETE',
                        data: {
                            path: uploadFile[file.name]
                        },
                        success: function(data) {
                            if (data.success)
                                swal({
                                    title: data.message,
                                    icon: 'success',
                                });
                            else
                                swal({
                                    title: data.message,
                                    icon: 'error',
                                });
                        },
                        error: function() {
                            swal({
                                title: 'Desconhecido, favor recarrega a página e tente novamente!',
                                icon: 'error',
                            });
                        },
                    });
                    file.previewElement.remove();
                }
             });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/settings.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/dropzone.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/Glide.js/2.1.0/css/glide.core.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/Glide.js/2.1.0/css/glide.theme.min.css"/>
@endsection