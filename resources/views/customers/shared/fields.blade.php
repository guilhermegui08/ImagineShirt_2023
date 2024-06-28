@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif"
               {{ $disabledStr }} value="{{ old('nif', $customer->nif) }}">
        <label for="inputNif" class="form-label">Nif</label>
        @error('nif')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress"
               {{ $disabledStr }} value="{{ old('address', $customer->address) }}">
        <label for="inputAddress" class="form-label">Address</label>
        @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
<div class="mb-3 form-floating">
    <select name="default_payment_type" id="inputDefaultPaymentType" {{ $disabledStr }} class="form-select @error('default_payment_type') is-invalid @enderror">
        <option {{ $customer->default_payment_type == 'VISA' ? 'selected' : ''}}>VISA</option>
        <option {{ $customer->default_payment_type == 'MC' ? 'selected' : ''}}>MC</option>
        <option {{ $customer->default_payment_type == 'PAYPAL' ? 'selected' : ''}}>PAYPAL</option>
    </select>
    <label for="inputDefaultPaymentType" class="form-label">Default payment type</label>
    @error('default_payment_type')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
