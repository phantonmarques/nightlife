@php
$validationKey = trim(str_replace([']', '['], ['', '.'], $name), '.');
$attributes = ['class' => [ 'form-control', 'select2' ]];
$formGroupAttr = $formGroupAttr ?? [];
$value = $value ?? null;
$options = $options ?? [];
$options_attr = $options_attr ?? [];

if (isset($attr)) {
    if (isset($attr['placeholder'])) {
        $placeholder = $attr['placeholder'];
        unset($attr['placeholder']);
    }

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

if (isset($disabled)) {
    $attributes['disabled'] = $disabled;
}

if (isset($placeholder)) {
    if ($placeholder !== false) {
        $attributes['placeholder'] = $placeholder;
    }
} else {
    $attributes['placeholder'] = 'Selecione';
}

if (isset($multiple)) {
    $attributes['multiple'] = $multiple;
}

@endphp

<div class="form-group {{ $formGroupAttr['class'] ?? '' }} {{ $errors->has($validationKey) ? 'has-error' : '' }}">
    @component('adminlte::form.input.label', [
        'name' => $name,
        'label' => $label ?? false,
        'attr' => $label_attr ?? null
    ])
    @endcomponent

    {{ Form::select($name, $options, $value, $attributes, $options_attr) }}

    @if ((isset($show_validation) && $show_validation !== false) || !isset($show_validation))
        @if ($errors->has($validationKey))
            <span class="help-block">{{ $errors->first($validationKey) }}</span>
        @endif
    @endif
</div>
