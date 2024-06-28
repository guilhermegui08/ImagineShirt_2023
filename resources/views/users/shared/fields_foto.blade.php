<img src="{{ $user->fullPhotoUrl }}" alt="Avatar" class="rounded-circle img-thumbnail">
@if ($allowUpload)
    <div class="mb-3 pt-3">
        <input type="file" class="form-control id="inputFileFoto" @error('file_foto') is-invalid @enderror" name="file_foto">
        @error('file_foto')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
@endif
@if (($allowDelete ?? false) && $user->photo_url)
    @if ($user->customer)
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal"
                data-action="{{ route('customers.foto.destroy', ['customer' => $user->customer]) }}"
                data-msgLine2="Quer realmente apagar a fotografia do customer <strong>{{ $user->name }}</strong>?">
            Apagar Foto
        </button>
    @endif
    @if ($user->user_type == 'A')
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal"
                data-action="{{ route('users.foto.destroy', ['user' => $user]) }}"
                data-msgLine2="Quer realmente apagar a fotografia do administrador <strong>{{ $user->name }}</strong>?">
            Apagar Foto
        </button>
    @endif
    @if ($user->user_type == 'E')
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal"
                data-action="{{ route('users.foto.destroy', ['user' => $user]) }}"
                data-msgLine2="Quer realmente apagar a fotografia do funcionário <strong>{{ $user->name }}</strong>?">
            Apagar Foto
        </button>
    @endif
@endif
