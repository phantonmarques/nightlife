@php
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
@endphp

<div class="form-group {{ $errors->has($validationKey) ? 'has-error' : '' }}">
    @component('adminlte::form.input.label', [
        'name' => $name ?? null,
        'label' => $label ?? false,
        'attr' => $label_attr ?? null
    ])
    @endcomponent

    @if (isset($wysiwyg) && $wysiwyg === true)
    <div class="form-control-static">{!! $value ?? '-' !!}</div>
    @elseif (isset($image) && $image === true)
    <img src="{{ $value }}" alt="{{ $image_alt ?? '' }}" class="img-responsive img-thumbnail">
        @if (isset($show) && $show !== null)
    <div class="help-block">
        <a href="{{ $show }}" target="blank">
            Visualizar arquivo&nbsp;&nbsp;<i class="fas fa-xs fa-external-link-alt"></i>
        </a>
    </div>
        @endif
    @else
    <p class="form-control-static">
        @if (isset($show) && $show !== null)
        <a href="{{ $show }}" target="_blank">
            {{ $value ?? '-' }}&nbsp;&nbsp;<i class="fas fa-xs fa-external-link-alt"></i>
        </a>
        @else
        {{ $value ?? '-' }}
        @endif
    </p>
    @endif

    @if ((isset($show_validation) && $show_validation !== false) || !isset($show_validation))
        @if ($errors->has($validationKey))
            <span class="help-block">{{ $errors->first($validationKey) }}</span>
        @endif
    @endif
</div>
