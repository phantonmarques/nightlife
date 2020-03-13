<?php
$validationKey = trim(str_replace([']', '['], ['', '.'], $name ?? ''), '.');
$value = $value ?? null;
$attributes = [ 'class' => 'form-control' ];
$show_validation = $show_validation ?? false;

if (isset($attr)) {
    if (isset($attr['value'])) {
        $value = $attr['value'];
        unset($attr['value']);
    }

    $attributes = array_merge_recursive($attributes, $attr);

    foreach ($attributes as $attr_name => $attr_value) {
        if (is_array($attr_value)) {
            $attributes[$attr_name] = implode(' ', Arr::flatten(array_unique($attr_value)));
        } else if (is_string($attr_value)) {
            $attributes[$attr_name] = trim($attr_value);
        } else if (is_bool($attr_value)) {
            $attributes[$attr_name] = boolval($attr_value) ? 'true' : 'false';
        }
    }
}
?>

<div class="form-group <?php echo e($errors->has($validationKey) ? 'has-error' : ''); ?>">
    <?php $__env->startComponent('adminlte::form.input.label', [
        'name' => $name ?? null,
        'label' => $label ?? false,
        'attr' => $label_attr ?? null
    ]); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php if(isset($wysiwyg) && $wysiwyg === true): ?>
    <div class="form-control-static"><?php echo $value ?? '-'; ?></div>
    <?php elseif(isset($image) && $image === true): ?>
    <img src="<?php echo e($value); ?>" alt="<?php echo e($image_alt ?? ''); ?>" class="img-responsive img-thumbnail">
        <?php if(isset($show) && $show !== null): ?>
    <div class="help-block">
        <a href="<?php echo e($show); ?>" target="blank">
            Visualizar arquivo&nbsp;&nbsp;<i class="fas fa-xs fa-external-link-alt"></i>
        </a>
    </div>
        <?php endif; ?>
    <?php else: ?>
    <p class="form-control-static">
        <?php if(isset($show) && $show !== null): ?>
        <a href="<?php echo e($show); ?>" target="_blank">
            <?php echo e($value ?? '-'); ?>&nbsp;&nbsp;<i class="fas fa-xs fa-external-link-alt"></i>
        </a>
        <?php else: ?>
        <?php echo e($value ?? '-'); ?>

        <?php endif; ?>
    </p>
    <?php endif; ?>

    <?php if((isset($show_validation) && $show_validation !== false) || !isset($show_validation)): ?>
        <?php if($errors->has($validationKey)): ?>
            <span class="help-block"><?php echo e($errors->first($validationKey)); ?></span>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/vendor/adminlte/form/input/static.blade.php ENDPATH**/ ?>