@extends('adminlte::page')
@section('title', 'Funções · ')

@section('content_header')
    <h1>Funções</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $roles) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('role.create')  }}"
                           title="Cadastrar nova função">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Nova Função
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($roleSearch))
                            {{ $roleSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $roleSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat" title="Buscar funções">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($roleSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('role.index') }}">
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
                                <input class="icheck check-all" type="checkbox"/>
                            </th>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Função</th>
                            <th>Permissões da Função</th>
                            <th>Data de Criação</th>
                            <th>Data de Atualização</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($roles) && sizeof($roles) > 0)
                            @foreach($roles as $role)
                                <tr data-entry-id="{{ $role->id }}">
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="role[id][]"
                                               value="{{ $role->id }}"/>
                                    </td>
                                    <td>
                                        {{ $role->id }}
                                    </td>
                                    <td>
                                        {{ $role->name }}
                                    </td>
                                    <td>
                                        {{ $role->slug }}
                                    </td>
                                    <td>
                                        @foreach($role->permissions()->pluck('slug') as $permission)
                                            <span class="label label-primary">{{ $permission }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $role->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $role->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('role.edit', $role) }}" class="action-edit"
                                           title="Editar {{ $role->name }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="{{ route('role.destroy', $role) }}" class="action-delete"
                                           title="Apagar {{ $role->name }}"><span
                                                    class="glyphicon glyphicon-trash"></span></a>

                                        <a href="{{ route('role.show', $role) }}" class="action-show"
                                           title="Visualizar {{ $role->name }}"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhuma função {{ (!empty($roleSearch)) ? 'encontrada.' : 'cadastrada.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($roles->hasPages())
                    <div class="box-footer clearfix">
                        {{ $roles->appends(['q' => $roleSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection