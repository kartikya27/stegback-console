@props([
    'name' => '', // The name of the textarea field
    'class' => '', // Additional classes for styling
    'value' => old($name, $value), // Preserve old input value
    'required' => false, // Whether the textarea is required
    'label' => '', // Label for the textarea
    'placeholder' => '', // Placeholder text
    'rows' => 4, // Number of rows (default: 4)
    'extraAttributes' => [], // Additional attributes as key-value pairs
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="fw-bold mb-2">{{ $label }}</label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control {{ $class }} @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge($extraAttributes) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>
