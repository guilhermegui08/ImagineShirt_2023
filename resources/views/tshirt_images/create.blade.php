@extends('template.layout')
@section('titulo', 'Add Thsirt Image')
@section('main')
            <form action="{{ route('tshirt_images.store', ['user'=>Auth::user()]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('tshirt_images.shared.fields')
                <label for="inputCategory" class="form-label">Category</label>
                <select class="form-select" name="category" id="inputCategory">
                    @foreach($categories as $category)
                        <option {{ old('category', $filterByCategory) == $category->id ? 'selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                    <div class="card" style="width: 300px; margin: 20px 0">
                        @include('tshirt_images.shared.fields_photo', [
                    'image' => $image,
                    'allowUpload' => true,
                ])
                    </div>
                <button type="submit" class="btn btn-success">Add</button>
                <a href="{{ route('tshirt_images.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
@endsection
