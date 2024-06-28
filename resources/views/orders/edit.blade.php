@extends('template.layout')
@section('titulo', "Alterar $order->id")
@section('main')
    <form method="POST" action="{{ route('orders.update', ['order' => $order]) }}">
        @csrf
        @method('PUT')
        @include('orders.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" name="ok" class="btn btn-primary">Save order</button>
            <a href="{{ route('orders.edit', ['order' => $order]) }}" class="btn btn-secondary ms-3">Cancelar</a>
        </div>
    </form>
@endsection
