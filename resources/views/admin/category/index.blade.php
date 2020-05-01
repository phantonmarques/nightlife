@extends('adminlte::page')
@section('title', 'Categorias · ')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $categorys) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('category.create')  }}">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Categoria
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($categorySearch))
                            {{ $categorySearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $categorySearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($categorySearch))
                                    <a title="Limpar" class="btn btn-default"
                                       href="{{ route('category.index') }}">
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
                                <th class="text-center">
                                    <input class="icheck check-all" type="checkbox" />
                                </th>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Data de Criação</th>
                                <th>Data de Atualização</th>
                                <th class="col-actions">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (isset($categorys) && sizeof($categorys) > 0)
                            @foreach($categorys as $category)
                                <tr data-entry-id="{{ $category->id }}">
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="category[id][]" value="{{ $category->id }}" />
                                    </td>
                                    <td>
                                        {{ $category->id }}
                                    </td>
                                    <td>
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        {{ $category->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $category->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('category.edit', $category) }}" class="action-edit"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="{{ route('category.destroy', $category) }}"
                                           class="action-delete"><span class="glyphicon glyphicon-trash"></span></a>
                                        <a href="{{ route('category.show', $category) }}" class="action-show"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhuma categoria {{ (!empty($categorySearch)) ? 'encontrada' : 'cadastrada' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($categorys->hasPages())
                    <div class="box-footer clearfix">
                        {{ $categorys->appends(['q' => $categorySearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection