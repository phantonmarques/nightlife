@extends('adminlte::page')
@section('title', 'Relatórios Estabelecimento · ')

@section('content_header')
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.page') }}">Inicio</a></li>
        <li><a href="{{ route('admin.reports') }}">Relatórios Estabelecimento</a></li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Olá, Bem vindo aos relatórios, [{{ $establishment->corporate_name }}]</h3>
                    <br><br>
                    
                    <div class="form-group">
                  <label>Selecionar o tipo de relatório</label>
                  <select class="form-control">
                    <option value="1">Notas e comentários. - PDF</option>
                    <option value="2">Notas e comentários. - XLS</option>
                  </select>
                  <br>
                 <a href="{{route('admin.pdf')}}" class="btn btn-sm btn-primary btn-flat">Gerar</a>
                </div> <br><br>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Global/css/general.css') }}"/>
@endsection
