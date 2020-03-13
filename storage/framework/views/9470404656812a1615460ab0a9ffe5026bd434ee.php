;

<?php $__env->startSection('registrar'); ?>
    <?php
        if (isset($errors) && count($errors)>0){
            echo ($errors->first('login'));
        }
    ?>

    <div class="form-group has-feedback <?php echo e($errors->has('login') ? 'has-error' : ''); ?>">
        <input type="text" name="login" class="form-control"
               placeholder="Login">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php if($errors->has('login')): ?>
            <span class="help-block">
                            <strong><?php echo e($errors->first('login')); ?></strong>
            </span>
        <?php endif; ?>
    </div>
    <div class="form-group has-feedback <?php echo e($errors->has('ddd1') ? 'has-error' : ''); ?>">
        <input type="number" name="ddd1" class="form-control"
               placeholder="ddd1">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php if($errors->has('ddd1')): ?>
            <span class="help-block">
                            <strong><?php echo e($errors->first('ddd1')); ?></strong>
            </span>
        <?php endif; ?>
    </div>
    <div class="form-group has-feedback <?php echo e($errors->has('phone_1') ? 'has-error' : ''); ?>">
        <input type="number" name="phone_1" class="form-control"
               placeholder="phone_1">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php if($errors->has('phone_1')): ?>
            <span class="help-block">
                            <strong><?php echo e($errors->first('phone_1')); ?></strong>
            </span>
        <?php endif; ?>
    </div>
    <input type="hidden" name="city" value="1" />
    <input type="hidden" name="state" value="1" />

<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.adminlte.register', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PhantonM\Documents\Projetos\Php\nightlife\resources\views/siteinstitucional/auth/register.blade.php ENDPATH**/ ?>