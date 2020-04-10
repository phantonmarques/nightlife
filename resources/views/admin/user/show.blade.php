@extends('adminlte::page')
@section('title', 'Usuário · Visualização')

@section('content_header')
    <h1>Usuário [{{ $user->name }}]</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $user) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Usuário</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $user->id
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome Usuário',
                                'value' => $user->name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'E-mail',
                                'value' => $user->email
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de verificação e-mail',
                                'value' => $user->email_verified_at
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => (strlen($user->cpf_cnpj) < 12) ? 'CPF' : 'CNPJ',
                                'value' => formatCnpjCpf($user->cpf_cnpj)
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo usuário',
                                'value' => typeUserDescription($user->type_user)
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $user->city->name_visible
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $user->city->state->name_visible
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $user->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $user->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    @if(sizeof($user->roles))
                        <div class="col-md-12">
                            <h4 class="lead">Informações da Função Vinculada ao usuário</h4>
                        </div>

                        @foreach($user->roles as $key => $role)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Nome Função',
                                        'value' => $role->name
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Função',
                                        'value' => $role->slug
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Data de Criação Função',
                                        'value' => $role->created_at->format('d/m/Y - H:i')
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif


                    @if(sizeof($user->permissions))
                        <div class="col-md-12">
                            <h4 class="lead">Informações da Permissão Vinculada ao usuário</h4>
                        </div>

                        @foreach($user->permissions as $key => $permission)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Nome Permissão ' . ($key+1),
                                        'value' => $permission->name
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Permissão ' . ($key+1),
                                        'value' => $permission->slug
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Data de Criação Permissão ' . ($key+1),
                                        'value' => $permission->created_at->format('d/m/Y - H:i')
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('user.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('user.edit', $title = 'Editar', $user, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection