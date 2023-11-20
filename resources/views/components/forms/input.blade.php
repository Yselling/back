@props(['type' => 'text', 'name' => '', 'label', 'placeholder' => '', 'value' => '', 'error' => '', 'disabled' => false])

<div class="mb-4">
    <label class="form-label" for="{{ $name }}">{{ Str::ucfirst($label) }}</label>
    @if($type == 'textarea')
        <textarea class="form-control form-control-alt @error('{{ $name }}') is-invalid @enderror" id="{{ $name }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }}>{{ $value }}</textarea>
    @else
        <input type="{{ $type }}" class="form-control form-control-alt @error('{{ $name }}') is-invalid @enderror" id="{{ $name }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}" {{ $disabled ? 'disabled' : '' }}>
    @endif

        @error('{{ $name }}')
        <div class="invalid-feedback animated fadeIn">{{ $error }}</div>
    @enderror
</div>
