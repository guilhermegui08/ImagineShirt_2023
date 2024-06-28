<img src="{{ $image->fullTshirtImageUrl }}" alt="Imagem Tshirt">
@if ($allowUpload)
    <div class="mb-3 pt-3">
        <input type="file" class="form-control  @error('file_photo') is-invalid @enderror" id="inputFilePhoto" name="file_photo">
        @error('file_photo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
@endif
