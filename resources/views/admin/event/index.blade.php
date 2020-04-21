@extends('adminlte::page')
@section('title', 'Eventos · ')

@section('content_header')
    <h1>Eventos</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $events) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <body class="box box-warning">
            <div class="box-header with-border">
                <div class="box-title col-xs-6 no-padding">
                    <a class="btn btn-success btn-flat" href="{{ route('event.create')  }}">
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
                            <button type="submit" class="btn btn-default btn-flat">
                                <i class="fas fa-search"></i>
                            </button>
                            @if (!empty($eventSearch))
                                <a title="Limpar" class="btn btn-default"
                                   href="{{ route('event.index') }}">
                                    <i class="fas fa-backspace"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

            @if(isset($events) && sizeof($events))
                <div class="cards">
                    <div class="card__wrapper">
                        <div class="card">
                            <figure class="card__figure">
                                <img class="card__image"
                                     src="https://media.gazetadopovo.com.br/2019/09/27183838/volkswagen-golf-gti-hatch-1-960x540.jpg">
                            </figure>
                            <div class="card__title">Coloque aqui o título do evento!</div>
                            <div class="card__date">01/01/2000</div>
                            <div class="card__links">
                                <a href="#" class="card__link card__link--danger">EXCLUIR</a>
                                <a href="#" class="card__link card__link--success">EDITAR</a>
                                <a href="#" class="card__link card__link--info">VISUALIZAR</a>
                            </div>
                        </div>
                    </div>
                    <div class="card__wrapper">
                        <div class="card">
                            <figure class="card__figure">
                                <img class="card__image"
                                     src="https://media.gazetadopovo.com.br/2019/09/27183838/volkswagen-golf-gti-hatch-1-960x540.jpg">
                            </figure>
                            <div class="card__title">Coloque aqui o título do evento!</div>
                            <div class="card__date">01/01/2000</div>
                            <div class="card__links">
                                <a href="#" class="card__link card__link--danger">EXCLUIR</a>
                                <a href="#" class="card__link card__link--success">EDITAR</a>
                                <a href="#" class="card__link card__link--info">VISUALIZAR</a>
                            </div>
                        </div>
                    </div>
                    <div class="card__wrapper">
                        <div class="card">
                            <figure class="card__figure">
                                <img class="card__image"
                                     src="https://media.gazetadopovo.com.br/2019/09/27183838/volkswagen-golf-gti-hatch-1-960x540.jpg">
                            </figure>
                            <div class="card__title">Coloque aqui o título do evento!</div>
                            <div class="card__date">01/01/2000</div>
                            <div class="card__links">
                                <a href="#" class="card__link card__link--danger">EXCLUIR</a>
                                <a href="#" class="card__link card__link--success">EDITAR</a>
                                <a href="#" class="card__link card__link--info">VISUALIZAR</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="cards">
                    <div class="card__wrapper">
                        <div class="card" style="text-align: center">
                            Nenhum evento cadastrado
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
    </div>

    @include('vendor/flash-message')
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/Global/js/general.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Admin/css/event.css') }}"/>
@endsection