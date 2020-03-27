@extends('adminlte::page')
@section('title', 'Endereço Estabelecimento · ')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Endereços Estabelecimento</a></li>
        <li><a href="#">Criar Endereço Estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ 'Cadastrar novo endereço Estabelecimento' }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($establishmentAddress, $formOptions) }}

                <div class="box-header with-border">
                    <h3 class="box-title">Informações de Endereço</h3>
                </div>

                <div class="box-body">

                    {{ Form::label('zip_code','CEP ') }} <span class="span-required">*</span>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ Form::text('zip_code' , (isset($establishmentAddress->id) ? $establishmentAddress->zip_code : ''), ['placeholder' => 'Informe cep do endereço do estabelecimento.', 'class' => 'form-control cep', 'onkeypress' => 'return onlyNumbers(event)']) }}
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-info" onclick="searchZipCode('click')">Buscar</button>
                        </div>
                    </div>
                    <br>
                    <div id="addressEstablishment" style="display: none"> <!-- style="display: none" -->
                        <div class="row">
                            <div class="col-lg-6">
                                {{ Form::label('street_name','Número ') }}
                                {{ Form::text('street_name' , (isset($establishmentAddress->id) ? $establishmentAddress->street_name : ''), ['id' => 'street_name', 'placeholder' => 'Informe endereço do estabelecimento.', 'class' => 'form-control', 'onkeypress' => 'return onlyNumbers(event)']) }}
                            </div>
                            <div class="col-lg-2">
                                {{ Form::label('building_number','Número ') }} <span class="span-required">*</span>
                                {{ Form::text('building_number' , (isset($establishmentAddress->id) ? $establishmentAddress->building_number : ''), ['id' => 'building_number', 'placeholder' => 'Informe número do estabelecimento.', 'class' => 'form-control', 'onkeypress' => 'return onlyNumbers(event)']) }}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                {{ Form::label('complement','Complemento') }}
                                {{ Form::text('complement' , (isset($establishmentAddress->id) ? $establishmentAddress->complement : ''), ['id' => 'complement', 'placeholder' => 'Informe complemento do endereço.', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                {{ Form::label('state_id','Estado') }} <span class="span-required">*</span>
                                {{ Form::select('state_id', $states, 0, ['class' => 'form-control', 'id' => 'state_id', 'onchange' => 'searchCity()']) }}
                            </div>
                            <div class="col-lg-6">
                                {{ Form::label('city_id','Cidade') }}
                                {{ Form::select('city_id', array('' => 'Selecione'), 0, ['class' => 'form-control', 'id' => 'city_id']) }}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                {{ Form::label('neighborhood','Bairro') }} <span class="span-required">*</span>
                                {{ Form::text('neighborhood' , (isset($establishmentAddress->id) ? $establishmentAddress->neighborhood : ''), ['id' => 'neighborhood', 'placeholder' => 'Informe bairro do estabelecimento.', 'class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-header with-border">
                    <h3 class="box-title">Informações de Endereço</h3>
                </div>

                <div class="box-body" id="info-contact">
                    <div class="row">
                        <div class="col-lg-3">
                            {{ Form::label('name','Nome Contato') }} <span class="span-required">*</span>
                            {{ Form::text('contact[0][name]' , (isset($establishmentAddress->id) ? $establishmentAddress->name : ''), ['placeholder' => 'Informe nome do contato.', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
                            {{ Form::label('phone','Telefone') }} <span class="span-required">*</span>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                {{ Form::text('contact[0][phone]' , (isset($establishmentAddress->id) ? $establishmentAddress->phone : ''), ['class' => 'form-control phone', 'onkeypress' => 'return onlyNumbers(event)']) }}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            {{ Form::label('Número tem Whatsapp') }}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    {{ Form::checkbox('contact[0][whatsapp]',  '1',  (isset($establishmentAddress->id) ? 'checked' : false), ['id' => 'whatsapp']) }}
                                </span>
                                {{ Form::label('whatsapp', 'Sim', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        {{ Form::hidden('contContact', 1, array('id' => 'contContact')) }}
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-1">
                            {{ Form::label('Add + Contato', '') }}
                            {{ Form::button('+', ['class' => 'form-control', 'id' => 'add']) }}
                        </div>
                        <div class="col-lg-1">
                            {{ Form::label('Del - Contato', '') }}
                            {{ Form::button('-', ['class' => 'form-control', 'id' => 'del']) }}
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="col-lg-1" style="margin-left: 83%;">
                        {{ link_to_route('establishmentAddress.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    <div class="col-md-1">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/admin/js/establishmentAddress.js') }}"></script>
@endsection
