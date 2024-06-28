@extends('template.layout')
@section('titulo', 'Edit prices')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Catalog</li>
        <li class="breadcrumb-item active">Prices</li>
    </ol>
@endsection
@section('main')
<form action="{{ route('prices.update') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="d-flex justify-content-between">
        <div class="mb-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('unit_price_catalog') is-invalid @enderror" name="unit_price_catalog"
                   id="inputUnitPriceCatalog" value="{{ old('unit_price_catalog', $prices->unit_price_catalog ?? '') }}">
            <label for="inputUnitPriceCatalog" class="form-label">Public image unitary price</label>
            @error('unit_price_catalog')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="mb-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('unit_price_own') is-invalid @enderror" name="unit_price_own"
                   id="inputUnitPriceOwn" value="{{ old('unit_price_own', $prices->unit_price_own ?? '') }}">
            <label for="inputUnitPriceOwn" class="form-label">Private image unitary price</label>
            @error('unit_price_own')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="mb-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('unit_price_catalog_discount') is-invalid @enderror" name="unit_price_catalog_discount"
                   id="inputUnitPriceCatalogDiscount" value="{{ old('unit_price_catalog_discount', $prices->unit_price_catalog_discount ?? '') }}">
            <label for="inputUnitPriceCatalogDiscount" class="form-label">Public image unitary price with discount</label>
            @error('unit_price_catalog_discount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="mb-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('unit_price_own_discount') is-invalid @enderror" name="unit_price_own_discount"
                   id="inputUnitPriceOwnDiscount" value="{{ old('unit_price_own_discount', $prices->unit_price_own_discount ?? '') }}">
            <label for="inputUnitPriceOwnDiscount" class="form-label">Private image unitary price with discount</label>
            @error('unit_price_own_discount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="mb-3 form-floating flex-grow-1">
            <input type="text" class="form-control @error('qty_discount') is-invalid @enderror" name="qty_discount"
                   id="inputQtyDiscount" value="{{ old('qty_discount', $prices->qty_discount ?? '') }}">
            <label for="inputQtyDiscount" class="form-label">Quantity discount</label>
            @error('qty_discount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Confirm changes</button>
</form>
@endsection
