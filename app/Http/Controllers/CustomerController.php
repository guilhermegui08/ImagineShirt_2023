<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('administrate');
        $filterByNif = $request->nif ?? '';
        $filterByNome = $request->nome ?? '';
        $customerQuery = Customer::query();
        if ($filterByNif !== '') {
            $customerQuery->where('nif', $filterByNif);
        }
        if ($filterByNome !== '') {
            $userIds = User::where('users.name', 'like', "%$filterByNome%")->pluck('users.id');
            $customerQuery->whereIntegerInRaw('customers.id', $userIds);
        }
        $customers = $customerQuery->paginate(10);
        return view('customers.index', compact(
            'customers',
            'filterByNif',
            'filterByNome'
        ));
    }

    public function create(): View
    {
        $customer = new Customer();
        $user = new User();
        $customer->user = $user;
        return view('customers.create', compact('customer'));
    }
    public function store(CustomerRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $customer = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->user_type = 'C';
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->password = Hash::make($formData['password_inicial']);
            $newUser->save();
            $newCustomer = new Customer();
            $newCustomer->id = $newUser->id;
            $newCustomer->nif = $formData['nif'];
            $newCustomer->address = $formData['address'];
            $newCustomer->default_payment_type = $formData['default_payment_type'];
            $newCustomer->save();
            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/photos/');
                $newUser->photo_url = basename($path);
                $newUser->save();
            }
            return $newCustomer;
        });
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'>#{$customer->id}</a>
            <strong>\"{$customer->user->name}\"</strong>
            foi criada com sucesso!";
        return redirect()->route('customers.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }
    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $formData = $request->validated();
        $customer = DB::transaction(function () use ($formData, $customer, $request) {
            $customer->nif = $formData['nif'];
            $customer->address = $formData['address'];
            $customer->default_payment_type = $formData['default_payment_type'];
            $customer->save();
            $user = $customer->user;
            $user->user_type = 'C';
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
            return $customer;
        });
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'>#{$customer->id}</a>
<strong>\"{$customer->user->name}\"</strong>
foi alterado com sucesso!";
        return redirect()->route('customers.show', ['customer' => $customer])
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $this->authorize('administrate');
        try {
            $customer->delete();
            $htmlMessage = "Customer #{$customer->id}
            <strong>\"{$customer->nome}\"</strong>
            foi apagado com sucesso!";
            $user = $customer->user;
            if ($user->photo_url) {
                Storage::delete('public/photos/' . $user->photo_url);
            }
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('customers.show', ['customer' => $customer]);
            $htmlMessage = "Não foi possível apagar o customer
            <a href='$url'>#{$customer->id}</a>
            <strong>\"{$customer->user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect()->route('customers.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function show(Customer $customer): View
    {
        $this->authorize('cliente');
        return view('customers.show')->withCustomer($customer);
    }

    public function destroy_foto(Customer $customer): RedirectResponse
    {
        if ($customer->user->photo_url) {
            Storage::delete('public/photos/' . $customer->user->photo_url);
            $customer->user->photo_url = null;
            $customer->user->save();
        }
        return redirect()->route('customers.edit', ['customer' => $customer])
            ->with('alert-msg', 'Foto do customer "' . $customer->user->name .
                '" foi removida!')
            ->with('alert-type', 'success');
    }
}


