@props([
    'name' => '', // The name of the input field
    'type' => 'radio', // The input type (default: radio)
    'class' => '', // Additional classes for styling
    'labelClass' => '', // Additional classes for styling
    'value' => '', // The value of the radio button
    'required' => false, // Whether the input is required
    'label' => '', // Label for the input
    'extraAttributes' => [],
    'checked' => null // Properly handle old input and pre-selected values
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    class="{{ $class }}"
    {{ $required ? 'required' : '' }}
    @foreach ($extraAttributes as $key => $attribute)
        {{ $key }}="{{ $attribute }}"
    @endforeach
    {{-- Fix: Properly check if the radio button should be selected --}}
    @if((string) old($name, $checked) === (string) $value) checked @endif
/>

@if ($label)
    <label for="{{ $name }}_{{ $value }}" class="{{ $labelClass }}">{{ $label }}</label>
@endif
