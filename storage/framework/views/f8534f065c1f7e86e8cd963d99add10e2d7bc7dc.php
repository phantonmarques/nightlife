<?php $__env->startSection('title', 'Estabelecimento · Visualização'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Estabelecimento</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <?php echo e(Breadcrumbs::render(Route::currentRouteName(), $establishment)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações do estabelecimento</h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Razão Social',
                                'value' => $establishment->corporate_name
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Inscrição Estadual',
                                'value' => $establishment->state_registration
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Tipo de Licença',
                                'value' => ($establishment->type_license === 'f') ? 'Completa' : 'Básica'
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Situação do Estabelecimento',
                                'value' => ($establishment->status === 1) ? 'Ativo' : 'Inativa'
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Data de Criação',
                                'value' => $establishment->created_at->format('d/m/Y - H:i')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Ultima Atualização',
                                'value' => $establishment->updated_at->format('d/m/Y - H:i')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h4 class="lead">Usuário Vínculado</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Nome',
                                'value' => $userEstablishment->name
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'CNPJ',
                                'value' => $userEstablishment->cpf_cnpj
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'E-mail',
                                'value' => $userEstablishment->email
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Login',
                                'value' => $userEstablishment->login
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Tipo de Usuário',
                                'value' => $typeUser
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $cityUser->name_visible
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $stateUser->name_visible
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>


                </div>

                <div class="box-footer">
                    <div class="col-md-1">
                        <?php echo e(link_to_route('establishment.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger'])); ?>

                    </div>
                    <div class="col-md-1">
                        <?php echo e(link_to_route('establishment.edit', $title = 'Editar', $establishment, ['class' => 'btn btn-block btn-primary'])); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/admin/establishment/show.blade.php ENDPATH**/ ?>