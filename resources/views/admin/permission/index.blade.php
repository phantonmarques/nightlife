@extends('adminlte::page')
@section('title', 'Permissões · ')

@section('content_header')
    <h1>Permissões</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $permissions) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-1 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('permission.create')  }}"
                           title="Cadastrar nova permissão">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Nova Permissão
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($permissionSearch))
                            {{ $permissionSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $permissionSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat" title="Buscar permissões">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($permissionSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('permission.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                    <div class="col-xs-1 col-sm-1 no-padding separate-3" id="displayDelete" style="display:none;">
                        <a class="btn btn-warning btn-flat" href="{{ route('permission.massDestroy') }}" id="deleteSelected"
                           title="Exclusão de permissão selecionada">
                            <i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Apagar Selecionado(s)
                        </a>
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
                            <th>Permissão</th>
                            <th>Data de Criação</th>
                            <th>Data de Atualização</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($permissions) && sizeof($permissions) > 0)
                            @foreach($permissions as $permission)
                                <tr data-entry-id="{{ $permission->id }}">
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="permission[id][]"
                                               value="{{ $permission->id }}"/>
                                    </td>
                                    <td>
                                        {{ $permission->id }}
                                    </td>
                                    <td>
                                        {{ $permission->name }}
                                    </td>
                                    <td>
                                        {{ $permission->slug }}
                                    </td>
                                    <td>
                                        {{ $permission->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $permission->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('permission.edit', $permission) }}" class="action-edit"
                                           title="Editar {{ $permission->name }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="{{ route('permission.destroy', $permission) }}" class="action-delete"
                                           title="Apagar {{ $permission->name }}"><span
                                                    class="glyphicon glyphicon-trash"></span></a>

                                        <a href="{{ route('permission.show', $permission) }}" class="action-show"
                                           title="Visualizar {{ $permission->name }}"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhuma permissão {{ (!empty($permissionSearch)) ? 'encontrada.' : 'cadastrada.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($permissions->hasPages())
                    <div class="box-footer clearfix">
                        {{ $permissions->appends(['q' => $permissionSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/permission.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection