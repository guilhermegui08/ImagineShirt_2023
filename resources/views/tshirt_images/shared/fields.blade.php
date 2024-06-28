@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="d-flex flex-column justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName"
               {{ $disabledStr }} value="{{ old('name', $image->name) }}">
        <label for="inputName" class="form-label">Name</label>
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating " style="max-width: 100%;">
        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="inputDesc"
               {{ $disabledStr }} value="{{ old('description', $image->description) }}">
        <label for="inputDesc" class="form-label">Description</label>
        @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
