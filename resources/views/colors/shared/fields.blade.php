@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName"
               {{ $disabledStr }} value="{{ old('name', $color->name ?? '') }}">
        <label for="inputName" class="form-label">Name</label>
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="inputCode"
               {{ $disabledStr }} value="{{ old('code', $color->code ?? '') }}">
        <label for="inputCode" class="form-label">Code</label>
        @error('code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
