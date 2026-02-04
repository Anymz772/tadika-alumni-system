<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlumniRegisterController extends Controller
{
    /**
     * Show public alumni registration form
     */
    public function create()
    {
        return view('auth.alumni-register'); // your registration form
    }

    /**
     * Handle public alumni registration submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'ic_number' => ['nullable', 'string', 'regex:/^\d{6}-\d{2}-\d{4}$/', 'max:14'],
            'state' => 'nullable|string|max:255',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'year_graduated' => 'nullable|digits:4|integer|min:2000|max:' . date('Y'),
            'contact_number' => 'nullable|digits_between:10,15',
            'current_status' => 'nullable|in:studying,working,not_specified',
            'address' => 'nullable|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|digits_between:10,15',
            'institution_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_position' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'This email is already registered in our system.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Conditional validation based on current_status
        $validator->sometimes('institution_name', 'required|string|max:255', function ($input) {
            return $input->current_status === 'studying';
        });

        $validator->sometimes(['company_name','job_position'], 'required|string|max:255', function ($input) {
            return $input->current_status === 'working';
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create User account
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'email_verified_at' => now(),
        ]);

        // Create Alumni profile
        Alumni::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'ic_number' => $request->ic_number,
            'state' => $request->state,
            'tadika_name' => $request->tadika_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'year_graduated' => $request->year_graduated,
            'current_status' => $request->current_status,
            'institution_name' => $request->current_status === 'studying' ? $request->institution_name : null,
            'company_name' => $request->current_status === 'working' ? $request->company_name : null,
            'job_position' => $request->current_status === 'working' ? $request->job_position : null,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_contact' => $request->parent_contact,
            'email' => $request->email,
        ]);

        return redirect()->route('alumni.register.thankyou');
    }

    /**
     * Show registration success page
     */
    public function thankyou()
    {
        return view('auth.register-success'); // thank-you page
    }
}
