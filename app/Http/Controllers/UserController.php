<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(Request $request): View
    {
        $filterByUserType = $request->user_type ?? '';
        $filterByNome = $request->nome ?? '';
        $userQuery = User::query()->whereIn('user_type', ['E', 'A']);
        if ($filterByUserType !== '') {
            $userQuery->where('user_type', $filterByUserType);
        }
        if ($filterByNome !== '') {
            $userIds = User::where('users.name', 'like', "%$filterByNome%")->pluck('users.id');
            $userQuery->whereIntegerInRaw('users.id', $userIds);
        }
        $users = $userQuery->paginate(10);
        return view('users.index', compact(
            'users',
            'filterByUserType',
            'filterByNome'
        ));
    }

    public function create(): View
    {
        $user = new User();
        return view('users.create', compact('user'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->user_type = $formData['user_type'];
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->password = Hash::make($formData['password_inicial']);
            $newUser->save();
            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/photos/');
                $newUser->photo_url = basename($path);
                $newUser->save();
            }
            return $newUser;
        });
        $url = route('users.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'>#{user->id}</a>
            <strong>\"{$user->name}\"</strong>
            foi criado com sucesso!";
        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user, $request) {

            $user->user_type = $formData['user_type'];
            $user->blocked = $formData['blocked'];
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->save();
            if ($request->hasFile('file_foto')) {
                if ($user->photo_url) {
                    Storage::delete('public/photos/' . $user->photo_url);
                }
                $path = $request->file_foto->store('public/photos/');
                $user->photo_url = basename($path);
                $user->save();
            }
            return $user;
        });
        $url = route('users.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'>#{$user->id}</a>
<strong>\"{$user->name}\"</strong>
foi alterado com sucesso!";
        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            $htmlMessage = "User #{$user->id}
            <strong>\"{$user->name}\"</strong>
            foi apagado com sucesso!";
            $user = $user;
            if ($user->photo_url) {
                Storage::delete('public/photos/' . $user->photo_url);
            }
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('users.show', ['user' => $user]);
            $htmlMessage = "Não foi possível apagar o user
            <a href='$url'>#{$user->id}</a>
            <strong>\"{$user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function show(User $user): View
    {
        return view('users.show')->withUser($user);
    }

    public function destroy_foto(User $user): RedirectResponse
    {
        if ($user->photo_url) {
            Storage::delete('public/photos/' . $user->photo_url);
            $user->photo_url = null;
            $user->save();
        }
        return redirect()->route('users.edit', ['user' => $user])
            ->with('alert-msg', 'Foto do user "' . $user->name .
                '" foi removida!')
            ->with('alert-type', 'success');
    }
}
