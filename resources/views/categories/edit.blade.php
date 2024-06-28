@extends('template.layout')
@section('titulo', 'Edit category')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    <form action="{{ route('categories.update', ['category' => $category]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categories.shared.fields')
        <button type="submit" class="btn btn-primary">Confirm changes</button>
        <a href="{{ route('categories.show', ['category' => $category]) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
