@extends('adminlte::page')
@section('title', 'Ritmos musicais · ')

@section('content_header')
    <h1>Ritmo musicais</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $rhythms) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('rhythm.create')  }}">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Ritmo Musical
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($rhythmSearch))
                            {{ $rhythmSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $rhythmSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($rhythmSearch))
                                    <a title="Limpar" class="btn btn-default"
                                       href="{{ route('rhythm.index') }}">
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
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($rhythms) && sizeof($rhythms) > 0)
                            @foreach($rhythms as $rhythm)
                                <tr data-entry-id="{{ $rhythm->id }}">
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="rhythm[id][]" value="{{ $rhythm->id }}" />
                                    </td>
                                    <td>
                                        {{ $rhythm->id }}
                                    </td>
                                    <td>
                                        {{ $rhythm->name }}
                                    </td>
                                    <td>
                                        {{ $rhythm->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $rhythm->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('rhythm.edit', $rhythm) }}" class="action-edit"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="{{ route('rhythm.destroy', $rhythm) }}"
                                           class="action-delete"><span class="glyphicon glyphicon-trash"></span></a>

                                        <a href="{{ route('rhythm.show', $rhythm) }}" class="action-show"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhuma categoria {{ (!empty($rhythmSearch)) ? 'encontrada' : 'cadastrada' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($rhythms->hasPages())
                    <div class="box-footer clearfix">
                        {{ $rhythms->appends(['q' => $rhythmSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection