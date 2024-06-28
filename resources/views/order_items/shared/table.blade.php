<table class="table">
    <thead class="table-dark">
    <tr>
        @if ($showOrder)
            <th>Order ID</th>
        @endif
        <th>Image</th>
        <th>Color</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Unit price</th>
        <th>Sub total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orderItems as $order)
        <tr>
            @if ($showOrder)
                <td>{{ $order->orderRef->id }}</td>
            @endif
            <td><img class="card-img-top img-fluid" src="{{ $order->tshirtImage->fullTshirtImageUrl }}" style="background-color: #2f2f2f; width: 40px; height: 40px; align-content: center" alt="Imagem"></td>
            <td><div class="shadow-lg" style="background-color: {{ '#'.$order->color_code }}; width: 40px; height: 40px; border-radius: 5px"></div></td>
            <td>{{ $order->size }}</td>
            <td>{{ $order->qty }}</td>
            <td>{{ $order->unit_price }}</td>
            <td>{{ $order->sub_total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
