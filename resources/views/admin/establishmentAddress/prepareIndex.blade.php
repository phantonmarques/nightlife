@extends('adminlte::page')
@section('title', 'Estabelecimentos · ')

@section('content_header')
    <h1>Endereços Estabelecimentos</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $establishments) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6-p">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Estabelecimentos Cadastrados</h3>
                </div>
                <div class="box-body">
                    @if (!empty($establishments))
                        {{  Form::open( array('route' => 'establishmentAddress.index', 'method' => 'GET') )  }}

                            {{ Form::select('e', $establishments, 0, ['class' => 'form-control-p']) }}

                            <div class="col-md-2 form-save-p" style="margin-left: 83%;">
                                {{ Form::submit('Buscar', ['class' => 'btn btn-block btn-success']) }}
                            </div>
                        {{ Form::close() }}
                    @else
                        <span class="span-required">{{ 'Nenhum ESTABELECIMENTO cadastrado, faça o cadastro e tente novamente!' }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('vendor/flash-message')

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishmentAddress.css') }}"/>
@endsection
