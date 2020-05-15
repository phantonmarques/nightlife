@extends('adminlte::page')

@section('title', 'Nightlife Painel')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
    </ol>
@stop

@section('content')
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Bem vindo <b>{{ auth()->user()->name }}</b></h3>
        </div>

        <br>

        <div class="col-md-16">
            <div class="callout callout-info box">
                <h4><i class="icon fa fa-info"></i> Atualizações </h4>
                <p>Aqui terá atualizações.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-16">
            <div class="callout callout-danger box">
                <h4><i class="fa fa-fw fa-times"></i> Importante!</h4>
                <p>Informações importantes aqui.</p>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-green"><i class="fa fa-volume-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ritmo musical mais procurado essa semana</span>
                    <span class="info-box-number">O RITMO</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Eventos feitos</span>
                    <span class="info-box-number">NUMERO DOS EVENTOS</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-blue"><i class="fa fa-search"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Categoria mais procurada essa semana</span>
                    <span class="info-box-number">A CATEGORIA</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Novos usuários essa semana</span>
                    <span class="info-box-number">QUANTIDADE</span>
                </div>
            </div>
        </div>
    </div>
@endsection


