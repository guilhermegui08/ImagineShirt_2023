<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $colors = Color::query()->paginate(20);
        return view('colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request): RedirectResponse
    {
        $color = Color::create($request->validated());
        $url = route('colors.show', ['color' => $color]);
        $htmlMessage = "Color <a href='$url'>#{$color->code}</a> <strong>$color->name</strong> successfully created";
        return redirect()->route('colors.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color): View
    {
        return view('colors.show', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color): View
    {
        return view('colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, Color $color): RedirectResponse
    {
        $color->update($request->validated());
        $url = route('colors.show', ['color' => $color]);
        $htmlMessage = "Color <a href='$url'>#{$color->code}</a> <strong>$color->name</strong> successfully updated";
        return redirect()->route('colors.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color): RedirectResponse
    {
        // TODO soft delete
        try {
            $color->delete();
            $htmlMessage = "Color #{$color->code}
            <strong>\"{$color->name}\"</strong>
            successfully removed.";
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('colors.show', ['color' => $color]);
            $htmlMessage = "Could not remove category
            <a href='$url'>#{$color->code}</a>
            <strong>\"{$color->name}\"</strong> due to unexpected error";
            $alertType = 'danger';
        }
        return redirect()->route('colors.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }
}
