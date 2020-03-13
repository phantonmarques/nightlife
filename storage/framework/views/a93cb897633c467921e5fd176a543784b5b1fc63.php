<?php
$attributes = [
    'class' => 'form-label'
];

if (isset($label) && $label !== false) {
    if (isset($attr) && $attr !== null) {
        $attributes = array_merge_recursive($attributes, $attr);

        foreach ($attributes as $attr_name => $attr_value) {
            if (is_array($attr_value)) {
                $attributes[$attr_name] = implode(' ', Arr::flatten(array_unique($attr_value)));
            } else if (is_string($attr_value)) {
                $attributes[$attr_name] = trim($attr_value);
            }
        }
    }
}
?>

<?php if(isset($label) && $label !== false): ?>
<?php echo e(Form::label($name ?? null, $label, $attributes)); ?>

<?php endif; ?>
<?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/vendor/adminlte/form/input/label.blade.php ENDPATH**/ ?>