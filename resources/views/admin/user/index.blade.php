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
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('user.create')  }}">
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
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($userSearch))
                                    <a title="Limpar" class="btn btn-default"
                                       href="{{ route('user.index') }}">
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
                        </tr>
                        </thead>

                        <tbody>
                        @if (isset($users) && sizeof($users) > 0)
                            @foreach($users as $user)
                                <tr data-entry-id="{{ $user->id }}">
                                    <th class="text-center">
                                        <input class="icheck" type="checkbox" name="user[id][]" value="{{ $user->id }}" />
                                    </th>
                                    <th>
                                        {{ $user->id }}
                                    </th>
                                    <th>
                                        {{ $user->name }}
                                    </th>
                                    <th>
                                        {{ $user->email }}
                                    </th>
                                    <th>
                                        {{ formatCnpjCpf($user->cpf_cnpj) }}
                                    </th>
                                    <th>
                                        {{ typeUserDescription($user->type_user) }}
                                    </th>
                                    <th>
                                        @foreach($user->roles()->pluck('slug') as $roles)
                                            <span class="label label-primary">{{ $roles }}</span>
                                        @endforeach
                                    </th>
                                    <th>
                                        {{ $user->city()->value('name_visible') }}
                                    </th>
                                    <th>
                                        {{ $user->city->state->name_visible }}
                                    </th>
                                    <th>
                                        {{ $user->created_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <td class="col-actions">
                                        <a href="{{ route('user.edit', $user) }}" class="action-edit"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('user.destroy', $user) }}"
                                           class="action-delete"><span class="glyphicon glyphicon-trash" onsubmit="confirm('Tem certeza?')"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('user.show', $user) }}" class="action-show"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum usuário {{ (!empty($userSearch)) ? 'encontrada' : 'cadastrada' }}
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

    @include('vendor/flash-message')
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/Global/js/general.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection