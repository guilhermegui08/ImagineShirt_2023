@extends('template.layout')
{{ $category = \App\Models\Category::find($image->category_id)}}
@section('titulo', 'Add Thsirt Image')
@section('main')

    <form action="{{ route('tshirt_images.update',['tshirt_image'=>$image->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('tshirt_images.shared.fields')
        <label for="inputCategory" class="form-label">Category</label>
        <select class="form-select" name="category" id="inputCategory">
            <option {{ old('category', $image->category_id) === '' ? 'selected' : '' }} value="{{ $image->category_id }}"> {{ $category->name }}</option>
            @foreach($categories as $category)
                @if($category->id != $image->category_id)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
            @endforeach
        </select>
        <div class="card" style="width: 300px; margin: 20px 0">
            @include('tshirt_images.shared.fields_photo', [
        'image' => $image,
        'allowUpload' => false,
    ])
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('tshirt_images.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
