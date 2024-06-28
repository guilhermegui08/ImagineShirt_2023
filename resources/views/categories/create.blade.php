@extends('template.layout')
@section('titulo', 'Create category')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories.shared.fields')
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
