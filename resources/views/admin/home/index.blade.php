@extends('adminlte::page')

@section('title', 'Nightlife Painel')

@section('content_header')
    <h1>&nbsp;</h1>
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
                @if (count($news) > 0)
                    @foreach($news as $n)
                        <p><label>{{ $n->title }}: </label> {{ $n->description }}</p>
                    @endforeach
                @else
                    <p>Não há nenhuma atualização recente.</p>
                @endif
            </div>
        </div>
    </div>

    @if (count($newsImportant) > 0)
        <div class="container">
            <div class="col-md-16">
                <div class="callout callout-danger box">
                    <h4><i class="fa fa-fw fa-times"></i> Importante!</h4>
                    @foreach($newsImportant as $n)
                        <p><label>{{ $n->title }}: </label> {{ $n->description }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <br>

    <div class="container">
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-green"><i class="fa fa-volume-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ritmo musical mais procurado essa semana</span>
                    <span class="info-box-number">{{ $rhythm->rhythm->name }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Eventos feitos [{{ isset($id) ? 'Estabelecimento' : 'Todos' }}]</span>
                    <span class="info-box-number">{{ isset($events) ? $events : '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-blue"><i class="fa fa-search"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Categoria mais procurada essa semana</span>
                    <span class="info-box-number">{{ isset($category) ? $category->category->name : '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="info-box box">
                <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Novos usuários nos últimos 7 dias</span>
                    <span class="info-box-number">{{ isset($user) ? $user : 0 }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection


