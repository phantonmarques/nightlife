@extends('adminlte::page')
@section('title', (isset($event->id) ? 'Editar ' : 'Criar ') . 'Evento · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('event.index') }}">Eventos</a></li>
        <li>
            <a href="{{ (isset($event->id) ? route('event.edit', $event) : route('event.create')) }}">{{ (isset($event->id) ? 'Editar ' : 'Criar ') }}
                Evento
            </a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ (isset($event->id) ? 'Editar Evento' : 'Cadastrar nova Evento') }}</h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                {{ Form::model($event, $formOptions) }}
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('name','Nome') }} <span class="span-required">*</span>
                            {{ Form::text('name', (isset($event->id) ? $event->name : ''), ['placeholder' => 'Informe nome do evento', 'class' => 'form-control required']) }}
                        </div>
                    </div>

                    @if ($errors->has('name'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('name') }}</div>
                            </div>
                        </div>
                    @endif
                    <br>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="custom-file">
                                @if (!empty($event->cover_path))
                                    <img src="{{ asset("storage/" . $event->cover_path) }}" alt="{{ $event->name }}"
                                         style="max-width: 30vh;">
                                @endif
                                <br><br>
                            </div>

                            <div class="input-file-container">
                                {{ Form::file('cover_path', ['class' => 'input-file']) }}
                                {{ Form::label('cover_path', (!empty($event->cover_path) ? 'Mudar ' : '') . 'Capa Evento', ['class' => 'input-file-trigger']) }}
                            </div>
                            <p class="file-return"></p>
                        </div>
                    </div>
                    <br>

                    @if ($errors->has('cover_path'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('cover_path') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('datepicker', 'Data Evento') }} <span class="span-required">*</span>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {{ Form::text('date', '', ['class' => 'form-control pull-right', 'id' => 'datepicker' , 'onChange' => 'FillDate(this.value)'] ) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::hidden('date_event', (isset($event->id) ? formatDate($event->date_event) : ''), ['id' => 'date_event']) !!}

                    @if ($errors->has('date_event'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('date_event') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row">
                        <div class="col-md-5">
                            {{ Form::label('establishment_address_id','Endereço do Evento') }} <span
                                    class="span-required">*</span>

                            <select name="establishment_address_id" class="form-control">
                                <option value="">---- Selecione ----</option>
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}" {{ (isset($event->id) ? (($event->establishment_address_id === $address->id) ? 'selected' : '') : '') }} >{{ $address->street_name . " " . $address->building_number . " (" .  formatZipCode($address->zip_code) . ")" }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>

                    @if ($errors->has('establishment_address_id'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('cover_path') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-5">
                            {{ Form::label('price','Preço Evento') }} <span class="span-required">*</span>
                            {{ Form::text('price', (isset($event->id) ? number_format($event->price, 2, ',', '.') : ''), ['placeholder' => 'Informe preço do evento', 'class' => 'form-control money', 'onkeypress' => 'return onlyNumbers(event)']) }}
                        </div>
                    </div>

                    <br>

                    @if ($errors->has('price'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('price') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('start_time','Hora início evento') }} <span
                                        class="span-required">*</span>

                                <div class="input-group">
                                    {{ Form::time('start_time', (isset($event->id) ? formatHour($event->start_time) : '')) }}
                                    <i class="far fa-clock time_style"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('end_time','Hora início evento') }} <span
                                        class="span-required">*</span>

                                <div class="input-group">
                                    {{ Form::time('end_time', (isset($event->id) ? formatHour($event->end_time) : '')) }}
                                    <i class="far fa-clock time_style"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('start_time'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('start_time') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('end_time'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('start_time') }}</div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::label('description','Descrição Evento') }} <span class="span-required">*</span>
                            {!! Form::textarea('description', (isset($event->id) ? $event->description : ''), ['class'=>'form-control', 'id' => 'description']) !!}
                        </div>
                    </div>

                    @if ($errors->has('description'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $errors->first('description') }}</div>
                            </div>
                        </div>
                    @endif

                    {!! Form::hidden('status', 1) !!}

                    @if ($message = Session::get('error'))
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red">{{ $message }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="box-footer">
                    <div class="col-lg-2 pull-right">
                        {{ Form::submit('Salvar', ['class' => 'btn btn-block btn-success']) }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        {{ link_to_route('event.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/Global/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/Global/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/event.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/event.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/jquery.datetimepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/jquery-ui.css') }}"/>
@endsection