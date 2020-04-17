@extends('adminlte::page')
@section('title', 'Ritmo Musical · Visualização')

@section('content_header')
    <h1>Ritmo Musical [{{ $rhythm->name }}]</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $rhythm) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Ritmo Musical</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $rhythm->id
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome Ritmo Musical',
                                'value' => $rhythm->name
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $rhythm->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $rhythm->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('rhythm.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('rhythm.edit', $title = 'Editar', $rhythm, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection