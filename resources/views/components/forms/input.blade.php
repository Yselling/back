@props(['type' => 'text', 'name', 'label', 'placeholder' => '', 'value' => '', 'error' => ''])

<div class="mb-4">
    <label class="form-label" for="{{ $name }}">{{ Str::ucfirst($label) }}</label>
    @if($type == 'textarea')
        <textarea class="form-control form-control-alt @error('{{ $name }}') is-invalid @enderror" id="{{ $name }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
    @else
        <input type="{{ $type }}" class="form-control form-control-alt @error('{{ $name }}') is-invalid @enderror" id="{{ $name }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}">
    @endif

        @error('{{ $name }}')
        <div class="invalid-feedback animated fadeIn">{{ $error }}</div>
    @enderror
</div>
