@props([
    'name' => '',
    'type' => 'checkbox',
    'class' => '',
    'labelClass' => '',
    'value' => 1, // For checkbox, value should usually be "1"
    'required' => false,
    'label' => '',
    'extraAttributes' => [],
    'checked' => false, // Allow external override
])

<div>
    {{-- Add hidden input to submit 0 when checkbox is unchecked --}}
    <input type="hidden" name="{{ $name }}" value="0">

    <input
        id="{{ $name }}_checkbox"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        class="{{ $class }}"
        {{ $required ? 'required' : '' }}
        @foreach ($extraAttributes as $key => $attribute)
            {{ $key }}="{{ $attribute }}"
        @endforeach
        @if(old($name, $checked) || $checked) checked @endif
    />

    @if ($label)
        <label for="{{ $name }}_checkbox" class="{{ $labelClass }}">{{ $label }}</label>
    @endif
</div>
