<?php

namespace App\Http\Controllers;

use App\Http\Requests\TshirtImageRequest;
use App\Models\Color;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TshirtImageController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $filterByCategory = $request->category ?? '';
        $filterByName = $request->name ?? '';
        $filterByDescription = $request->description ?? '';
        $tshirtImagesQuery = TshirtImage::query();
        $tshirtImagesQuery->whereNull('customer_id');
        if ($filterByCategory !== '') {
            $tshirtImagesQuery->where('category_id', $filterByCategory);
        }
        if ($filterByName !== '') {
            $tshirtImagesQuery->where('name', 'LIKE', '%'.$filterByName.'%');
        }
        if ($filterByDescription !== '') {
            $tshirtImagesQuery->where('description', 'LIKE', '%'.$filterByDescription.'%');
        }

        $user = Auth::user();

        $privateTshirtImages = TshirtImage::whereNotNull('customer_id')->get();

        $tshirtImages = $tshirtImagesQuery->paginate(29);
        return view('tshirt_images.index', compact('categories',
            'filterByCategory',
            'filterByName',
            'filterByDescription',
            'tshirtImages',
            'privateTshirtImages',
            'user'
        ));
    }

    public function show(Request $request, int $imageID): View
    {
        $image = TshirtImage::find($imageID);
        $bases = Color::all();
        $colorCode = $request->input('color') ?? '00a2f2';
        $basePreview = Color::where('code', $colorCode)->first();
        $size = $request->input('size') ?? 'M';
        return view('tshirt_images.show', compact('image','bases', 'basePreview', 'size'))->withImageId($imageID);
    }

    public function edit(Request $request, int $imageID): View
    {
        $image = TshirtImage::find($imageID);
        $categories = Category::all();
        return view('tshirt_images.edit', compact('image','categories'));
    }

    public function update(TshirtImageRequest $request, int $imageID): RedirectResponse
    {
        $formData = $request->validated();
        $image = DB::transaction(function () use ($formData, $imageID) {
            $updatedImage = TshirtImage::find($imageID);
            $updatedImage->name = $formData['name'];
            $updatedImage->description = $formData['description'];
            $updatedImage->category_id = $formData['category'];
            $updatedImage->save();
        });

        $url = route('tshirt_images.show', ['tshirt_image' => $image->id]);
        $htmlMessage = "Imagem <a href='$url'>#{$image->id}</a>
            <strong>\"{$image->name}\"</strong>
            foi atualizada com sucesso!";
        return redirect()->route('tshirt_images.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function create() {
        $image = new TshirtImage();
        $filterByCategory = '';
        $categories = Category::all();
        return view('tshirt_images.create', compact('image', 'filterByCategory', 'categories'));
    }

    public function store(TshirtImageRequest $request): RedirectResponse
    {
        $user = $request->user();
        $formData = $request->validated();
        $image = DB::transaction(function () use ($formData, $request, $user) {
            $newImage = new TshirtImage();
            $newImage->category_id = $formData['category'];
            $newImage->name = $formData['name'];
            $newImage->description = $formData['description'];
            $newImage->created_at = date('Y-m-d H:i:s');
            if($request->hasFile('file_photo') and $request->file('file_photo')->isValid()){
                $folder = $user->user_type == 'C' ? 'tshirt_images_private' : 'public/tshirt_images/';
                $path = $request->file_photo->store($folder);
                $newImage->image_url =basename($path);
            }

            if($user->user_type == 'C'){
                $newImage->customer_id = $user->id;
            }
            $newImage->save();

            return $newImage;
        });
        $url = route('tshirt_images.show', ['tshirt_image' => $image->id]);
        $htmlMessage = "Imagem <a href='$url'>#{$image->id}</a>
            <strong>\"{$image->name}\"</strong>
            foi criada com sucesso!";
        return redirect()->route('tshirt_images.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(int $imageId): RedirectResponse{
        $image = TshirtImage::find($imageId);

        Storage::delete('public/tshirt_images/'.$image->image_url);
        $image->delete();

        $htmlMessage='Imagem'.$image->name.' Apagada';
        return redirect()->route('tshirt_images.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
}
