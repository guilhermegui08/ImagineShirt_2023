@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="mb-3">
    <div class="form-check form-switch" {{ $disabledStr }}>
        <input type="hidden" name="blocked" value="0">
        <input type="checkbox" class="form-check-input @error('blocked') is-invalid @enderror" name="blocked"
               id="inputBlocked" {{ $disabledStr }} {{ old('blocked', $user->blocked) ? 'checked' : '' }} value="1">
        <label for="inputBlocked" class="form-check-label">Blocked</label>
        @error('blocked')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
