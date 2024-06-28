<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\OrderItem;
use Illuminate\View\View;
use Illuminate\Http\Request;


class OrderItemController extends Controller
{
    public function index(): View
    {
        $allOrders = OrderItem::all();
        return view('order_items.index')->with('orderItems', $allOrders);
    }

    public function create(): View
    {
        $newOrderItem = new OrderItem();
        return view('order_items.create')->withOrderItem($newOrderItem);
    }
    public function store(Request $request): RedirectResponse
    {
        OrderItem::create($request->all());
        return redirect()->route('order_items.index');
    }

    public function edit(OrderItem $orderItem): View
    {
        return view('order_items.edit')->withOrderItem($orderItem);
    }
    public function update(Request $request, OrderItem $orderItem): RedirectResponse
    {
        $orderItem->update($request->all());
        return redirect()->route('order_items.index');
    }

    public function destroy(OrderItem $orderItem): RedirectResponse
    {
        $orderItem->delete();
        return redirect()->route('order_items.index');
    }

    public function show(OrderItem $orderItem): View
    {
        return view('order_items.show')->withOrderItem($orderItem);
    }

}

