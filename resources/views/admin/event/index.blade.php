@extends('adminlte::page')
@section('title', 'Eventos Agendados · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('event.index') }}">Eventos</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <body class="box box-warning">
            <div class="box-header with-border">
                <div class="box-title col-xs-6 no-padding">
                    <a class="btn btn-success btn-flat" href="{{ route('event.create')  }}"
                       title="Cadastrar novo agendamento de evento">
                        <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo evento
                    </a>
                </div>

                <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                    {{ Form::open(['method' => 'GET']) }}
                    <div class="input-group">
                    @if (empty($eventSearch))
                        {{ $eventSearch = '' }}
                    @endif
                    <!-- SEARCH PESQUISA INPUT -->
                    {{ Form::text('s', $eventSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                    <!-- FIM SEARCH PESQUISA -->

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-flat" title="Buscar evento agendado">
                                <i class="fas fa-search"></i>
                            </button>
                            @if (!empty($eventSearch))
                                <a title="Limpar busca" class="btn btn-default"
                                   href="{{ route('event.index') }}">
                                    <i class="fas fa-backspace"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

            @if(isset($events) && sizeof($events) > 0)
                <div class="cards">
                    @foreach ($events as $event)
                        <div class="card__wrapper">
                            <div class="card">
                                <figure class="card__figure">
                                    <img class="card__image"
                                         src="{{ asset("storage/" .$event->cover_path) }}"
                                         alt="{{ $event->name }}">
                                </figure>
                                <div class="card__title">{{ $event->name }}</div>
                                <div class="card__date">{{ formatDate($event->date_event) }}</div>
                                <div class="card__links">
                                    <a href="{{ route('event.destroy', $event) }}"
                                       class="card__link card__link--danger action-delete"
                                       title="Excluir {{ $event->name }}">EXCLUIR</a>
                                    <a href="{{ route('event.edit', $event) }}" class="card__link card__link--success"
                                       title="Editar {{ $event->name }}">EDITAR</a>
                                    <a href="{{ route('event.show', $event) }}" class="card__link card__link--info"
                                       title="Visualizar {{ $event->name }}">VISUALIZAR</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="cards">
                    <div class="card__wrapper">
                        <div class="card" style="text-align: center">
                            Nenhum
                            evento {{ (!empty($eventSearch)) ? 'encontrado/disponível.' : 'cadastrado/disponível.' }}
                        </div>
                    </div>
                </div>
            @endif


            @if ($events->hasPages())
                <div class="box-footer clearfix">
                    {{ $events->appends(['q' => $eventSearch])->onEachSide(2)->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Admin/css/event.css') }}"/>
@endsection