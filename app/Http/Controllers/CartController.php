<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use App\Models\User;
use App\Notifications\OrderPending;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    const ITEM_NOT_IN_CART = -1;
    public function show(): View
    {
        $cart = session('cart', []);
        $cartTotal = array_sum(array_column($cart, 'sub_total'));
        return view('cart.show', compact('cart', 'cartTotal'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'imageID' => 'required|exists:tshirt_images,id',
                'color' => 'required|exists:colors,code',
                'size' => 'required|in:XS,S,M,L,XL',
            ]);
            $tshirt_image_id = $validated['imageID'];
            $color_code = $validated['color'];
            $size = $validated['size'];
            $cart = session('cart', []);


            $htmlMessage = "New item added to <a href=".route('cart.show').">shopping cart</a>";

            // Se ja existe um order_item igual apenas queremos aumentar a quantidade
            $cartIndex = $this->isAlreadyInCart($tshirt_image_id, $color_code, $size);
            if($cartIndex != self::ITEM_NOT_IN_CART){
                $orderItem = $cart[$cartIndex];
                $orderItem = $this->updateItemQuantityAndPrice($orderItem, $orderItem->qty + 1);
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
            }

            // Create a temporary order_item (not in DB)
            $newOrderItem = new OrderItem();
            $newOrderItem->tshirt_image_id = $tshirt_image_id;
            $newOrderItem->color_code = $color_code;
            $newOrderItem->size = $size;
            $newOrderItem = $this->updateItemQuantityAndPrice($newOrderItem, 1);
            $cartId = session('cart_id', 0);

            // Add order_item to cart
            $cart[$cartId] = $newOrderItem;
            $cartId++;
            $request->session()->put('cart', $cart);
            $request->session()->put('cart_id', $cartId);
        } catch (\Exception $error) {
            // Dialog
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function removeFromCart(Request $request, int $cartIndex): RedirectResponse
    {
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];

        $htmlMessage = "Item removed from <a href=".route('cart.show').">shopping cart</a>";

        // verificar se e para remover completamente do carrinho ou apenas baixar quantidade
        $fullDelete = $request->input('fullDelete') ?? false;
        if($fullDelete and $orderItem->qty > 1){
            $orderItem = $this->updateItemQuantityAndPrice($orderItem, $orderItem->qty - 1);
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'success');
        }
        // remover item do carrinho
        unset($cart[$cartIndex]);
        // se o carrinho esta vazio, refresh das variaveis de sessao
        if(count($cart) === 0){
            self::destroy($request);
        }
        $request->session()->put('cart', $cart);
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Request $request, int $cartIndex): View
    {
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];
        $colors = Color::all();
        return view('cart.edit', compact('orderItem', 'colors', 'cartIndex'));
    }

    public function update(Request $request, int $cartIndex): RedirectResponse
    {
        // Validation
        $validated = $request->validate([
            'color' => 'required|exists:colors,code',
            'quantity' => 'required|integer|gte:0',
            'size' => 'required|in:XS,S,M,L,XL',
        ],
        [
            'quantity.integer' => 'Quantity needs to be a number',
            'quantity.gte' => 'Quantity needs to be a positive number',
        ]);
        $color = $validated['color'];
        $quantity = intval($validated['quantity']);
        $size = $validated['size'];

        // Update
        $htmlMessage = "Item successfully updated. View in <a href=".route('cart.show').">shopping cart</a>";
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];

        // if selected color, size and image already exists in cart => update qty and price
        $sameOrderItemIndex = $this->isAlreadyInCart($orderItem->tshirt_image_id, $color, $size, ignoreIndex: $cartIndex);
        if ($sameOrderItemIndex != self::ITEM_NOT_IN_CART) {
            $sameOrderItem = $cart[$sameOrderItemIndex];
            // atualizar valores
            $orderItem = $this->updateItemQuantityAndPrice($orderItem, $quantity + $sameOrderItem->qty);
            // remove duplicated item
            unset($cart[$sameOrderItemIndex]);
            $request->session()->put('cart', $cart);
        }
        else{
            $orderItem = $this->updateItemQuantityAndPrice($orderItem, $quantity);
        }
        // normal update
        $orderItem->color_code = $color;
        $orderItem->size = $size;

        return redirect()->route('cart.show')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validation
        $validated = $request->validate([
            'address' => 'required',
            'nif' => 'required|string|max:9',
            'payment_type' => 'required|in:VISA,MC,PAYPAL',
            'payment_ref' => 'required',
            'total_price' => 'required|numeric',
            'notes' => 'sometimes'
        ],
        [
            'nif.max' => 'Invalid nif',
            'address.required' => 'This field is mandatory',
            'nif.required' => 'This field is mandatory',
            'payment_type.required' => 'This field is mandatory',
            'payment_ref.required' => 'This field is mandatory',
        ]);
        $htmlMessage = '';
        $alertType = '';
        try {
            $cart = session('cart', []);
            $customer = Customer::query()->where('id', '=', $request->user()->id)->first();
            $order = DB::transaction(function () use ($cart, $customer, $validated) {
                // criar order
                $newOrder = new Order();
                $newOrder->status = 'pending';
                $newOrder->customer_id = $customer->id;
                $newOrder->date = Carbon::now()->toDateTimeString();
                $newOrder->total_price = $validated['total_price'];
                $newOrder->nif = $validated['nif'];
                $newOrder->address = $validated['address'];
                $newOrder->payment_type = $validated['payment_type'];
                $newOrder->payment_ref = $validated['payment_ref'];
                $notes = $validated['notes'];
                if ($notes) {
                    $newOrder->notes = $notes;
                }

                // guardar order na DB
                $newOrder->save();
                $orderID = $newOrder->id;

                // guardar orderItems na DB
                foreach ($cart as $orderItem) {
                    $newOrderItem = new OrderItem();
                    $newOrderItem->order_id = $orderID;
                    $newOrderItem->tshirt_image_id = $orderItem->tshirt_image_id;
                    $newOrderItem->color_code = $orderItem->color_code;
                    $newOrderItem->size = $orderItem->size;
                    $newOrderItem->qty = $orderItem->qty;
                    $newOrderItem->unit_price = $orderItem->unit_price;
                    $newOrderItem->sub_total = $orderItem->sub_total;
                    $newOrderItem->save();
                }
                return $newOrder;
            });
            $user = User::find($order->customer_id);
            $user->notify(new OrderPending($order));
            $htmlMessage = "Order created successfully. <a href=".route('orders.show', ['order' => $order->id]).">See order details</a>";
            $alertType = 'success';
            // clear ao cart
            $this->destroy($request);
        }
        catch (\Exception $error) {
            // Dialog
            $htmlMessage = 'Failed to complete order';
            $alertType = 'danger';
        }
        return redirect('/home')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function checkout(Request $request): View
    {
        $cart = session('cart', []);
        $cartTotal = array_sum(array_column($cart, 'sub_total'));
        $order = new Order();
        $customer = Customer::query()->where('id', '=', $request->user()->id)->first();
        $order->address = $customer->address;
        $order->payment_type = $customer->default_payment_type;
        $order->payment_ref = $customer->default_payment_ref;
        $order->nif = $customer->nif;
        return view('cart.checkout', compact('cart', 'cartTotal', 'order'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $request->session()->forget('cart_id');
        $htmlMessage = "Cart items removed";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }


    // Funcoes auxiliares
    private function isAlreadyInCart($tshirt_image_id, $color_code, $size, $ignoreIndex = null): int
    {
        $cart = session('cart', []);
        foreach ($cart as $id => $orderItem){
            // pode ser preciso dar skip a si proprio
            if ($ignoreIndex != null and $id == $ignoreIndex) {
                continue;
            }

            if (
                $orderItem->tshirt_image_id == $tshirt_image_id and
                $orderItem->color_code == $color_code and
                $orderItem->size == $size
            )
            {
                return $id;
            }
        }
        return -1;
    }

    private function getPrice ($isPrivate, $quantity): float
    {
        $prices = Price::query()->first();
        // Desconto ?
        if ($quantity >= $prices->qty_discount) {
            return $isPrivate ? $prices->unit_price_own_discount : $prices->unit_price_catalog_discount;
        }
        // preco normal
        return $isPrivate ? $prices->unit_price_own : $prices->unit_price_catalog;
    }

    private function updateItemQuantityAndPrice($orderItem, $quantity)
    {
        $orderItem->qty = $quantity;
        $orderItem->unit_price = $this->getPrice($orderItem->tshirtImage->customer_id != null, $orderItem->qty);
        $orderItem->sub_total = $orderItem->qty * $orderItem->unit_price;
        return $orderItem;
    }
}
