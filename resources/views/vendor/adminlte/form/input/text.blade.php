@php
$validationKey = trim(str_replace([']', '['], ['', '.'], $name), '.');
$value = $value ?? null;
$attributes = [ 'class' => 'form-control' ];

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

    @if (isset($input_group))
    <div class="input-group">
        @if ($input_group === 'prepend')
        {{ $slot }}
        @endif
    @endif

    @if (isset($type) && $type == 'email')
    {{ Form::email($name, $value, $attributes) }}
    @elseif (isset($type) && $type == 'password')
    {{ Form::password($name, $attributes) }}
    @else
    {{ Form::text($name, $value, $attributes) }}
    @endif

    @if (isset($input_group))
        @if ($input_group === 'append')
        {{ $slot }}
        @endif
    </div>
    @endif

    @if ((isset($show_validation) && $show_validation !== false) || !isset($show_validation))
        @if ($errors->has($validationKey))
            <span class="help-block">{{ $errors->first($validationKey) }}</span>
        @endif
    @endif
</div>
