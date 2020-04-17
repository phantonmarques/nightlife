@extends('adminlte::page')
@section('title', 'Função · Visualização')

@section('content_header')
    <h1>Função [{{ $role->name }}]</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $role) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações da Função</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $role->id
                            ])
                        </div>
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
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $role->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $role->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h4 class="lead">Informações da Permissão Vinculada a Função</h4>
                    </div>

                    @if(sizeof($role->permissions)>0)
                        @foreach($role->permissions as $key => $permission)
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
                        {{ link_to_route('role.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('role.edit', $title = 'Editar', $role, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection