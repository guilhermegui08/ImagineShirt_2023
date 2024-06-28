<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;
use App\Http\Requests\BlockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockController extends Controller
{
    public function update(BlockRequest $request, Customer $blocker): RedirectResponse
    {
        $this->authorize('administrate');
        $customer = $blocker;
        $formData = $request->validated();
        $customer = DB::transaction(function () use ($formData, $customer, $request) {
            $user = $customer->user;
            $user->blocked = $formData['blocked'];
            $user->save();
            return $customer;
        });
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'>#{$customer->id}</a>
<strong>\"{$customer->user->name}\"</strong>
foi alterado com sucesso!";
        return redirect()->route('customers.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
}
