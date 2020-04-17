<?php $__env->startSection('title', 'Criar Estabelecimento · '); ?>

<?php $__env->startSection('content_header'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Estabelecimento</a></li>
        <li><a href="#">Criar Estabelecimento</a></li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo e('Cadastrar novo estabelecimento'); ?></h3>
                    <h6 align="right" style="color:red">* Campos obrigatórios</h6>
                </div>

                <?php echo e(Form::model($establishment, $formOptions)); ?>

                <?php echo csrf_field(); ?>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            <?php echo e(Form::label('corporate_name','Razão Social ')); ?> <span class="span-required">*</span>
                            <?php echo e(Form::text('corporate_name' , (isset($establishment->id) ? $establishment->corporate_name : ''), ['placeholder' => 'Informe a razão social', 'class' => 'form-control required'])); ?>

                        </div>
                    </div>

                    <?php if($errors->has('corporate_name')): ?>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red"><?php echo e($errors->first('corporate_name')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <br>

                    <div class="row">
                        <div class="col-md-3">
                            <?php echo e(Form::label('state_registration','Inscrição Estadual ')); ?> <span class="span-required">*</span>
                            <?php echo e(Form::text('state_registration' , (isset($establishment->id) ? $establishment->state_registration : ''), ['placeholder' => 'Informe a inscrição estadual', 'class' => 'form-control required', 'onkeypress' => 'return onlyNumbers(event)'])); ?>

                        </div>
                    </div>

                    <?php if($errors->has('state_registration')): ?>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red"><?php echo e($errors->first('state_registration')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo e(Form::label('type_license','Tipo Conta ')); ?> <span class="span-required">*</span>
                        </div>
                        <div class="col-md-4">
                            <?php echo e(Form::label('category','Categoria Estabelecimento ')); ?> <span class="span-required">*</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    &nbsp;<?php echo e(Form::radio('type_license', 'b', (isset($establishment->type_license) && $establishment->type_license === 'b') ? true : false, [ 'id' => 'basicAccount'])); ?>

                                </span>
                                <?php echo e(Form::label('basicAccount','Plano Basico', ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <?php echo e(Form::radio('type_license', 'f', (isset($establishment->type_license) && $establishment->type_license === 'f') ? true : false, [  'id' => 'fullAccount' ])); ?>

                                </span>
                                <?php echo e(Form::label('fullAccount','Plano Completo', ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php echo e(Form::select('category', $categorys, isset($establishment->establishments_category) ? $establishment->establishments_category : null, array('class' => 'form-control'))); ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php if($errors->has('type_license')): ?>
                                <div class="text-red"><?php echo e($errors->first('type_license')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <?php if($errors->has('category')): ?>
                                <div class="text-red"><?php echo e($errors->first('category')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(Form::label('rhythm','Ritmos Musicais ')); ?> <span class="span-required">*</span>
                            <?php echo e(Form::select('rhythm', $rhythms, isset($establishment->establishments_rhythm) ? $establishment->establishments_rhythm : null, array('multiple' => 'multiple', 'name' => 'rhythm[]', 'class' => 'form-control select2'))); ?>

                        </div>
                    </div>

                    <?php if($errors->has('rhythm')): ?>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-red"><?php echo e($errors->first('rhythm')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($establishment->status) && $establishment->status === 0): ?>
                        <br>

                        <div class="row">
                            <div class="col-md-5">
                                <?php echo e(Form::label('status','Status Estabelecimento ')); ?> <span
                                        class="span-required">*</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1">
                                <?php echo e(Form::select('status', [1 => 'Ativo', 0 => 'Inativo'], (isset($establishment->status) && $establishment->status) ? 1 : 0, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    <?php else: ?>
                        <?php echo e(Form::hidden('status', 1, array('id' => 'status'))); ?>

                    <?php endif; ?>


                    <?php if($errors->has('status')): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red"><?php echo e($errors->first('status')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="lead">Dados Usuário a Vincular</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php echo e(Form::label('Nome Usuário')); ?> <span class="span-required">*</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <?php if(sizeof($users) === 0 && !isset($establishment->users)): ?>
                                        <span class="span-required"><?php echo e('Nenhum usuário do tipo ESTABELECIMENTO cadastrado, faça o cadastro e tente novamente!'); ?></span>
                                    <?php else: ?>
                                        <select class="form-control" name="user_id" id="user_id"
                                                onchange="javascript: selectUser(this.value)">
                                            <option value="">---- SELECIONE USUÁRIO ----</option>
                                            <?php if(isset($establishment->users)): ?>
                                                <option value="<?php echo e($establishment->users->id); ?>" selected><?php echo e($establishment->users->name); ?></option>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(sizeof($users) > 0 || isset($establishment->users)): ?>
                        <div class="row" id="divEmail" style="display:none">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php echo e(Form::label('E-mail Usuário')); ?> <span class="span-required">*</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="userEmail" id="userEmail" disabled>
                                            <?php if(isset($establishment->users)): ?>
                                                <option value="<?php echo e($establishment->users->id); ?>" selected><?php echo e($establishment->users->email); ?></option>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->email); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divCnpj" style="display:none">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php echo e(Form::label('CNPJ')); ?> <span class="span-required">*</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="userCNPJ" id="userCNPJ" disabled>
                                            <?php if(isset($establishment->users)): ?>
                                                <option value="<?php echo e($establishment->users->id); ?>"
                                                        selected><?php echo e(formatCnpjCpf($establishment->users->cpf_cnpj)); ?></option>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>"><?php echo e(formatCnpjCpf($user->cpf_cnpj)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php endif; ?>

                    <?php if($errors->has('status')): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-red"><?php echo e($errors->first('status')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($message = Session::get('error')): ?>
                    <br>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="text-red"><?php echo e($message); ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="box-footer">
                    <div class="col-lg-1" style="margin-left: 83%;">
                        <?php echo e(link_to_route('establishment.index', $title = 'Voltar', '', ['class' => 'btn btn-block btn-danger'])); ?>

                    </div>
                    <div class="col-md-1">
                        <?php echo e(Form::submit('Salvar', ['class' => 'btn btn-block btn-success'])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/admin/js/establishment.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/Global/css/general.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/admin/establishment/form.blade.php ENDPATH**/ ?>