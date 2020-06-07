@extends('adminlte::page')
@section('title', 'Logs Acessos Usuários · ')

@section('content_header')
    <h1>Log acessos Usuários&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('logs.index') }}">Logs</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($logsSearch))
                            {{ $logsSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $logsSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat" title="Buscar log acesso">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($logsSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('logs.index') }}">
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
                            <th>Usuário</th>
                            <th>Classe</th>
                            <th>Estabelecimento Conectado</th>
                            <th>Área Acessada</th>
                            <th>Data Acesso</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($logs) && sizeof($logs) > 0)
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        {{ $log->users->name }}
                                    </td>
                                    <td>
                                        {{ $log->class }}
                                    </td>
                                    <td>
                                        {{ isset($log->establishment->corporate_name) ? $log->establishment->corporate_name : '' }}
                                    </td>
                                    <td>
                                        {{ $log->description }}
                                    </td>
                                    <td>
                                        {{ formatDateHour($log->data_access) }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('logs.show', $log) }}" class="action-show"
                                           title="Visualizar log {{ $log->users->name }}"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum log de usuário {{ (!empty($logsSearch)) ? 'encontrado.' : 'cadastrado.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    <div class="box-footer clearfix">
                        {{ $logs->appends(['q' => $logsSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection