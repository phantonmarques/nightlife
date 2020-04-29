@extends('adminlte::page')
@section('title', 'Dashboard · ')

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), 'Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        Teste
                    </div>


            </div>
        </div>
    </div>

    @include('vendor/flash-message')
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/Global/js/general.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection