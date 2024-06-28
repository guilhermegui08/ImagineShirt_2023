@extends('template.layout')

@section('titulo', "Order $order->id")

@section('main')
    <div>
        @include('orders.shared.fields', ['readonlyData' => true])
    </div>
    @if (!Auth::user() || Auth::user()->user_type != 'E')
        @if ($order->receipt_url)
            <div class="mb-3 form-floating">
                <a href="{{ route('download.pdf', ['order' => $order]) }}" class="btn btn-secondary ms-3">Download Receipt PDF</a>
            </div>
        @endif
    @endif
    @if (!Auth::user() || Auth::user()->user_type != 'C')
    <div class="my-4 d-flex justify-content-end">
        <a href="{{ route('orders.edit', ['order' => $order]) }}" class="btn btn-secondary ms-3">Alterar Order</a>
    </div>
    @endif
    <div>
        <h3>Order Items</h3>
        @include('order_items.shared.table', [
        'orderItems' => $order->orderItems,
        'showOrder' => false,
        'showDetail' => true,
        'showEdit' => false,
        'showDelete' => false,
        ])
    </div>
@endsection
