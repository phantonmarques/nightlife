@extends('vendor.emails.default')

@section("title")
    <strong>Olá {{isset($object->name) ? $object->name : 'Nightlife'}}, </strong>
@endsection


@section("content")
    <div style="padding-bottom:15px;">
        {{ $object->msg }}
    </div>
    @if (isset($object->link))
        <div style="padding-bottom:1px;text-align:center;">
            <strong><a class="btn-env"
                       href="{{ $object->link }}">Acessar Nightlife</a></strong>
        </div>
    @endif
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Mail/mail.css') }}"/>
@endsection