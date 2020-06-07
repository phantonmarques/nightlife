@extends('vendor.emails.default')

@section("title")
    Olá <strong>{{ isset($object->name) ? $object->name : 'Nightlife' }}, temos um lembrete!</strong>
@endsection


@section("content")
    <div style="padding-bottom:15px;">
        O  evento {{ isset($object->event) ? $object->event : 'Nightlife' }}
        ({{ isset($object->date) ? formatDate($object->date) : '01/01/2020'}} )
        {{ isset($object->type) ? $object->type : 'que curtiu' }} está bem próximo, falta apenas {{ isset($object->day) ? $object->day : '1 dia.' }}.
    </div>
    <div style="padding-bottom:1px;text-align:center;">
        <img src="{{isset($object->cover_path) ? $object->cover_path : 'https://imgsapp.em.com.br/app/noticia_127983242361/2017/08/02/888740/20170802153843543506u.jpg'}}" />
    </div>
@endsection
