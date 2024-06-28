@extends('template.layout')
@section('titulo', 'Prices')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Prices</li>
    </ol>
@endsection
@section('main')
    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Public image unitary price</th>
            <th>Private image unitary price</th>
            <th>Public image unitary price with discount</th>
            <th>Private image unitary price with discount</th>
            <th>Quantity discount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $prices->unit_price_catalog }} €</td>
            <td>{{ $prices->unit_price_own }} €</td>
            <td>{{ $prices->unit_price_catalog_discount }} €</td>
            <td>{{ $prices->unit_price_own_discount }} €</td>
            <td>{{ $prices->qty_discount }} items</td>
        </tr>
        </tbody>
    </table>
    <a href="{{ route('prices.edit') }}" class="btn btn-primary">Edit prices</a>
@endsection
