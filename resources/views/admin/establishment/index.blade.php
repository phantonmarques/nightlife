@extends('adminlte::page')
@section('title', 'Estabelecimentos · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('establishment.index') }}">Estabelecimentos</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-1 no-padding">
                        <a class="btn btn-success btn-flat" href="{{ route('establishment.create')  }}"
                           title="Cadastrar novo estabelecimento">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Estabelecimento
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        {{ Form::open(['method' => 'GET']) }}
                        <div class="input-group">
                        @if (empty($establishmentsSearch))
                            {{ $establishmentsSearch = '' }}
                        @endif
                        <!-- SEARCH PESQUISA INPUT -->
                        {{ Form::text('s', $establishmentsSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4']) }}
                        <!-- FIM SEARCH PESQUISA -->

                            <!-- INICIO CASO ESTEJA EM "DESABILITADOS" -->
                        @if (isset($_GET['d']))
                            {{ Form::hidden('d', 1, array('id' => 'd')) }}
                        @endif
                        <!-- FIM -->
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat" title="Buscar Estabelecimento">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (!empty($establishmentsSearch))
                                    <a title="Limpar busca" class="btn btn-default"
                                       href="{{ route('establishment.index') }}">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="box-title col-xs-1 col-sm-1 pull-right">
                        <div class="input-group">
                            @if (!isset($_GET['d']))
                                {{ Form::open(['method' => 'GET']) }}
                                <button type="submit" class="btn btn-danger btn-flat"
                                        title="Visualizar Estabelecimentos Desativados">
                                    Desativados
                                </button>
                                {{ Form::hidden('d', 1, array('id' => 'd')) }}
                                {{ Form::close() }}
                            @else
                                <a href="{{ route("establishment.index") }}" class="btn btn-success btn-flat"
                                   title="Visualizar Estabelecimentos Ativos">
                                    Ativos
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-1 col-sm-2 no-padding separate-2" id="displayDelete" style="display:none;">
                        <a class="btn btn-warning btn-flat" href="{{ route('establishment.massDestroy') }}" id="deleteSelected" data-title="establishment"
                           title="Exclusão de estabelecimento selecionado">
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
                            <th>Nome Estabelecimento</th>
                            <th>Inscrição Estadual</th>
                            <th>CNPJ</th>
                            <th>Tipo Licença</th>
                            <th>Situação Empresa</th>
                            <th>Categoria</th>
                            <th>Ritmos Musicais</th>
                            <th>E-mail</th>
                            <th>Data de criação</th>
                            @if (isset($_GET['d']))
                                <th>Data de cancelamento</th>
                            @else
                                <th>Data de atualização</th>
                            @endif
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($establishments) && sizeof($establishments) > 0)
                            @foreach($establishments as $establishment)
                                <tr>
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="establishment[id][]"
                                               value="{{ $establishment->id }}"/>
                                    </td>
                                    <td>
                                        {{ $establishment->corporate_name }}
                                    </td>
                                    <td>
                                        {{ $establishment->state_registration }}
                                    </td>
                                    <td>
                                        {{ formatCnpjCpf($establishment->users->cpf_cnpj) }}
                                    </td>
                                    <td>
                                        {{ $establishment->type_license === 'f' ? 'Full' : 'Básica' }}
                                    </td>
                                    <td>
                                        {{ $establishment->status ? 'Ativa' : 'Inativa' }}
                                    </td>
                                    <td>
                                        @foreach($establishment->establishments_category()->pluck('name') as $category)
                                            <span class="label label-success">{{ $category }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($establishment->establishments_rhythm()->pluck('name') as $rhythm)
                                            <span class="label label-info">{{ $rhythm }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $establishment->users->email }}
                                    </td>
                                    <td>
                                        {{ $establishment->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td>
                                        {{ $establishment->updated_at->format('d/m/Y - H:i') }}
                                    </td>
                                    <td class="col-actions">
                                        <a href="{{ route('establishment.edit', $establishment) }}" class="action-edit"
                                           title="Editar {{ $establishment->corporate_name }}"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        @if (!isset($_GET['d']))
                                            <a href="{{ route('establishment.destroy', $establishment) }}"
                                               title="Desativar {{ $establishment->corporate_name }}"
                                               class="action-delete" data-title="establishment"><span
                                                        class="glyphicon glyphicon-trash"></span></a>
                                        @endif
                                        <a href="{{ route('establishment.show', $establishment) }}"
                                           title="Visualizar {{ $establishment->corporate_name }}"
                                           class="action-show"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" class="text-center">
                                    @if (isset($_GET['d']))
                                        Nenhum estabelecimento
                                        desativado{{ (!empty($establishmentsSearch)) ? ' encontrado.' : '.' }}
                                    @else
                                        Nenhum
                                        estabelecimento {{ (!empty($establishmentsSearch)) ? 'encontrado.' : 'cadastrado.' }}
                                    @endif
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                @if ($establishments->hasPages())
                    <div class="box-footer clearfix">
                        {{ $establishments->appends(['q' => $establishmentsSearch])->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection
