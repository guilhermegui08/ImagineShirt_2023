@extends('template.layout')
@section('titulo', 'Shopping cart')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Shopping cart</li>
    </ol>
@endsection

@section('main')
    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Image</th>
            <th>Color</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>SubTotal</th>

            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cart as $cartIndex => $orderItem)
            <tr>
                <td><img class="card-img-top img-fluid" src="{{ $orderItem->tshirtImage->fullTshirtImageUrl }}" style="background-color: #2f2f2f; width: 40px; height: 40px; align-content: center" alt="Imagem"></td>
                <td><div class="shadow-lg" style="background-color: {{ '#'.$orderItem->color_code }}; width: 40px; height: 40px; border-radius: 5px"></div></td>
                <td>{{ $orderItem->size }}</td>
                <td>{{ $orderItem->qty }}</td>
                <td>{{ $orderItem->unit_price }} €</td>
                <td>{{ $orderItem->sub_total }} €</td>

                <td class="button-icon-col">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="imageID" value="{{ $orderItem->tshirt_image_id }}">
                        <input type="hidden" name="color" value="{{ $orderItem->color_code }}">
                        <input type="hidden" name="size" value="{{ $orderItem->size }}">
                        <button type="submit" class="btn btn-dark"><i class="fa-solid fa-plus"></i></button>
                    </form>
                </td>
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('cart.remove', ['cartIndex' => $cartIndex]) }}" class="button-icon-col">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="fullDelete" value="1">
                        <button type="submit" name="delete" class="btn btn-secondary"><i class="fa-solid fa-minus"></i></button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('cart.edit', ['cartIndex' => $cartIndex]) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                </td>
                <td>
                    <form method="POST" action="{{ route('cart.remove', ['cartIndex' => $cartIndex]) }}" class="button-icon-col">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="fullDelete" value="0">
                        <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Footer da table -->
    <div class="d-flex flex-row justify-content-between">
        <h4 class="fw-bold">Total: {{ $cartTotal }} €</h4>
        @if(count($cart) > 0)
        <!-- Buttons -->
        <div class="d-flex flex-row justify-content-between gap-4">
            @can('completeOrder')
            <div>
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to checkout</a>
            </div>
            @elsecannot('completeOrder')
                <p class="fs-5 lh-lg">To complete order you need to be registered as a customer</p>
            @endcan
            <div>
                <form action="{{ route('cart.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Clear cart</button>
                </form>
            </div>
        </div>
        @endif
    </div>
<!--?php dump($cart) ?-->
@endsection
