@extends('template.layout')
@section('titulo', 'Statistics')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Web Store Statistics</li>
    </ol>

@endsection

@section('main')
    <div class="container">
        <div class="stats-card">
            <h2>Total Users</h2>
            <p><?php echo $totalUsers; ?></p>
        </div>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th>Clientes</th>
                <th>Funcionários</th>
                <th>Administradores</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $totalCustomers }}</td>
                <td>{{ $totalFuncionarios }}</td>
                <td>{{ $totalAdmins }}</td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="stats-card">
            <h2>Total Orders</h2>
            <p><?php echo $totalOrders; ?></p>
        </div>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th>Pending</th>
                <th>Paid</th>
                <th>Closed</th>
                <th>Canceled</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $totalOrdersPending }}</td>
                <td>{{ $totalOrdersPaid }}</td>
                <td>{{ $totalOrdersClosed }}</td>
                <td>{{ $totalOrdersCanceled }}</td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="stats-card">
            <h2>Total Order Items</h2>
            <p><?php echo $totalOderItems; ?></p>
        </div>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th>XS</th>
                <th>S</th>
                <th>M</th>
                <th>L</th>
                <th>XL</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $totalOrdersItemsXs }}</td>
                <td>{{ $totalOrdersItemsS }}</td>
                <td>{{ $totalOrdersItemsM }}</td>
                <td>{{ $totalOrdersItemsL }}</td>
                <td>{{ $totalOrdersItemsXl }}</td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="stats-card">
            <h2>Total Tshirt Images</h2>
            <p><?php echo $totalTshirtImages; ?></p>
        </div>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th>Public</th>
                <th>Private</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $totalTshirtImagesPublic }}</td>
                <td>{{ $totalTshirtImagesPrivate }}</td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="stats-card">
            <h2>Total Categories</h2>
            <p><?php echo $totalCategory; ?></p>
        </div>
        <div class="d-flex flex-row justify-content-start flex-wrap gap-3">
            @foreach ($categories as $category)
                <div class="card" style="margin-bottom: 5px; margin-top: 5px; max-width: 200px">
                    <h5 class="card-title d-inline-block text-truncate" style="max-width: 200px; object-fit: fill">{{$category->name}}</h5>
                </div>
            @endforeach
        </div>

    </div>
@endsection
