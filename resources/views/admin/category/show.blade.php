@extends('adminlte::page')
@section('title', 'Categoria · Visualização')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('category.index') }}">Chamados</a></li>
        <li><a href="{{ route('category.show', $category) }}"> Visualizar Chamado</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Categoria</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $category->id
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome Categoria',
                                'value' => $category->name
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $category->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $category->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('category.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('category.edit', $title = 'Editar', $category, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection