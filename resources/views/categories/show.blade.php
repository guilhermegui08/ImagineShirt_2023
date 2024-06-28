@extends('template.layout')
@section('titulo', 'Category details')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    @include('categories.shared.fields', ['readonlyData' => true])
    <a href="{{ route('categories.edit', ['category' => $category]) }}" class="btn btn-primary">Edit category</a>
@endsection
