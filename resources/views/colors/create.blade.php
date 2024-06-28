@extends('template.layout')
@section('titulo', 'Create color')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Colors</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    <form action="{{ route('colors.store') }}" method="POST">
        @csrf
        @include('colors.shared.fields')
        <button type="submit" class="btn btn-success">Create color</button>
        <a href="{{ route('colors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
