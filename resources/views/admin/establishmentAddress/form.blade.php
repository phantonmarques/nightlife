@extends('adminlte::page')
@section('title', (isset($establishmentAddress->id) ? 'Editar ' : 'Criar ') . ' Endereço Estabelecimento · ')


@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('establishmentAddress.index') }}">Endereços Estabelecimento</a></li>
        <li>
            <a href="{{ (isset($establishmentAddress->id) ? route('establishmentAddress.edit', $establishmentAddress) : route('establishmentAddress.create')) }}">{{ (isset($establishmentAddress->id) ? 'Editar ' : 'Criar ') }}
                Endereço Estabelecimento
            </a>
        </li>
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
                {!! csrf_field() !!}

                <div class="box-header with-border">
                    <h3 class="box-title">Informações de Endereço</h3>
                </div>

                <div class="box-body">

                    {{ Form::label('zip_code','CEP ') }} <span class="span-required">*</span>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ Form::text('zip_code' , (isset($establishmentAddress->id) ? strlen($establishmentAddress->zip_code) === 7 ? '0'.$establishmentAddress->zip_code : $establishmentAddress->zip_code : ''), ['placeholder' => 'Informe cep do endereço do estabelecimento.', 'class' => 'form-control cep', 'onkeypress' => 'return onlyNumbers(event)']) }}
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-info" onclick="searchZipCode('click')">Buscar</button>
                        </div>
                    </div>

                    <br>

                    <div id="addressEstablishment" style="display: none"> <!-- style="display: none" -->
                        <div class="row">
                            <div class="col-lg-6">
                                {{ Form::label('street_name','Endereço ') }} <span class="span-required">*</span>
                                {{ Form::text('street_name' , (isset($establishmentAddress->id) ? $establishmentAddress->street_name : ''), ['id' => 'street_name', 'placeholder' => 'Informe endereço do estabelecimento.', 'class' => 'form-control']) }}
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
                                {{ Form::select('state_id', $states, (isset($establishmentAddress->id) ? $establishmentAddress->city->state->id : ''), ['class' => 'form-control', 'id' => 'state_id', 'onchange' => 'searchCity()']) }}
                            </div>
                            <div class="col-lg-6">
                                {{ Form::label('city_id','Cidade') }} <span class="span-required">*</span>
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

                    @if ($errors->has('zip_code'))
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('zip_code') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('street_name'))
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('street_name') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('building_number'))
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('building_number') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('complement'))
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('complement') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('neighborhood'))
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('neighborhood') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('city_id'))
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('city_id') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-header with-border">
                    <h3 class="box-title">Informações de Endereço</h3>
                </div>

                <div class="box-body" id="info-contact">
                    <div class="row">
                        <div class="col-lg-3">
                            {{ Form::label('name','Nome Contato') }} <span class="span-required">*</span>
                            {{ Form::text('contact[0][name]' , (isset($establishmentAddress->id) ? $establishmentAddress->establishments_phone[0]->name : ''), ['placeholder' => 'Informe nome do contato.', 'class' => 'form-control']) }}
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
                                {{ Form::text('contact[0][phone]' , (isset($establishmentAddress->id) ? $establishmentAddress->establishments_phone[0]->phone : ''), ['class' => 'form-control phone', 'onkeypress' => 'return onlyNumbers(event)']) }}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            {{ Form::label('Número tem Whatsapp') }} <span class="span-required"></span>
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        {{ Form::checkbox('contact[0][whatsapp]', 1, (isset($establishmentAddress->id)) ? $establishmentAddress->establishments_phone[0]->whatsapp : false, ['id' => 'whatsapp']) }}
                                    </span>
                                {{ Form::label('whatsapp', 'Sim', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        {{ Form::hidden('contContact', isset($establishmentAddress->establishments_phone) ? ($establishmentAddress->establishments_phone->count()) : 1, ['id' => 'contContact']) }}
                    </div>
                    @if ($errors->has('contact.*'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red">{{ $errors->first('contact.*') }}</div>
                            </div>
                        </div>
                    @endif
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
                    @if (isset($establishmentAddress->establishments_phone))
                        @foreach($establishmentAddress->establishments_phone as $key => $contact)
                            @if($key > 0)
                                <div class="row" id="r_name_{{ $key }}">
                                    <br><br>
                                    <div class="col-lg-3">
                                        {{ Form::label('name_' . $key,'Nome Contato ' . $key) }}
                                        {{ Form::text('contact[' . $key . '][name]' , (isset($contact->id) ? $contact->name : ''), ['placeholder' => 'Informe nome do contato.', 'class' => 'form-control', 'id' => 'name_' . $key]) }}
                                    </div>
                                </div>
                                <div class="row" id="r_phone_{{ $key }}">
                                    <br>
                                    <div class="col-lg-2">
                                        {{ Form::label('phone_' . $key,'Telefone ' . $key) }}
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            {{ Form::text('contact[' . $key . '][phone]' , (isset($contact->id) ? $contact->phone : ''), ['class' => 'form-control phone', 'onkeypress' => 'return onlyNumbers(event)', 'id' => 'phone_' . $key]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        {{ Form::label('Número tem Whatsapp') }}
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                {{ Form::checkbox('contact[' . $key . '][whatsapp]', 1 , ($contact->whatsapp) ? 'checked' : false, ['id' => 'whatsapp_' . $key]) }}
                                            </span>
                                            {{ Form::label('whatsapp_' . $key, 'Sim', ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                {{ Form::hidden('uc', url('control/citys') . "/", ['id' => 'url_city']) }}
                {{ Form::hidden('us', url('control/state') . "/", ['id' => 'url_state']) }}

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        {{ link_to_route('establishmentAddress.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
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
