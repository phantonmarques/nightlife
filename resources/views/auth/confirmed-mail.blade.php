@extends('vendor.emails.default')

@section("title")
    <strong>Olá {{isset($object->name) ? $object->name : 'Nightlife'}},</strong>
@endsection


@section("content")
    <div style="padding-bottom:15px;">
        Sua conta foi confirmada com sucesso, clique no link abaixo para entrar em sua conta:
    </div>
    <div style="padding-bottom:1px;text-align:center;">
        <strong><a class="btn-env"
            href="{{ $object->link }}">Acessar Nightlife</a></strong>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Mail/mail.css') }}"/>
@endsection