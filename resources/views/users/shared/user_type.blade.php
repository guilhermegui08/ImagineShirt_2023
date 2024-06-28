@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="mb-3 form-floating">
    <select name="user_type" id="inputUserType" {{ $disabledStr }} class="form-select @error('user_type') is-invalid @enderror">
        <option {{ $user->user_type == 'A' ? 'selected' : ''}} value='A'>Administrador</option>
        <option {{ $user->user_type == 'E' ? 'selected' : ''}} value='E'>Funcionário</option>
    </select>
    <label for="inputUserType" class="form-label">User Type</label>
    @error('user_type')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
