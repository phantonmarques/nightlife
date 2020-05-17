@extends('adminlte::page')
@section('title', 'Fotos Estabelecimento · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('admin.changePictures') }}">Fotos Estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Alterar fotos do estabelecimento [{{ $establishment->corporate_name }}]</h3>
                </div>

                {{ Form::open(array('route' => 'admin.pictures', 'method' => 'POST', 'files' => true)) }}
                {!! csrf_field() !!}
                <div class="box-body content_glide">
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


                    

{{--                    <div class="row">--}}
{{--                        <div class="col-lg-2">--}}
{{--                            <div class="input-file-container">--}}
{{--                                {{ Form::file('img_path[]', ['class' => 'input-file', 'multiple' => true]) }}--}}
{{--                                {{ Form::label('img_path', (!empty(auth()->user()->profile_picture_path) ? 'Mudar ' : '') . 'Foto do Estabelecimento', ['class' => 'input-file-trigger']) }}--}}
{{--                            </div>--}}
{{--                            <p class="file-return"></p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-md-4">&nbsp;</div>--}}
                    {{--                        <div class="col-md-2">--}}
                    {{--                            <div class="custom-file">--}}
                    {{--                                @if (!empty(auth()->user()->profile_picture_path))--}}
                    {{--                                    <img src="{{ asset("storage/" .auth()->user()->profile_picture_path) }}" alt="{{ auth()->user()->name }}"--}}
                    {{--                                         style="max-width: 30vh;">--}}
                    {{--                                @endif--}}
                    {{--                                <br><br>--}}
                    {{--                            </div>--}}

                    {{--                            <div class="input-file-container">--}}
                    {{--                                {{ Form::file('profile_picture_path', ['class' => 'input-file']) }}--}}
                    {{--                                {{ Form::label('profile_picture_path', (!empty(auth()->user()->profile_picture_path) ? 'Mudar ' : '') . 'Foto de Perfil', ['class' => 'input-file-trigger']) }}--}}
                    {{--                            </div>--}}
                    {{--                            <p class="file-return"></p>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/glidejs@2/dist/glide.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#Glide").glide({
                type: "carousel",
                autoplay: "5000"
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/settings.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/Glide.js/2.1.0/css/glide.core.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/Glide.js/2.1.0/css/glide.theme.min.css"/>
@endsection