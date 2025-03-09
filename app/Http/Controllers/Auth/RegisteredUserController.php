<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $avatar = $this->getRandomAvatar($request->gender);

        $user = User::create([
            'name' => $request->name,
            'username' => $this->generateUniqueUsername($request),
            'email' => $request->email,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'avatar' => $avatar
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function generateUniqueUsername(Request $request, $addition = null): string
    {
        $email = substr($request->input('email'), 0, strpos($request->input('email'), '@'))  . $addition;

        if (User::where('username', $email)->doesntExist()) {
            return $email;
        }

        return $this->generateUniqueUsername($request, $addition ? ++$addition : 1);
    }

    public function getRandomAvatar($gender) {
        return 'avatars/default/' . $gender . '-' . rand(1, 3) . '.jpg';
    }
}
