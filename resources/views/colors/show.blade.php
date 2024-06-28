@extends('template.layout')
@section('titulo', 'Color details')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Colors</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    @include('colors.shared.fields', ['readonlyData' => true])
    <a href="{{ route('colors.edit', ['color' => $color]) }}" class="btn btn-primary">Edit color</a>
@endsection
