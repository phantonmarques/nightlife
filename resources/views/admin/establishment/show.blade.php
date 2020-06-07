@extends('adminlte::page')
@section('title', 'Estabelecimento · Visualização')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('establishment.index') }}">Estabelecimentos</a></li>
        <li><a href="{{ route('establishment.show', $establishment) }}"> Visualizar estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do estabelecimento</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Razão Social',
                                'value' => $establishment->company_name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome do estabelecimento',
                                'value' => $establishment->corporate_name
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Inscrição Estadual',
                                'value' => $establishment->state_registration
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo de Licença',
                                'value' => ($establishment->type_license === 'f') ? 'Completa' : 'Básica'
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Situação do Estabelecimento',
                                'value' => ($establishment->status) ? 'Ativo' : 'Inativa'
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $establishment->created_at->format('d/m/Y - H:i')
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => ($establishment->status) ? 'Ultima Atualização' : 'Data Cancelamento',
                                'value' => $establishment->updated_at->format('d/m/Y - H:i')
                            ])
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h3 class="lead">Usuário Vínculado</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Nome',
                                'value' => $establishment->users->name
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'CNPJ',
                                'value' => formatCnpjCpf($establishment->users->cpf_cnpj)
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'E-mail',
                                'value' => $establishment->users->email
                            ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Tipo de Usuário',
                                'value' => typeUserDescription($establishment->users->type_user)
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $establishment->users->city->name_visible
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $establishment->users->city->state->name_visible
                            ])
                        </div>
                    </div>

                    @if(sizeof($establishment->establishments_category)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Categoria Estabelecimento</h3>
                        </div>

                        @foreach($establishment->establishments_category as $key => $category)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Categoria',
                                        'value' => $category->name
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Data de Criação Categoria',
                                        'value' => $category->created_at->format('d/m/Y - H:i')
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(sizeof($establishment->establishments_rhythm)>0)
                        <div class="col-md-12">
                            <h3 class="lead">Ritmos Musicais</h3>
                        </div>

                        @foreach($establishment->establishments_rhythm as $key => $rhythm)
                            <div class="row">
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Ritmo Musical ' . ($key+1),
                                        'value' => $rhythm->name
                                    ])
                                </div>
                                <div class="col-md-4">
                                    @include('adminlte::form.input.static', [
                                        'label' => 'Data de Criação Ritmo',
                                        'value' => $rhythm->created_at->format('d/m/Y - H:i')
                                    ])
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        {{ link_to_route('establishment.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ link_to_route('establishment.edit', $title = 'Editar', $establishment, ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
