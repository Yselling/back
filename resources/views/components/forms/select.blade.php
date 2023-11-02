@props(['name', 'label', 'options', 'value' => ''])

<div class="mb-4">
    <label class="form-label" for="{{ $name }}">{{ Str::ucfirst($label) }}</label>
    <select class="form-control form-control-alt @error('{{ $name }}') is-invalid @enderror" id="{{ $name }}"
        name="{{ $name }}">
        @foreach($options as $option)
            <option value="{{ $option->id }}" {{ $value == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
        @endforeach
    </select>
</div>
