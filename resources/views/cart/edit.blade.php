@extends('template.layout')
@section('titulo', 'Edit item')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Shopping cart</li>
        <li class="breadcrumb-item active">Edit item</li>
    </ol>
@endsection

@section('main')
<form action="{{ route('cart.update', ['cartIndex' => $cartIndex]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="d-flex flex-row flex-wrap gap-2 bg-light p-1">
        @foreach($colors as $color)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="color" value="{{ $color->code }}" id="inputColor" {{ $color->code == $orderItem->color_code ? 'checked' : '' }}>
                <label class="form-check-label" for="inputColor" style="background-color: {{ '#'.$color->code }}; width: 40px; height: 40px; border-radius: 5px">
                </label>
            </div>
        @endforeach
    </div>
    <div class="mb-3 form-floating">
        <input type="text" name="quantity" id="inputQuantity" value="{{ old('quantity', $orderItem->qty) }}" class="form-control @error('quantity') is-invalid @enderror">
        <label for="inputQuantity" class="form-label">Quantity</label>
        @error('quantity')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <select name="size" id="inputSize" class="form-select @error('size') is-invalid @enderror">
            <option {{ $orderItem->size == 'XS' ? 'selected' : ''}}>XS</option>
            <option {{ $orderItem->size == 'S' ? 'selected' : ''}}>S</option>
            <option {{ $orderItem->size == 'M' ? 'selected' : ''}}>M</option>
            <option {{ $orderItem->size == 'L' ? 'selected' : ''}}>L</option>
            <option {{ $orderItem->size == 'XL' ? 'selected' : ''}}>XL</option>
        </select>
        <label for="inputSize" class="form-label">Size</label>
        @error('size')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Confirm changes</button>
</form>
@endsection
