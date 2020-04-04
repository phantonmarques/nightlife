@extends('adminlte::page')
@section('title', 'Permissão · Visualização')

@section('content_header')
    <h1>Permissão [{{ $permission->name }}]</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $permission) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações da Permissão</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $permission->id
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome Permissão',
                                'value' => $permission->name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Permissão',
                                'value' => $permission->slug
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $permission->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $permission->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('permission.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('permission.edit', $title = 'Editar', $permission, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection