@extends('adminlte::page')
@section('title', 'Dashboard · ')

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), 'Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h4 class="lead">Dashboard {{ $establishment->corporate_name }}</h4>
        </div>
    </div>

        <div class="row">
            <div class="col-md-6">
                <!-- small box -->
                <div class="small-box bg-success bg-yellow-active">
                    <div class="inner">
                        <h3>{{ $eventScheduled }}</h3>
                        <p>Eventos agendados</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-success bg-green-gradient">
                    <div class="inner">
                        <h3>{{ $eventClosed }}</h3>
                        <p>Eventos até o momento</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>


    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid pull-center title-header">
                <div class="box-header with-border">
                    <h3 class="box-title">Estabelecimento</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualizações do seu estabelecimento</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $establishmentTotal->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualizações dos estabelecimentos da sua cidade</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $establishmentsTotal->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid pull-center title-header">
                <div class="box-header with-border">
                    <h3 class="box-title">Ritmos Musicais</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualização dos Ritmos Musicais esta semana</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $rhythmWeek->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualização dos Ritmos Musicais neste mês</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $rhythmMonth->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Total de visualização dos Ritmos Musicais</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $rhythmTotal->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualização dos Ritmos Musicais em {{ date('Y') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $rhythmYear->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid pull-center title-header">
                <div class="box-header with-border">
                    <h3 class="box-title">Categorias</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualização das Categorias dos Estabelecimentos esta semana</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $categoryWeek->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualização das categorias dos estabelecimentos neste mês</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $categoryMonth->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Total de visualização das Categorias dos Estabelecimentos</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $categoryTotal->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualização das Categorias dos Estabelecimentos em {{ date('Y') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $categoryYear->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid pull-center title-header">
                <div class="box-header with-border">
                    <h3 class="box-title">Categorias e Ritmos Musicais da sua Cidade</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualizações do mês em Categorias de sua Cidade</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $categoryCityMonth->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Visualizações do mês em Ritmos Musicais de sua Cidade</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="pad">
                            {!! $rhythmCityMonth->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection