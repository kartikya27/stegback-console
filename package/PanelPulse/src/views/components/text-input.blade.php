@props([
    'name' => '', // The name of the input field
    'type' => 'text', // The input type (default: text)
    'class' => '', // Additional classes for styling
    'value' => old($name, $value), // Preserve old input value
    'required' => false, // Whether the input is required
    'label' => '', // Label for the input
    'placeholder' => '', // Placeholder text
    'extraAttributes' => [], // Additional attributes as an array
])

@if ($label)
    <label for="{{ $name }}" class="fw-bold mb-2">{{ $label }}</label>
@endif

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    class="form-control {{ $class }}"
    placeholder="{{ $placeholder }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge($extraAttributes) }}
/>

@error($name)
<div class="text-danger">
    {{ $message }}
</div>
@enderror
