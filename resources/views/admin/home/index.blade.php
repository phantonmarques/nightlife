@extends('adminlte::page')

@section('title', 'Nightlife Admin')

@section('content_header')
<div class="container">
    <!-- Content Header (Page header) -->
    <h1 text-aling="center">
      Bem vindo ao painel administrador!
    </h1>
    <br>
    <div class="col-md-5">
        <div class="callout callout-info">
            <h4><i class="icon fa fa-info"></i> Atualizações </h4>
            <p>Aqui terá atualizações.</p>
        </div>
    </div>
    <div class="col-md-5">
        <div class="callout callout-danger">
        <h4><i class="fa fa-fw fa-times"></i> Importante!</h4>
          <p>Informações importantes aqui.</p>
        </div>
    </div>
</div>    
          <br>  
<div class="container">
    <div class="col-md-5 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-volume-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Ritmo musical mais procurado essa semana</span>
              <span class="info-box-number">O RITMO</span>
            </div>
            <!-- /.info-box-content -->
        </div>
          <!-- /.info-box -->
    </div>
    <div class="col-md-5 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Eventos feitos</span>
            <span class="info-box-number">NUMERO DOS EVENTOS</span>
            </div>
  <!-- /.info-box-content -->
        </div>
<!-- /.info-box -->
    </div>
    <div class="col-md-5 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-search"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Categoria mais procurada essa semana</span>
            <span class="info-box-number">A CATEGORIA</span>
            </div>
  <!-- /.info-box-content -->
        </div>
<!-- /.info-box -->
    </div>
    <div class="col-md-5 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Novos usuários essa semana</span>
            <span class="info-box-number">QUANTIDADE</span>
            </div>
  <!-- /.info-box-content -->
        </div>
<!-- /.info-box -->
    </div>
</div>
@endsection


