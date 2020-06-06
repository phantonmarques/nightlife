@extends('adminlte::page')
@section('title', 'Chamado · Visualização')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('called.index') }}">Chamados</a></li>
        <li><a href="{{ route('called.show', $called) }}"> Visualizar Chamado</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do Chamado</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'ID',
                                'value' => $called->id
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Assunto',
                                'value' => $called->subject
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $called->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-5">
                            @include('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $called->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>
                </div>

                @if (isset($called->id))
                    <div class="row top-separate">
                        <div class="col-md-10">
                            @can('establishment-employee')
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-bordered table-hover dataTable table-striped">
                                        <thead>
                                        <tr>
                                            <th>Descrição</th>
                                            <th>Situação</th>
                                            <th>Usuário Interação</th>
                                        </tr>
                                        </thead>
                                        @foreach($called->called_interaction as $interaction)
                                            @if ($interaction->visible)
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        {!! $interaction->description !!}
                                                    </td>
                                                    <td>
                                                        {{ formatSituation($interaction->situation) }}
                                                    </td>
                                                    <td>
                                                        {{ $interaction->user->name }}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                            @else
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-bordered table-hover dataTable table-striped">
                                        <thead>
                                        <tr>
                                            <th>Interação</th>
                                            <th>Descrição</th>
                                            <th>Situação</th>
                                            <th>Data Último Atendimento</th>
                                            <th>Tempo Último Atendimento</th>
                                            <th>Estabelecimento</th>
                                            <th>Usuário Interação</th>
                                            <th>Visível Cliente</th>
                                        </tr>
                                        </thead>
                                        @foreach($called->called_interaction as $key => $interaction)
                                            <tbody>
                                            <tr>
                                                <td>
                                                    {{ '#' . ($key+1) }}
                                                </td>
                                                <td>
                                                    {!! $interaction->description !!}
                                                </td>
                                                <td>
                                                    {{ formatSituation($interaction->situation) }}
                                                </td>
                                                <td>
                                                    {{ formatDate($interaction->date_service) }}
                                                </td>
                                                <td>
                                                    {{ $interaction->time_service ? formatHour($interaction->time_service): '00:00' }}
                                                </td>
                                                <td>
                                                    {{ $interaction->establishment->corporate_name }}
                                                </td>
                                                <td>
                                                    {{ $interaction->user->name . ' [' . $interaction->user->id . ']' }}
                                                </td>
                                                <td>
                                                    {{ $interaction->visible ? 'Sim' : 'Não' }}
                                                </td>
                                            </tr>
                                            </tbody>

                                        @endforeach
                                    </table>
                                </div>
                            @endcan

                        </div>
                    </div>
                @endif

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('called.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('called.edit', $title = 'Editar', $called, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection