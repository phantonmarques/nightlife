@extends('adminlte::page')
@section('title', 'Endereço Estabelecimento · ')

@section('content_header')
    <h1>Endereço Estabelecimento</h1>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName(), $establishmentsAddress) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('establishmentAddress.create')  }}">
                            <!--  //route('vehicles.create')  -->
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Endereço
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                            @if (empty($search))
                                {{ $search = '' }}
                            @endif
                            {{ Form::text('s', $search, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($search))
                                    <a title="Limpar" class="btn btn-default"
                                       href="{{ route('establishmentAddress.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Estabelecimento</th>
                            <th>Endereço</th>
                            <th>Número</th>
                            <th>CEP</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Nome Contato</th>
                            <th>Telefone</th>
                            <th>Whatsapp</th>
                            <th>Data de criação</th>
                            <th>Data de atualização</th>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($establishmentsAddress) && sizeof($establishmentsAddress) > 0)
                            @foreach($establishmentsAddress as $address)
                                <tr>
                                    <th>
                                        {{ $establishment }}
                                    </th>
                                    <th>
                                        {{ $address->street_name }}
                                    </th>
                                    <th>
                                        {{ $address->building_number }}
                                    </th>
                                    <th>
                                        {{ $address->zip_code }}
                                    </th>
                                    <th>
                                        {{ $address->city_name }}
                                    </th>
                                    <th>
                                        {{ $address->state_name }}
                                    </th>
                                    <th>
                                        {{ $address->establishments_phone[0]->name }}
                                    </th>
                                    <th>
                                        {{ $address->establishments_phone[0]->phone }}
                                    </th>
                                    <th>
                                        {{ ($address->establishments_phone[0]->whatsapp) ? 'Sim' : 'Não' }}
                                    </th>
                                    <th>
                                        {{ $address->created_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <th>
                                        {{ $address->updated_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <td class="col-actions">
                                        <a href="{{ route('establishmentAddress.destroy', $address) }}" class="action-delete"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('establishmentAddress.edit', $address) }}" class="action-edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('establishmentAddress.show', $address) }}"><span class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum endereço do estabelecimento cadastrado
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($establishmentsAddress->hasPages())
                    <div class="box-footer clearfix">
                        {{ $establishmentsAddress->appends(['q' => $search])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('vendor/flash-message')

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/global/js/general.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishmentAddress.css') }}"/>
@endsection
