<?php $__env->startSection('title', 'Criar Estabelecimento'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="">Inicio</a></li>
        <li><a href="">Criar Usuário</a></li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="box">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Novo Estabelecimento</h3>
            </div>
            <form method="POST" action="">
                <?php echo csrf_field(); ?>

                <div class="box-body">
                    <div class="form-group">
                        <!--
                         'name', 'email', 'password', 'email_verified_at','login', 'city_id', 'state_id', 'type_user', 'ddd1',
        'phone_1', 'ddd2', 'phone_2','remember_token'
                         -->
                        <label for="razaoSocial">Razão Social</label>
                        <input type="name" class="form-control" id="razaoSocial" placeholder="Informe a razão social do estabelecimento.">
                    </div>
                    <div class="form-group">
                        <label for="nomeFantasia">Nome Fantasia</label>
                        <input type="name" class="form-control" id="nomeFantasia" placeholder="Informe nome fantasia do estabelecimento.">
                    </div>
                    <div class="form-group">
                        <label for="emailEstabelecimento">E-mail</label>
                        <input type="email" class="form-control" id="emailEstabelecimento" placeholder="Informe email do estabelecimento.">
                    </div>
                    <div class="form-group">
                        <label for="loginEstabelecimento">Login</label>
                        <input type="name" class="form-control" id="loginEstabelecimento" placeholder="Informe um usuário para o estabelecimento.">
                    </div>
                    <div class="form-group">
                        <label for="senhaEstabelecimento">Senha</label>
                        <input type="password" class="form-control" id="senhaEstabelecimento" placeholder="Informe uma senha para o estabelecimento.">
                    </div>
                    <label for="">Tipo Conta</label>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="tipoConta" value="basica" checked>
                                </span>
                                <input type="text" disabled class="form-control" value="Conta Básica">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="tipoConta" value="full">
                                </span>
                                <input type="text" disabled class="form-control" value="Conta Full">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado">
                            <option>Selecione</option>
                            <option value="1">Estado 1</option>
                            <option>Estado 2</option>
                            <option>Estado 3</option>
                            <option>Estado 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <select class="form-control" id="cidade">
                            <option>Selecione</option>
                            <option value="1">Cidade 1</option>
                            <option>Cidade 2</option>
                            <option>Cidade 3</option>
                            <option>Cidade 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telefone Contato:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="">
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PhantonM\Documents\Projetos\Php\nightlife\resources\views/paineladmin/admin/establishment/criar-estabelecimento.blade.php ENDPATH**/ ?>