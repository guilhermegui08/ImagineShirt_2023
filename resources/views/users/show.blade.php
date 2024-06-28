@extends('template.layout')

@section('titulo', 'User')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item"><strong>{{ $user->name }}</strong></li>
        <li class="breadcrumb-item active">Consultar</li>
    </ol>
@endsection

@section('main')
    <div>
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.fields', ['user' => $user, 'readonlyData' => true])
                @include('users.shared.user_type', ['user' => $user, 'readonlyData' => true])
                <div class="my-1 d-flex justify-content-end">
                    <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            Apagar User
                        </button>
                    </form>
                    <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-secondary ms-3">
                        Alterar User
                    </a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between" style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                'user' => $user,
                'allowUpload' => true,
                'allowDelete' => false
                ])
            </div>
        </div>
    </div>
@endsection
