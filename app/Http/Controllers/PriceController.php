<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function show(): View
    {
        $prices = Price::query()->first();
        return view('prices.show', compact('prices'));
    }

    public function edit(): View
    {
        $prices = Price::query()->first();
        return view('prices.edit', compact('prices'));
    }

    public function update(PriceRequest $request): RedirectResponse
    {
        $prices = Price::query()->first();
        $prices->update($request->validated());
        $url = route('prices.show');
        $htmlMessage = "Prices successfully updated";
        return redirect()->route('prices.show')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
}
