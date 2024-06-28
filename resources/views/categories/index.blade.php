@extends('template.layout')
@section('titulo', 'Categories')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
@endsection
{{--@php $user = Auth::user() @endphp--}}
@section('main')
    <div>
        <a class="btn btn-success" href="{{ route('categories.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create new category</a>
    </div>
    <hr>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="button-icon-col">
                        <a href="{{ route('categories.show', ['category' => $category]) }}" class="btn btn-secondary"><i class="fas fa-eye"></i></a>
                    </td>
                    <td class="button-icon-col">
                        <a href="{{ route('categories.edit', ['category' => $category]) }}" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                    </td>
                    <td class="button-icon-col">
                        <form action="{{ route('categories.destroy', ['category' => $category]) }}" method="POST">
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
        {{ $categories->withQueryString()->links() }}
    </div>
@endsection
