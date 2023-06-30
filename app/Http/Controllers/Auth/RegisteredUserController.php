<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Psr7\Message;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'gender'            => ['required', 'string', 'max:255'],
            'address'           => ['required', 'string', 'max:255'],
            'phone_number'      => ['required', 'string', 'unique:'.User::class],
            'user_type'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar_url'        => 'required|file|mimes:jpeg,png,jpg'
        ]);

        $avatar = null;
        if($request->hasFile('avatar_url')){
            $avatar = $request->avatar_url->store('avatar', 'public');
        }

        $user = User::create([
            'avatar_url'        => $avatar,
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'gender'            => $request->gender,
            'address'           => $request->address,
            'phone_number'      => $request->phone_number,
            'user_type'         => $request->user_type,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
