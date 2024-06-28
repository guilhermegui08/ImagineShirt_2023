<table class="table">
    <thead class="table-dark">
    <tr>
        @if ($showFoto)
            <th></th>
        @endif
        <th>Nome</th>
        <th>Email</th>
        <th>User type</th>
        <th class="button-icon-col"></th>
        @if ($showEdit)
            <th class="button-icon-col"></th>
        @endif
        @if ($showDelete)
            <th class="button-icon-col"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            @if ($showFoto)
                <td width="45">
                    @if ($user->photo_url)
                        <img src="{{ $user->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle" width="45" height="45">
                    @endif
                </td>
            @endif
            <td>{{ $user->name}}</td>
            <td>{{ $user->email }}</td>
            @if ($user->user_type == 'E')
                <td>Funcionário</td>
            @endif
            @if ($user->user_type == 'A')
                <td>Administrador</td>
            @endif
            <td class="button-icon-col">
                <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i></a>
            </td>
            @if ($showEdit)
                <td class="button-icon-col"><a class="btn btn-dark" href="{{ route('users.edit', ['user' => $user]) }}">
                        <i class="fas fa-edit"></i></a></td>
            @endif
            @if ($showDelete)
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i></button>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
