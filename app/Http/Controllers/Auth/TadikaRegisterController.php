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
            'tadika_reg_no' => ['required', 'string', 'max:100', 'unique:tadikas,tadika_reg_no'],
            'tadika_district' => ['required', 'string', 'max:255'],
            'tadika_state' => ['required', 'string', 'max:255'],
            // Validate against the correct `user_email` column in the `users` table
            'tadika_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,user_email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tadika_address' => ['nullable', 'string'],
            'tadika_phone' => ['nullable', 'string', 'max:30'],
            'tadika_owner' => ['nullable', 'string', 'max:255'],
            'tadika_location' => ['nullable', 'string', 'max:255'],
            'tadika_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $tadika_logoPath = null;
        if ($request->hasFile('tadika_logo')) {
            $tadika_logoPath = $request->file('tadika_logo')->store('tadika_photos', 'public');
        }

        DB::transaction(function () use ($request, $tadika_logoPath) {
            $user = User::create([
                'user_name' => $request->tadika_name,
                'user_email' => $request->tadika_email, // Map login email here
                'password' => Hash::make($request->password),
                'user_role' => 'tadika',
            ]);

            Tadika::create([
                'tadika_name' => $request->tadika_name,
                'tadika_reg_no' => $request->tadika_reg_no,
                'tadika_district' => $request->tadika_district,
                'tadika_state' => $request->tadika_state,
                'tadika_email' => $request->tadika_email, // Store the tadika's business email here
                'tadika_address' => $request->tadika_address,
                'tadika_phone' => $request->tadika_phone,
                'tadika_owner' => $request->tadika_owner,
                'tadika_location' => $request->tadika_location,
                'tadika_logo' => $tadika_logoPath,
                'owner_user_id' => $user->user_id, // Linked to the new user_id column
            ]);
        });

        return redirect()->route('tadika.register.success')
            ->with('success', 'Registration successful! Your Tadika account has been created.');
    }
}