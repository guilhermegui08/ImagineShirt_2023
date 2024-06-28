@extends('template.layout')
@section('titulo', "Alterar User")
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item"><strong>{{ $user->name }}</strong></li>
        <li class="breadcrumb-item active">Alterar</li>
    </ol>
@endsection
@section('main')
    <form id="form_user" novalidate class="needs-validation" method="POST" action="{{ route('users.update', ['user' => $user]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.fields', ['user' => $user, 'readonlyData' => false])
                @include('users.shared.blocked', ['user' => $user, 'readonlyData' => false])
                @include('users.shared.user_type', ['user' => $user, 'readonlyData' => false])
                <div class="my-1 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="ok" form="form_user">Guardar
                        Alterações</button>
                    <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-secondary ms-3">Cancelar</a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center
justify-content-between" style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                'user' => $user,
                'allowUpload' => true,
                'allowDelete' => true,
                ])
            </div>
        </div>
    </form>
    </form>
    @include('shared.confirmationDialog', [
    'title' => 'Quer realmente apagar a foto?',
    'msgLine1' => 'As alterações efetuadas aos dados do user vão ser perdidas!',
    'msgLine2' => 'Clique no botão "Apagar" para confirmar a operação.',
    'confirmationButton' => 'Apagar fotografia',
    'formAction' => route('users.foto.destroy',
    ['user' => $user]),
    'formMethod' => 'DELETE',
    ])
@endsection
