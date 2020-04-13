@extends('adminlte::page')
@section('title', 'Ritmo musicais · ')

@section('content_header')
    <h1>Ritmo musicais</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $musicalRhythms) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('musicalRhythm.create')  }}">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Ritmo Musical
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($musicalRhythmSearch))
                            {{ $musicalRhythmSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $musicalRhythmSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($musicalRhythmSearch))
                                    <a title="Limpar" class="btn btn-default"
                                       href="{{ route('musicalRhythm.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">
                                <input class="icheck check-all" type="checkbox" />
                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Nome
                            </th>
                            <th>
                                Data de Criação
                            </th>
                            <th>
                                Data de Atualização
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (isset($musicalRhythms) && sizeof($musicalRhythms) > 0)
                            @foreach($musicalRhythms as $musicalRhythm)
                                <tr data-entry-id="{{ $musicalRhythm->id }}">
                                    <th class="text-center">
                                        <input class="icheck" type="checkbox" name="musicalRhythm[id][]" value="{{ $musicalRhythm->id }}" />
                                    </th>
                                    <th>
                                        {{ $musicalRhythm->id }}
                                    </th>
                                    <th>
                                        {{ $musicalRhythm->name }}
                                    </th>
                                    <th>
                                        {{ $musicalRhythm->created_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <th>
                                        {{ $musicalRhythm->updated_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <td class="col-actions">
                                        <a href="{{ route('musicalRhythm.edit', $musicalRhythm) }}" class="action-edit"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('musicalRhythm.destroy', $musicalRhythm) }}"
                                           class="action-delete"><span class="glyphicon glyphicon-trash" onsubmit="confirm('Tem certeza?')"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('musicalRhythm.show', $musicalRhythm) }}" class="action-show"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhuma categoria {{ (!empty($musicalRhythmSearch)) ? 'encontrada' : 'cadastrada' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($musicalRhythms->hasPages())
                    <div class="box-footer clearfix">
                        {{ $musicalRhythms->appends(['q' => $musicalRhythmSearch])->onEachSide(2)->links() }}
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
@endsection