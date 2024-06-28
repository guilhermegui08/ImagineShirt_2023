@extends('template.layout')
@section('titulo', 'Edit color')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Colors</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    <form action="{{ route('colors.update', ['color' => $color]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('colors.shared.fields')
        <button type="submit" class="btn btn-primary">Confirm changes</button>
        <a href="{{ route('colors.show', ['color' => $color]) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
