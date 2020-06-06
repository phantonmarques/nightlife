@extends('vendor.emails.default')

@section("title")
    Parabéns, <strong>{{isset($object->name) ? $object->name : 'Nightlife'}}</strong>
@endsection


@section("content")
    <div style="padding-bottom:15px;">
        Sua conta foi criada com sucesso, confirme seu e-mail para ativar sua conta clicando no link abaixo:
    </div>
    <div style="padding-bottom:1px;text-align:center;">
         <strong><a class="btn-env"
                    href="{{ route('confirm.account', ['token' => $object->token]) }}">Confirmar E-mail</a></strong>
    </div>
    <div style="padding-bottom:1px;">
            Usuário: <strong>{{isset($object->login) ? $object->login : ''}}</strong>
    </div>
    @if (isset($object->password))
        <div style="padding-bottom:0px;">
            Senha: <strong>{{ $object->password }}</strong>
        </div>
    @endif
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Mail/mail.css') }}"/>
@endsection