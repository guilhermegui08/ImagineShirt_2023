@extends('template.layout')
@section('titulo', 'Orders')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item active">Orders</li>
    </ol>
@endsection
{{ $user = Auth::user() }}
@section('main')
    <hr>
    @if (($user->user_type ?? '') == 'A')
        <form method="GET" action="{{ route('orders.index') }}">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1 pe-2">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1 mb-3 form-floating">
                            <select class="form-select" name="status" id="inputStatus">
                                <option {{ old('status', $filterByStatus) === '' ? 'selected' : '' }} value="">
                                    Todos
                                </option>
                                <option {{ old('status', $filterByStatus) == 'pending' ? 'selected' : '' }} value='pending'>pending
                                </option>
                                <option {{ old('status', $filterByStatus) == 'paid' ? 'selected' : '' }} value='paid'>paid
                                </option>
                                <option {{ old('status', $filterByStatus) == 'closed' ? 'selected' : '' }} value='closed'>closed
                                </option>
                                <option {{ old('status', $filterByStatus) == 'canceled' ? 'selected' : '' }} value='canceled'>canceled
                                </option>
                            </select>
                            <label for="inputStatus" class="form-label">Status</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 me-2 flex-grow-1 form-floating">
                            <input type="text" class="form-control" name="nif" id="inputNif" value="{{ old('name', $filterByNif) }}">
                            <label for="inputNif" class="form-label">Nif</label>
                        </div>
                        <div class="mb-3 flex-grow-1 form-floating">
                            <div class="mb-3 me-2 flex-grow-1 form-floating">
                                <input type="date" class="form-control" name="date" id="inputDate" value="{{ old('name', $filterByDate) }}">
                                <label for="inputDate" class="form-label">Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                    <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
                </div>
            </div>
        </form>
    @endif
    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Status</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total Price</th>
            <th>Address</th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
        </tr>
        </thead>
        <tbody>
        @if($user != null)
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->user->name}}</td>
                    <td>{{ $order->date }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->address }}</td>
                    @if($user->user_type == 'A' || $user->user_type == 'C')
                        <td class="button-icon-col">
                            <a href="{{ route('orders.show', ['order' => $order]) }}" class="btn btn-secondary">
                                <i class="fas fa-eye"></i></a>
                        </td>
                    @endif
                    @if($user->user_type == 'A' || $user->user_type == 'E')
                        <td class="button-icon-col">
                            <a href="{{ route('orders.edit', ['order' => $order]) }}" class="btn btn-dark">
                                <i class="fas fa-edit"></i></a>
                        </td>
                    @endif
                    @if($user->user_type == 'A')
                        <td>
                            <form method="POST" action="{{ route('orders.destroy', ['order' => $order]) }}" class="button-icon-col">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="delete" class="btn btn-danger">
                                    <i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <div>
        {{ $orders->withQueryString()->links() }}
    </div>
@endsection
