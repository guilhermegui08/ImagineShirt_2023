<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::query()->paginate(20);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());
        $url = route('categories.show', ['category' => $category]);
        $htmlMessage = "Category <a href='$url'>#{$category->id}</a> <strong>$category->name</strong> successfully created";
        return redirect()->route('categories.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        $url = route('categories.show', ['category' => $category]);
        $htmlMessage = "Category <a href='$url'>#{$category->id}</a> <strong>$category->name</strong> successfully updated";
        return redirect()->route('categories.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            // TODO soft delete
            $category->delete();
            $htmlMessage = "Category #{$category->id}
            <strong>\"{$category->name}\"</strong>
            successfully removed.";
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('categories.show', ['category' => $category]);
            $htmlMessage = "Could not remove category
            <a href='$url'>#{$category->id}</a>
            <strong>\"{$category->name}\"</strong> due to unexpected error";
            $alertType = 'danger';
        }
        return redirect()->route('categories.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }
}
