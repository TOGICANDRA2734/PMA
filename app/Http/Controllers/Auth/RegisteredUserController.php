<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'namauser' => 'required|string|max:15|unique:pma_user',
            'nama' => 'required|string|max:50',
            'golongan' => 'required|int|max:50',
            'pic' => 'required|string',
            'kodesite' => 'required|string|max:1',
            'sandi' => ['required', Rules\Password::defaults()],
        ]);

        $user =  User::create([
            'namauser' => $request->namauser,
            'nama' => $request->nama,
            'golongan' => $request->golongan,
            'pic' => $request->pic,
            'kodesite' => $request->kodesite,
            'sandi' => md5($request->sandi),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}