<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class AlumniRegisterController extends Controller
{
    public function create()
    {
        return view('auth.alumni-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class, 'user_email'),
                Rule::unique('alumni', 'alumni_email'),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alumni_name' => ['required', 'string', 'max:255'],
            'alumni_ic' => ['nullable', 'string', 'regex:/^\d{6}-\d{2}-\d{4}$/', 'max:14'],
            'alumni_state' => ['nullable', 'string', 'max:255'],
            'tadika_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female'],
            'age' => ['nullable', 'integer', 'min:1', 'max:100'],
            'grad_year' => ['nullable', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y')],
            'alumni_phone' => ['nullable', 'string', 'max:15'],
            'alumni_status' => ['nullable', 'in:studying,working'],
            'institution' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'job_position' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:15'],
            'alumni_address' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'user_name' => $request->user_name,
                    'user_email' => $request->user_email,
                    'password' => Hash::make($request->password),
                    'user_role' => 'alumni',
                ]);

                Alumni::create([
                    'user_id' => $user->user_id,
                    'alumni_name' => $request->alumni_name,
                    'alumni_ic' => $request->alumni_ic,
                    'alumni_state' => $request->alumni_state,
                    'tadika_name' => $request->tadika_name,
                    'gender' => $request->gender,
                    'age' => $request->age,
                    'grad_year' => $request->grad_year,
                    'alumni_status' => $request->alumni_status,
                    'institution' => $request->institution,
                    'company' => $request->company,
                    'job_position' => $request->job_position,
                    'alumni_phone' => $request->alumni_phone,
                    'alumni_address' => $request->alumni_address,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'parent_phone' => $request->parent_phone,
                    'alumni_email' => $request->user_email
                ]);

                return $user;
            });
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->withErrors(['alumni_create' => 'Registration failed while creating alumni profile. Please try again.'])
                ->withInput();
        }

        // Log in the user
        auth()->login($user);

        // Redirect to profile
        return redirect()->route('profile.show')->with('success', 'Registration successful! Welcome to Tadika Alumni System.');
    }
}
