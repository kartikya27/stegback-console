@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'required' => false,
    'placeholder' => '',
    'selected' => null, // Handles pre-selected values
    'extraAttributes' => [], // Additional attributes as an array
])

@if($label)
    <label for="{{ $name }}" class="fw-bold mb-2">{{ $label }}</label>
@endif

<select
    class="form-select @error($name) is-invalid @enderror"
    name="{{ $name }}"
    id="{{ $name }}"
    aria-label="{{ $label }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge($extraAttributes) }} <!-- Merging extra attributes -->
>
    <option selected disabled>{{ $placeholder ?: 'Choose an option' }}</option>

    @foreach($options as $value => $text)
        <option value="{{ $value }}"
            {{ ((string) old($name, $selected) === (string) $value) ? 'selected' : '' }}>
            {{ $text }}
        </option>
    @endforeach
</select>

@error($name)
    <div class="text-danger">
        {{ $message }}
    </div>
@enderror
