@extends('template.layout')

@section('titulo', 'Novo User')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Criar Novo</li>
    </ol>
@endsection

@section('main')
    <form id="form_user" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.criar', ['user' => $user, 'readonlyData' => false])
                <div class="my-1 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="ok" form="form_user">Guardar novo
                        user</button>
                    <a href="{{ route('users.create', ['user' => $user]) }}" class="btn btn-secondary ms-3">Cancelar</a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                 style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                    'user' => $user,
                    'allowUpload' => true,
                    'allowDelete' => false,
                ])
            </div>
        </div>
    </form>
@endsection
