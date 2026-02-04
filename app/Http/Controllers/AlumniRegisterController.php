<?php

namespace App\Http\Controllers;

use App\Models\AlumniSurvey;
use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SurveyController extends Controller
{
    // Show survey form (public)
    public function create()
    {
        return view('auth.alumni-register');
    }

    // Store direct registration (public)
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
        ], [
            'email.unique' => 'This email is already registered in our system.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Add conditional validation based on current_status (only if status is provided)
        $validator->sometimes('institution_name', 'nullable|string|max:255', function ($input) {
            return $input->current_status === 'studying';
        });

        $validator->sometimes('company_name', 'nullable|string|max:255', function ($input) {
            return $input->current_status === 'working';
        });

        $validator->sometimes('job_position', 'nullable|string|max:255', function ($input) {
            return $input->current_status === 'working';
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user account directly
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'email_verified_at' => now(),
        ]);

        // Create alumni profile directly
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

        return redirect()->route('login')
            ->with('status', 'Registration successful! You can now log in with your email and password.');
    }

    // Thank you page
    public function thankyou()
    {
        return view('auth.register-success');

    }

    // ================= ADMIN FUNCTIONS =================

    // List all survey submissions (admin only)

    // Show single survey (admin only)

    // Approve survey and create alumni account (admin only)

    // Reject survey (admin only)

    // Delete survey (admin only)
    public function destroy(AlumniSurvey $survey)
    {
        $survey->delete();

        return redirect()->route('survey.index')->with('success', 'Survey deleted successfully.');
    }
}
