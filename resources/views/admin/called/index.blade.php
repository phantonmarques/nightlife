@extends('adminlte::page')
@section('title', 'Chamados · ')

@section('content_header')
    <h1>Chamados</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    @can ('establishment-employee')
                        <div class="box-title col-xs-1 no-padding">
                            <a class="btn btn-success btn-flat" href="{{ route('called.create')  }}"
                               title="Cadastro de nova categoria">
                                <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Chamado
                            </a>
                        </div>
                    @elsecan ('manage-called')
                        <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                            {{ Form::open(['method' => 'GET']) }}
                            <div class="input-group">
                            @if (empty($calledSearch))
                                {{ $calledSearch = '' }}
                            @endif
                            <!-- SEARCH PESQUISA INPUT -->
                            {{ Form::text('s', $calledSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                            <!-- FIM SEARCH PESQUISA -->

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default btn-flat" title="Buscar Categorias">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if (!empty($calledSearch))
                                        <a title="Limpar busca" class="btn btn-default"
                                           href="{{ route('called.index') }}">
                                            <i class="fas fa-backspace"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    @endcan
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover dataTable table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Situação Chamado</th>
                            <th>Data Último Atendimento</th>
                            <th>Tempo Último Atendimento</th>
                            <th>Status</th>
                            <th>Data de Criação</th>
                            <th>Data de Atualização</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($called) && sizeof($called) > 0)
                            @foreach($called as $call)
                                <tr>
                                    <td>
                                        {{ $call->id }}
                                    </td>
                                    <td>
                                        {{ $call->subject }}
                                    </td>
                                    <td>
                                        {{ formatSituation($call->called_interaction()->orderBy('id', 'DESC')->first()->situation) }}
                                    </td>
                                    <td>
                                        {{ formatDate($call->called_interaction()->orderBy('id', 'DESC')->first()->date_service) }}
                                    </td>
                                    <td>
                                        {{ $call->called_interaction()->orderBy('id', 'DESC')->first()->time_service }}
                                    </td>
                                    <td>
                                        {{ ($call->status) ? 'Aberto' : 'Fechado' }}
                                    </td>
                                    <td>
                                        {{ $call->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $call->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('called.edit', $call) }}" class="action-edit"
                                           title="Interagir {{ $call->subject }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="{{ route('called.show', $call) }}" class="action-show"
                                           title="Visualizar {{ $call->subject }}"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum chamado {{ (!empty($calledSearch)) ? 'encontrada.' : 'cadastrada.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($called->hasPages())
                    <div class="box-footer clearfix">
                        {{ $called->appends(['q' => $calledSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection
