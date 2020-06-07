@extends('adminlte::page')
@section('title', 'Notícias · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('news.index') }}">Notícias</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-1 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('news.create')  }}"
                           title="Cadastrar nova notícia">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Nova Notícia
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($newsSearch))
                            {{ $newsSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $newsSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat" title="Buscar notícias">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($newsSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('news.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover dataTable table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Importante</th>
                            <th>Data de Criação</th>
                            <th>Data de Atualização</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($news) && sizeof($news) > 0)
                            @foreach($news as $n)
                                <tr>
                                    <td>
                                        {{ $n->id }}
                                    </td>
                                    <td>
                                        {{ $n->title }}
                                    </td>
                                    <td>
                                        {{ ($n->important) ? 'Sim' : 'Não' }}
                                    </td>
                                    <td>
                                        {{ $n->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $n->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('news.edit', $n) }}" class="action-edit"
                                           title="Editar {{ $n->title }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="{{ route('news.destroy', $n) }}" class="action-delete"
                                           title="Apagar {{ $n->title }}"><span
                                                    class="glyphicon glyphicon-trash"></span></a>

                                        <a href="{{ route('news.show', $n) }}" class="action-show"
                                           title="Visualizar {{ $n->title }}"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhuma notícia {{ (!empty($newsSearch)) ? 'encontrada.' : 'cadastrada.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($news->hasPages())
                    <div class="box-footer clearfix">
                        {{ $news->appends(['q' => $newsSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection