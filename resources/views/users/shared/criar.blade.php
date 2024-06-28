@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputNome"
           {{ $disabledStr }} value="{{ old('name', $user->name) }}">
    <label for="inputNome" class="form-label">Nome</label>
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail"
           {{ $disabledStr }} value="{{ old('email', $user->email) }}">
    <label for="inputEmail" class="form-label">Email</label>
    @error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

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

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('password_inicial') is-invalid @enderror" name="password_inicial"
           id="inputPassword" value="{{ old('password_inicial', '123') }}">
    <label for="inputPassword" class="form-label">Password Inicial</label>
    @error('password_inicial')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
