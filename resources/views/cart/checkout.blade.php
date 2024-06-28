@extends('template.layout')
@section('titulo', 'Checkout')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Shopping cart</li>
        <li class="breadcrumb-item active">Checkout</li>
    </ol>
@endsection

@section('main')
{{--    @include('orders.shared.fields')--}}
<form action="{{ route('cart.store') }}" method="POST">
    @csrf
    <div class="mb-3 form-floating">
        <input type="text" name="address" id="inputAddress" value="{{ old('address', $order->address) }}" class="form-control @error('address') is-invalid @enderror">
        <label for="inputAddress" class="form-label">Address</label>
        @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <input type="text" name="nif" id="inputNIF" value="{{ old('nif', $order->nif) }}" class="form-control @error('nif') is-invalid @enderror">
        <label for="inputNIF" class="form-label">NIF</label>
        @error('nif')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <select name="payment_type" id="inputPaymentType" class="form-select @error('payment_type') is-invalid @enderror">
            <option {{ old('payment_type', $order->payment_type) == 'VISA' ? 'selected' : ''}}>VISA</option>
            <option {{ old('payment_type', $order->payment_type) == 'MC' ? 'selected' : ''}}>MC</option>
            <option {{ old('payment_type', $order->payment_type) == 'PAYPAL' ? 'selected' : ''}}>PAYPAL</option>
        </select>
        <label for="inputPaymentType" class="form-label">Payment type</label>
        @error('payment_type')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <input type="text" name="payment_ref" id="inputPaymentRef" value="{{ old('payment_ref', $order->payment_ref) }}" class="form-control @error('payment_ref') is-invalid @enderror">
        <label for="inputPaymentRef" class="form-label">Payment ref</label>
        @error('payment_ref')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <textarea name="notes" id="inputNotes" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $order->notes) }}</textarea>
        <label for="inputNotes" class="form-label">Notes</label>
        @error('notes')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <input type="hidden" name="total_price" value="{{ $cartTotal }}">
    <div class="mb-3 form-floating">
        <button type="submit" class="btn btn-primary">Confirm order</button>
    </div>
</form>
@endsection
