<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'Nik' => ['required', 'string', 'max:16', 'unique:'.profile::class],
            'alamat' => ['required', 'string', 'max:255'],
            'no_telp' => ['required', 'string', 'max:13', 'unique:'.profile::class],
            'foto_profil' => ['nullable', 'image', 'max:5000'],
        ]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $profileData = [
                'user_id' => $user->id,
                'Nik' => $request->Nik,
                'name' => $request->name,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ];
            if ($request->hashFile('foto_profil')) {
                $profileData['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
            }

            $user->profile()->create($profileData);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
