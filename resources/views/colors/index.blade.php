@extends('template.layout')
@section('titulo', 'Colors')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Colors</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    <div>
        <a class="btn btn-success" href="{{ route('colors.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create new color</a>
    </div>
    <hr>
    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($colors as $color)
            <tr>
                <td>{{ $color->code }}</td>
                <td>{{ $color->name }}</td>
                <td class="button-icon-col">
                    <a href="{{ route('colors.show', ['color' => $color]) }}" class="btn btn-secondary"><i class="fas fa-eye"></i></a>
                </td>
                <td class="button-icon-col">
                    <a href="{{ route('colors.edit', ['color' => $color]) }}" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                </td>
                <td class="button-icon-col">
                    <form action="{{ route('colors.destroy', ['color' => $color]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{ $colors->withQueryString()->links() }}
    </div>
@endsection
