<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tadika;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TadikaRegisterController extends Controller
{
    public function create()
    {
        return view('auth.tadika-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tadika_name' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:100', 'unique:tadikas,registration_number'],
            'district' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('tadika_photos', 'public');
        }

        DB::transaction(function () use ($request, $logoPath) {
            $user = User::create([
                'name' => $request->tadika_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'tadika',
            ]);

            Tadika::create([
                'name' => $request->tadika_name,
                'registration_number' => $request->registration_number,
                'district' => $request->district,
                'state' => $request->state,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'owner_name' => $request->owner_name,
                'location' => $request->location,
                'logo' => $logoPath,
                'owner_user_id' => $user->id,
            ]);
        });

        return redirect()->route('tadika.register.success')
            ->with('success', 'Registration successful! Your Tadika account has been created.');
    }
}
