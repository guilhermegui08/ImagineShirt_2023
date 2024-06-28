@extends('template.layout')
@section('titulo', 'Users')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Administradores e Funcionários</li>
    </ol>
@endsection

@section('main')
    <p>
        <a class="btn btn-success" href="{{ route('users.create') }}"><i class="fas fa-plus"></i> &nbsp;Criar novo User</a>
    </p>
    <hr>
    <form method="GET" action="{{ route('users.index') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <input type="text" class="form-control" name="nome" id="inputNome" value="{{ old('name', $filterByNome) }}">
                        <label for="inputNome" class="form-label">Nome</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 mb-3 form-floating">
                        <select class="form-select" name="user_type" id="inputUserType">
                            <option {{ old('user_type', $filterByUserType) === '' ? 'selected' : '' }} value="">
                                Administradores e Funcionários
                            </option>
                            <option {{ old('user_type', $filterByUserType) == 'A' ? 'selected' : '' }} value='A'>Administradores
                            </option>
                            <option {{ old('user_type', $filterByUserType) == 'E' ? 'selected' : '' }} value='E'>Funcionários
                            </option>
                        </select>
                        <label for="inputUserType" class="form-label">Tipo de utilizador</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>
    @include('users.shared.table', [
    'users' => $users,
    'showFoto' => true,
    'showDelete' => true,
    'showEdit' => true
    ])
    <div>
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
