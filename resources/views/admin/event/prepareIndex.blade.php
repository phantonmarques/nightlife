@extends('adminlte::page')
@section('title', 'Eventos · ')

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $establishments) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6-p">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Eventos Estabelecimento</h3>
                </div>
                <div class="box-body">
                    @if (!empty($establishments))
                        {{  Form::open( array('route' => 'event.index', 'method' => 'GET') )  }}

                        {{ Form::label('e', 'Estabelecimentos Cadastrados', ['class' => 'form-control-l']) }}
                        {{ Form::select('e', $establishments, 0, ['class' => 'form-control-p']) }}

                        <div class="col-lg-3 pull-right form-save-p">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/prepare.css') }}"/>
@endsection
