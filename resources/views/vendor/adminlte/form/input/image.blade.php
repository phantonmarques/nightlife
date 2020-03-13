@php
$validationKey = trim(str_replace([']', '['], ['', '.'], $name), '.');
$attributes = [
    'class' => 'form-control'
];

if (isset($default_file)) {
    $attributes['data-default-file'] = $default_file;
}

if (isset($attr)) {
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

    {{ Form::file($name, $attributes) }}

    @if (!empty($default_file))
    <div class="help-block">
        <a href="{{ $default_file }}" target="blank">
            Visualizar arquivo&nbsp;&nbsp;<i class="fas fa-xs fa-external-link-alt"></i>
        </a>
    </div>
    @endif

    @if ((isset($show_validation) && $show_validation !== false) || !isset($show_validation))
        @if ($errors->has($validationKey))
            <span class="help-block">{{ $errors->first($validationKey) }}</span>
        @endif
    @endif
</div>
