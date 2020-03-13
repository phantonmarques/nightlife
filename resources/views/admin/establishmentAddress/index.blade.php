@extends('adminlte::page')
@section('title', 'Estabelecimentos · ')

@section('content_header')
    <h1>Estabelecimentos</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $establishments) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('establishment.create')  }}">
                            <!--  //route('vehicles.create')  -->
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Estabelecimento
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                            @if (empty($search))
                                {{ $search = '' }}
                            @endif
                            {{ Form::text('q', $search, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($search))
                                    <a title="Limpar" class="btn btn-default"
                                       href="{{ route('establishments.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-striped table-vehicles">
                        <thead>
                        <tr>
{{--                            <th class="text-center">--}}
{{--                                <input class="icheck check-all" type="checkbox"/>--}}
{{--                            </th>--}}
                            <th>Razão Social</th>
                            <th>Inscrição Estadual</th>
                            <th>CNPJ</th>
                            <th>Tipo Licença</th>
                            <th>Situação Empresa</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Data de criação</th>
                            <th>Data de atualização</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($establishments) && sizeof($establishments) > 0)
                            @foreach($establishments as $establishment)
                                <tr>
{{--                                    <th class="text-center">--}}
{{--                                        <input class="icheck check-all" name="establishment[id][]" type="checkbox"--}}
{{--                                               value="{{ $establishment->id }}"/>--}}
{{--                                    </th>--}}
                                    <th>
                                        {{ $establishment->corporate_name }}
                                    </th>
                                    <th>
                                        {{ $establishment->state_registration }}
                                    </th>
                                    <th>
                                        {{ $establishment->users->cpf_cnpj }}
                                    </th>
                                    <th>
                                        {{ $establishment->type_license === 'f' ? 'Full' : 'Básica' }}
                                    </th>
                                    <th>
                                        {{ $establishment->status ? 'Ativa' : 'Inativa' }}
                                    </th>
                                    <th>
                                        {{ $establishment->users->login }}
                                    </th>
                                    <th>
                                        {{ $establishment->users->email }}
                                    </th>
                                    <th>
                                        {{ $establishment->created_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <th>
                                        {{ $establishment->updated_at->format('d/m/Y - H:i') }}
                                    </th>
{{--                                    <td class="col-actions">--}}
{{--                                        <a href="{{ route('establishment.destroy', $establishment) }}" class="action-delete"><span class="glyphicon glyphicon-trash"></span></a>--}}
{{--                                    </td>--}}
                                    <td class="col-actions">
                                        <a href="{{ route('establishment.edit', $establishment) }}" class="action-edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('establishment.show', $establishment) }}"><span class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum estabelecimento cadastrado
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($establishments->hasPages())
                    <div class="box-footer clearfix">
                        {{ $establishments->appends(['q' => $search])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('vendor/flash-message')

    {{--    @include('adminlte::modal.destroy', [--}}
    {{--    'id' => 'vehicles-destroy',--}}
    {{--    'title' => 'Excluir veículo',--}}
    {{--    'description' => 'Tẽm certeza que quer excluir este veículo?'--}}
    {{--    ])--}}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishment.css') }}"/>
@endsection
