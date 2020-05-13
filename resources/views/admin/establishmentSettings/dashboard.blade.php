@extends('adminlte::page')
@section('title', 'Dashboard · ')

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), 'Dashboard') }}
@endsection

@section('content')


<div class="row">
    <div class="col-md-8">
    <h4 class="lead">Dados do seu estabelecimento e da mesma cidade</h4>
    </div>
</div>
    <div class="row">
        <div class="col-md-5">
        <h1 class='lead'>Visualizações do seu estabelecimento:</h1>
        {!! $establishmenttotal->render() !!}
        </div>
        <div class="col-md-5">
        <h1 class='lead'>Visualizações dos estabelecimentos da sua cidade:</h1>
        {!! $establishmentstotal->render() !!}
        </div>
    </div>
<br><br>

    <div class="col-md-12">
    <h4 class="lead">Eventos</h4>
    </div>
    <div class="container-fluid">
        <div class="row">
          <div class="col-sm-4">
              <!-- small box -->
            <div class="small-box bg-success bg-green">
                <div class="inner">
                <h3>10</h3>
                <p>Eventos agora</p>
                </div>
              <div class="icon">
                <i class="fa fa-fast-forward"></i>
              </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="small-box bg-success bg-red">
                <div class="inner">
                <h3>10</h3>
                <p>Eventos até o momento</p>
                </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <h4 class="lead">Ritmos Musicais</h4>
</div>

<div class="row">
            <div class="col-md-5" >
            <h1 class='lead'>Visualização dos ritmos musicais esta semana:</h1>
                {!! $rhythmweek->render() !!}
            </div>
            <div class="col-md-5" >
            <h1 class='lead'>Visualização dos ritmos musicais neste mês:</h1>
                {!! $rhythmmonth->render() !!}
            </div>
</div>
<div class="row">
            <div class="col-md-5" >
            <h1 class='lead'>Total de visualização dos ritmos musicais:</h1>
                {!! $rhythmtotal->render() !!}
            </div>
            <div class="col-md-5">
            <h1 class='lead'>Visualização dos ritmos musicais em 2020:</h1>
                {!! $rhythmyearly->render() !!}
            </div>       
</div>
<br><br>

<div class="col-md-12">
    <h4 class="lead">Categorias dos estabelecimentos da sua cidade</h4>
</div>

<div class="row">
            <div class="col-md-5" >
            <h1 class='lead'>Visualização das categorias dos estabelecimentos esta semana:</h1>
                {!! $categoryweek->render() !!}
            </div>
            <div class="col-md-5" >
            <h1 class='lead'>Visualização das categorias dos estabelecimentos neste mês:</h1>
                {!! $categorymonth->render() !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-5" >
            <h1 class='lead'>Total de visualização das categorias dos estabelecimentos:</h1>
                {!! $categorytotal->render() !!}
            </div>
            <div class="col-md-5">
            <h1 class='lead'>Visualização das categorias dos estabelecimentos em 2020:</h1>
                {!! $categoryyearly->render() !!}
            </div>
        </div>
<br><br>

<div class="col-md-12">
    <h4 class="lead">Visualização dos ritmos musicais da sua cidade</h4>
</div>

<div class="row">
            <div class="col-md-5" >
            <h1 class='lead'>Visualização dos ritmos musicais esta semana:</h1>
                {!! $rhythmweekcustom->render() !!}
            </div>
            <div class="col-md-5" >
            <h1 class='lead'>Visualização dos ritmos musicais neste mês:</h1>
                {!! $rhythmmonthcustom->render() !!}
            </div>
</div>
<div class="row">
            <div class="col-md-5" >
            <h1 class='lead'>Total de visualização dos ritmos musicais:</h1>
                {!! $rhythmtotalcustom->render() !!}
            </div>
            <div class="col-md-5">
            <h1 class='lead'>Visualização dos ritmos musicais em 2020:</h1>
                {!! $rhythmyearlycustom->render() !!}
            </div>       
</div>
<br><br>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection