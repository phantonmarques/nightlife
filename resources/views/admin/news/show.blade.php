@extends('adminlte::page')
@section('title', 'Notícia · Visualização')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('news.index') }}">Notícias</a></li>
        <li><a href="{{ route('news.show', $news) }}"> Visualizar notícia</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações da notícia</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $news->id
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Título',
                                'value' => $news->title
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Descrição Notícia',
                                'value' => $news->description
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Importante',
                                'value' => ($news->important) ? 'Sim' : 'Não'
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $news->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $news->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('news.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('news.edit', $title = 'Editar', $news, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection