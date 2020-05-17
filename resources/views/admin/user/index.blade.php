@extends('adminlte::page')
@section('title', 'Usuários · ')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $users) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-1 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('user.create')  }}"
                           title="Cadastrar novo usuário">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Usuário
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($userSearch))
                            {{ $userSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $userSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat" title="Buscar usuários">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($userSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('user.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                    <div class="col-xs-1 col-sm-1 no-padding" id="displayDelete" style="display:none;">
                        <a class="btn btn-warning btn-flat" href="{{ route('user.massDestroy') }}" id="deleteSelected"
                           title="Exclusão de usuário selecionado">
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
                            <th>
                                ID
                            </th>
                            <th>
                                Nome
                            </th>
                            <th>
                                E-mail
                            </th>
                            <th>
                                CPF/CNPJ
                            </th>
                            <th>
                                Tipo Usuário
                            </th>
                            <th>
                                Funções
                            </th>
                            <th>
                                Cidade
                            </th>
                            <th>
                                Estado
                            </th>
                            <th>
                                Data de Criação
                            </th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (isset($users) && sizeof($users) > 0)
                            @foreach($users as $user)
                                <tr data-entry-id="{{ $user->id }}">
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="user[id][]"
                                               value="{{ $user->id }}"/>
                                    </td>
                                    <td>
                                        {{ $user->id }}
                                    </td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ formatCnpjCpf($user->cpf_cnpj) }}
                                    </td>
                                    <td>
                                        {{ typeUserDescription($user->type_user) }}
                                    </td>
                                    <td>
                                        @foreach($user->roles()->pluck('slug') as $roles)
                                            <span class="label label-primary">{{ $roles }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ !empty($user->city_id) ? $user->city()->value('name_visible') : '' }}
                                    </td>
                                    <td>
                                        {{ !empty($user->city_id) ? $user->city->state->name_visible : '' }}
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('user.edit', $user) }}" class="action-edit"
                                           title="Editar {{ $user->name }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="{{ route('user.destroy', $user) }}" class="action-delete"
                                           title="Apagar {{ $user->name }}"><span
                                                    class="glyphicon glyphicon-trash"></span></a>

                                        <a href="{{ route('user.show', $user) }}" class="action-show"
                                           title="Visualizar {{ $user->name }}"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum usuário {{ (!empty($userSearch)) ? 'encontrado.' : 'cadastrado.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="box-footer clearfix">
                        {{ $users->appends(['q' => $userSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection