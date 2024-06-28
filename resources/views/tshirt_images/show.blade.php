@extends('template.layout')
@section('titulo', 'Imagem')
@section('main')
<!-- Form com varios input hidden para poder enviar os dados necessarios para criar um order_item sem ter na DB -->
<form action="{{ route('cart.add') }}" method="POST" class="d-flex flex-column gap-3">
    @csrf
    <input type="hidden" name="imageID" value="{{ $imageId }}">
    <input type="hidden" name="color" value="{{ $basePreview->code }}">
    <div class="card d-flex flex-row justify-content-between">
        <div>
            <img src="{{ $image->fullTshirtImageUrl }}" class="card-img-top img-fluid"  style="background-color: #2f2f2f; width: 300px; height: 300px; align-content: center" alt="Imagem">
            <div class="m-1">
                @include('tshirt_images.shared.fields', ['readonlyData' => true])
            </div>
        </div>
        <div class="card-img-top img-fluid d-flex justify-content-center" style="width: 400px; height: 400px; position: relative">
            <img src="{{$basePreview->fullTshirtBaseUrl}}" alt="Tshirt Base Preview" style="width: 100%; height: 100%; z-index: 1; position: absolute">
            <img src="{{ $image->fullTshirtImageUrl }}" alt="Tshirt Image Preview" style="width: 50%; height: 50%; z-index: 2; position: absolute; top: 50%; transform: translateY(-50%)">
        </div>
        <div class="d-flex flex-column justify-content-end m-2">
            <button class="btn btn-primary" type="submit">Adicionar ao Carrinho</button>
        </div>
    </div>
<div class="card d-flex flex-row overflow-auto card-img-top img-fluid">
    @foreach($bases as $base)
        <a href="{{ route('tshirt_images.show', ['tshirt_image' => $imageId, 'color' => $base->code, 'size' => $size]) }}">
            <img src="{{$base->fullTshirtBaseUrl}}" alt="Base de Tshirt" style="width: 150px; height: 150px">
        </a>
    @endforeach
</div>
    <!-- TODO: SIZES -->
    <div class="mb-3 form-floating">
        <select name="size" id="inputSize" class="form-select">
            <option {{ old('size', $size) == 'XS' ? 'selected' : ''}}>XS</option>
            <option {{ old('size', $size) == 'S' ? 'selected' : ''}}>S</option>
            <option {{ old('size', $size) == 'M' ? 'selected' : ''}}>M</option>
            <option {{ old('size', $size) == 'L' ? 'selected' : ''}}>L</option>
            <option {{ old('size', $size) == 'XL' ? 'selected' : ''}}>XL</option>
        </select>
        <label for="inputSize" class="form-label">Size</label>
    </div>
</form>
@endsection
