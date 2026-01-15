<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AlumniRegisterController extends Controller
{
    public function create()
    {
        return view('auth.alumni-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'full_name' => ['required', 'string', 'max:255'],
            'year_graduated' => ['nullable', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y')],
            'contact_number' => ['nullable', 'string', 'max:15'],
            'current_status' => ['nullable', 'in:studying,working,not_specified'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'job_position' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'parent_contact' => ['nullable', 'string', 'max:15'],
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
        ]);

        // Create alumni profile
        Alumni::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'ic_number' => $request->ic_number,
            'year_graduated' => $request->year_graduated,
            'current_status' => $request->current_status,
            'institution_name' => $request->institution_name,
            'company_name' => $request->company_name,
            'job_position' => $request->job_position,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_contact' => $request->parent_contact,
            'email' => $request->email
        ]);

        // Log in the user
        auth()->login($user);

        // Redirect to profile (alumni already has profile from registration)
        return redirect()->route('profile.show')->with('success', 'Registration successful! Welcome to Tadika Alumni System.');
    }
}
