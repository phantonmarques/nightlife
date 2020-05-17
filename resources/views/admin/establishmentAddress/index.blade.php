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
                    <div class="box-title col-xs-1 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('establishmentAddress.create')  }}"
                           title="Cadastrar novo endereço do estabelecimento">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Endereço
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                            @if (empty($establishmentAddressSearch))
                                {{ $establishmentAddressSearch = '' }}
                            @endif

                            {{ Form::text('s', $establishmentAddressSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat"
                                        title="Buscar Endereço do Estabelecimento">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($establishmentAddressSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('establishmentAddress.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="col-xs-3 col-sm-2 no-padding pull-left" id="displayDelete" style="display: none;">
                        <a class="btn btn-warning btn-flat" href="{{ route('establishmentAddress.massDestroy') }}" id="deleteSelected"
                           title="Exclusão de endereço selecionado">
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
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="establishmentAddress[id][]"
                                               value="{{ $address->id }}"/>
                                    </td>
                                    <td>
                                        {{ $address->establishment->corporate_name }}
                                    </td>
                                    <td>
                                        {{ $address->street_name }}
                                    </td>
                                    <td>
                                        {{ $address->building_number }}
                                    </td>
                                    <td>
                                        {{ formatZipCode($address->zip_code) }}
                                    </td>
                                    <td>
                                        {{ $address->city->name_visible }}
                                    </td>
                                    <td>
                                        {{ $address->city->state->name_visible }}
                                    </td>
                                    <td>
                                        {{ $address->establishments_phone[0]->name }}
                                    </td>
                                    <td>
                                        {{ $address->establishments_phone[0]->phone }}
                                    </td>
                                    <td>
                                        {{ ($address->establishments_phone[0]->whatsapp) ? 'Sim' : 'Não' }}
                                    </td>
                                    <td>
                                        {{ $address->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <th>
                                        {{ $address->updated_at->format('d/m/Y - H:i') }}
                                    </th>
                                    <td class="col-actions">
                                        <a href="{{ route('establishmentAddress.edit', $address) }}" class="action-edit"
                                           title="Editar Endereço"><span class="glyphicon glyphicon-pencil"></span></a>

                                        <a href="{{ route('establishmentAddress.destroy', $address) }}"
                                           class="action-delete" title="Apagar Endereço"><span
                                                    class="glyphicon glyphicon-trash"></span></a>

                                        <a href="{{ route('establishmentAddress.show', $address) }}" class="action-show"
                                           title="Visualizar Endereço"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    Nenhum endereço do
                                    estabelecimento {{ (!empty($establishmentAddressSearch)) ? 'encontrado.' : 'cadastrado.' }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($establishmentsAddress->hasPages())
                    <div class="box-footer clearfix">
                        {{ $establishmentsAddress->appends(['q' => $establishmentAddressSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/establishmentAddress.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection
