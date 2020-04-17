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
                                'value' => ($establishment->status) ? 'Ativo' : 'Inativa'
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
                                'label' => ($establishment->status) ? 'Ultima Atualização' : 'Data Cancelamento',
                                'value' => $establishment->updated_at->format('d/m/Y - H:i')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h3 class="lead">Usuário Vínculado</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Nome',
                                'value' => $establishment->users->name
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'CNPJ',
                                'value' => formatCnpjCpf($establishment->users->cpf_cnpj)
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'E-mail',
                                'value' => $establishment->users->email
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Tipo de Usuário',
                                'value' => typeUserDescription($establishment->users->type_user)
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Cidade',
                                'value' => $establishment->users->city->name_visible
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $__env->make('adminlte::form.input.static', [
                                'label' => 'Estado',
                                'value' => $establishment->users->city->state->name_visible
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <?php if(sizeof($establishment->establishments_category)>0): ?>
                        <div class="col-md-12">
                            <h3 class="lead">Categoria Estabelecimento</h3>
                        </div>

                        <?php $__currentLoopData = $establishment->establishments_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo $__env->make('adminlte::form.input.static', [
                                        'label' => 'Categoria',
                                        'value' => $category->name
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $__env->make('adminlte::form.input.static', [
                                        'label' => 'Data de Criação Categoria',
                                        'value' => $category->created_at->format('d/m/Y - H:i')
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if(sizeof($establishment->establishments_rhythm)>0): ?>
                        <div class="col-md-12">
                            <h3 class="lead">Ritmos Musicais</h3>
                        </div>

                        <?php $__currentLoopData = $establishment->establishments_rhythm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rhythm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo $__env->make('adminlte::form.input.static', [
                                        'label' => 'Ritmo Musical ' . ($key+1),
                                        'value' => $rhythm->name
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $__env->make('adminlte::form.input.static', [
                                        'label' => 'Data de Criação Ritmo',
                                        'value' => $rhythm->created_at->format('d/m/Y - H:i')
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

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