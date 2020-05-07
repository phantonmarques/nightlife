@extends('adminlte::page')
@section('title', 'Evento · Visualização')

@section('content_header')
    <h1>Evento [{{ $event->name }}]</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $event) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Evento</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Título Evento',
                                'value' => $event->name
                            ])
                        </div>
                        <div class="col-sm-5">
                            {{ Form::label('Capa do Evento') }}
                            <img class="img-responsive" style="width: 50vh"
                                 src="{{ asset("storage/" . $event->cover_path) }}" alt="{{ $event->name }}">
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data do Evento',
                                'value' => formatDate($event->date_event)
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Preço mínimo do Evento',
                                'value' => number_format($event->price, 2, ',', '.')
                            ])
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Hora inicio do Evento',
                                'value' => formatHour($event->start_time)
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Hora fim do Evento',
                                'value' => formatHour($event->end_time)
                            ])
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            @include('adminlte::form.input.static', [
                                'label' => 'Descrição do Evento',
                                'value' => $event->description
                            ])
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $event->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $event->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h4 class="lead">Informações do Endereço vinculado ao Evento</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $event->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $event->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Endereço do Evento',
                                'value' => $event->establishment_address->street_name . " " . $event->establishment_address->building_number
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'CEP',
                                'value' => formatZipCode($event->establishment_address->zip_code)
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $event->establishment_address->city->name_visible
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $event->establishment_address->city->state->name_visible
                            ])
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-md-2 pull-right">
                        {{ link_to_route('event.edit', $title = 'Editar', $event, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                    <div class="col-md-2 pull-right">
                        {{ link_to_route('event.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection