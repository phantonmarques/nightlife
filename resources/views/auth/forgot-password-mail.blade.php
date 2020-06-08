@extends('vendor.emails.default')

@section("title")
    <strong>Olá {{ isset($object->name) ? $object->name : 'Nightlife' }},</strong>
@endsection


@section("content")
    <div style="padding-bottom:15px;">
        Esqueceu sua senha? <br>
        Não tem problema, geramos uma nova senha para você acessar, clique no link abaixo e acesse com a nova senha!
    </div>
    <div style="padding-bottom:1px;text-align:center;margin-bottom: 15px;">
        <strong><a style="box-shadow:inset 0px 1px 0px 0px #7a8eb9;background:linear-gradient(to bottom, #637aad 5%, #5972a7 100%);background-color:#637aad;border:1px solid #314179;cursor:pointer;color:#ffffff;font-weight:bold;padding:6px 12px;text-decoration:none;"
            href="{{ $object->link }}">Acessar Nightlife</a></strong>
    </div>
    <div style="padding-bottom:1px;">
            Usuário: <strong>{{ isset($object->login) ? $object->login : '' }}</strong>
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