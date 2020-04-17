<?php $__env->startSection('title', 'Estabelecimentos · '); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Estabelecimentos</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <?php echo e(Breadcrumbs::render(Route::currentRouteName(), $establishments)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="box-title col-xs-6 no-padding">
                        <a class="btn btn-success btn-flat" href="<?php echo e(route('establishment.create')); ?>">
                            <i class="fas fa-sm fa-plus"></i>&nbsp;&nbsp;Novo Estabelecimento
                        </a>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3">
                        <div class="input-group pull-right">
                            <?php if(!isset($_GET['d'])): ?>
                                <?php echo e(Form::open(['method' => 'GET'])); ?>

                                <button type="submit" class="btn btn-danger btn-flat">
                                    Desativados
                                </button>
                                <?php echo e(Form::hidden('d', 1, array('id' => 'd'))); ?>

                                <?php echo e(Form::close()); ?>

                            <?php else: ?>
                                <a href="<?php echo e(route("establishment.index")); ?>" class="btn btn-success btn-flat">
                                    Ativos
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="box-title col-xs-6 col-sm-3 no-padding pull-right">
                        <?php echo e(Form::open(['method' => 'GET'])); ?>

                        <div class="input-group">
                        <?php if(empty($establishmentsSearch)): ?>
                            <?php echo e($establishmentsSearch = ''); ?>

                        <?php endif; ?>
                        <!-- SEARCH PESQUISA INPUT -->
                        <?php echo e(Form::text('s', $establishmentsSearch, ['placeholder' => 'Pesquisar', 'class' => 'form-control col-md-4'])); ?>

                        <!-- FIM SEARCH PESQUISA -->

                            <!-- INICIO CASO ESTEJA EM "DESABILITADOS" -->
                        <?php if(isset($_GET['d'])): ?>
                            <?php echo e(Form::hidden('d', 1, array('id' => 'd'))); ?>

                        <?php endif; ?>
                        <!-- FIM -->
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-flat">
                                    <i class="fas fa-search"></i>
                                </button>
                                <?php if(!empty($establishmentsSearch)): ?>
                                    <a title="Limpar" class="btn btn-default"
                                       href="<?php echo e(route('establishment.index')); ?>">
                                        <i class="fas fa-backspace"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover dataTable table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">
                                <input class="icheck check-all" type="checkbox" />
                            </th>
                            <th>Razão Social</th>
                            <th>Inscrição Estadual</th>
                            <th>CNPJ</th>
                            <th>Tipo Licença</th>
                            <th>Situação Empresa</th>
                            <th>Categoria</th>
                            <th>Ritmos Musicais</th>
                            <th>E-mail</th>
                            <th>Data de criação</th>
                            <?php if(isset($_GET['d'])): ?>
                                <th>Data de cancelamento</th>
                            <?php else: ?>
                                <th>Data de atualização</th>
                            <?php endif; ?>
                            <th class="col-actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($establishments) && sizeof($establishments) > 0): ?>
                            <?php $__currentLoopData = $establishments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $establishment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">
                                        <input class="icheck" type="checkbox" name="establishment[id][]" value="<?php echo e($establishment->id); ?>" />
                                    </td>
                                    <td>
                                        <?php echo e($establishment->corporate_name); ?>

                                    </td>
                                    <td>
                                        <?php echo e($establishment->state_registration); ?>

                                    </td>
                                    <td>
                                        <?php echo e(formatCnpjCpf($establishment->users->cpf_cnpj)); ?>

                                    </td>
                                    <td>
                                        <?php echo e($establishment->type_license === 'f' ? 'Full' : 'Básica'); ?>

                                    </td>
                                    <td>
                                        <?php echo e($establishment->status ? 'Ativa' : 'Inativa'); ?>

                                    </td>
                                    <td>
                                        <?php $__currentLoopData = $establishment->establishments_category()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="label label-success"><?php echo e($category); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <?php $__currentLoopData = $establishment->establishments_rhythm()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rhythm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="label label-info"><?php echo e($rhythm); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <?php echo e($establishment->users->email); ?>

                                    </td>
                                    <td>
                                        <?php echo e($establishment->created_at->format('d/m/Y - H:i')); ?>

                                    </td>
                                    <td>
                                        <?php echo e($establishment->updated_at->format('d/m/Y - H:i')); ?>

                                    </td>
                                    <td class="col-actions">
                                        <a href="<?php echo e(route('establishment.edit', $establishment)); ?>" class="action-edit"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                        <?php if(!isset($_GET['d'])): ?>
                                            <a href="<?php echo e(route('establishment.destroy', $establishment)); ?>"
                                               class="action-delete"><span class="glyphicon glyphicon-trash"
                                                                           onsubmit="confirm('Tem certeza?')"></span></a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('establishment.show', $establishment)); ?>" class="action-show"><span
                                                    class="glyphicon glyphicon-info-sign"></span></a>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="100%" class="text-center">
                                    <?php if(isset($_GET['d'])): ?>
                                        Nenhum estabelecimento desativado
                                    <?php else: ?>
                                        Nenhum estabelecimento cadastrado
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($establishments->hasPages()): ?>
                    <div class="box-footer clearfix">
                        <?php echo e($establishments->appends(['q' => $establishmentsSearch])->onEachSide(2)->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php echo $__env->make('vendor/flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/global/js/general.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/Global/css/general.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/admin/establishment/index.blade.php ENDPATH**/ ?>