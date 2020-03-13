@extends('vendor.adminlte.register');

@section('registrar')
    @php
        if (isset($errors) && count($errors)>0){
            echo ($errors->first('login'));
        }
    @endphp

    <div class="form-group has-feedback {{ $errors->has('login') ? 'has-error' : '' }}">
        <input type="text" name="login" class="form-control"
               placeholder="Login">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('login'))
            <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('ddd_main') ? 'has-error' : '' }}">
        <input type="number" name="ddd_main" class="form-control"
               placeholder="ddd_main">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('ddd_main'))
            <span class="help-block">
                            <strong>{{ $errors->first('ddd_main') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('phone_main') ? 'has-error' : '' }}">
        <input type="number" name="phone_main" class="form-control"
               placeholder="phone_main">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('phone_main'))
            <span class="help-block">
                            <strong>{{ $errors->first('phone_main') }}</strong>
            </span>
        @endif
    </div>
    <input type="hidden" name="city" value="1" />
    <input type="hidden" name="state" value="1" />

@endsection
