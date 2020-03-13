@php
$validationKey = trim(str_replace([']', '['], ['', '.'], $name), '.');
$attributes = ['class' => [ 'form-control', 'wysihtml5' ]];
$value = $value ?? null;

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
@endphp

<div class="form-group {{ $errors->has($validationKey) ? 'has-error' : '' }}">
    @component('adminlte::form.input.label', [
        'name' => $name,
        'label' => $label ?? false,
        'attr' => $label_attr ?? null
    ])
    @endcomponent

    {{ Form::textarea($name, $value, $attributes) }}

    @if ((isset($show_validation) && $show_validation !== false) || !isset($show_validation))
        @if ($errors->has($validationKey))
            <span class="help-block">{{ $errors->first($validationKey) }}</span>
        @endif
    @endif
</div>
