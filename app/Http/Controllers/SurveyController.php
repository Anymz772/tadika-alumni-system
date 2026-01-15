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
        return view('survey.create');
    }

    // Store direct registration (public)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'ic_number' => 'required|numeric|digits:12',
            'year_graduated' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'contact_number' => 'required|digits_between:10,15',
            'current_status' => 'required|in:studying,working',
            'address' => 'required|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|digits_between:10,15',
        ], [
            'email.unique' => 'This email is already registered in our system.',
            'current_status.required' => 'Please select whether you are currently studying or working.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Add conditional validation based on current_status
        $validator->sometimes('institution_name', 'required|string|max:255', function ($input) {
            return $input->current_status === 'studying';
        });

        $validator->sometimes('company_name', 'required|string|max:255', function ($input) {
            return $input->current_status === 'working';
        });

        $validator->sometimes('job_position', 'required|string|max:255', function ($input) {
            return $input->current_status === 'working';
        });

        // Add custom error messages for conditional fields
        if ($request->current_status === 'studying' && empty($request->institution_name)) {
            $validator->errors()->add('institution_name', 'Institution Name is required when studying.');
        }

        if ($request->current_status === 'working' && empty($request->company_name)) {
            $validator->errors()->add('company_name', 'Company Name is required when working.');
        }

        if ($request->current_status === 'working' && empty($request->job_position)) {
            $validator->errors()->add('job_position', 'Job Title is required when working.');
        }

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
        return view('survey.thankyou');
    }

    // ================= ADMIN FUNCTIONS =================

    // List all survey submissions (admin only)
    public function index(Request $request)
    {
        $query = AlumniSurvey::latest();

        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        $surveys = $query->paginate(20);

        return view('survey.index', compact('surveys'));
    }

    // Show single survey (admin only)
    public function show(AlumniSurvey $survey)
    {
        return view('survey.show', compact('survey'));
    }

    // Approve survey and create alumni account (admin only)
    public function approve(Request $request, AlumniSurvey $survey)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if email already exists in users table
        if (User::where('email', $survey->email)->exists()) {
            return back()->with('error', 'A user with this email already exists in the system.');
        }

        // Generate random password
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

        // Create user account
        $user = User::create([
            'name' => $survey->full_name,
            'email' => $survey->email,
            'password' => Hash::make($password),
            'role' => 'alumni',
            'email_verified_at' => now(),
        ]);

        // Create alumni profile
        Alumni::create([
            'user_id' => $user->id,
            'full_name' => $survey->full_name,
            'ic_number' => $survey->ic_number,
            'year_graduated' => $survey->year_graduated,
            'current_status' => $survey->current_status,
            'institution_name' => $survey->current_status === 'studying' ? $survey->institution_name : null,
            'company_name' => $survey->current_status === 'working' ? $survey->company_name : null,
            'job_position' => $survey->current_status === 'working' ? $survey->job_position : null,
            'contact_number' => $survey->contact_number,
            'address' => $survey->address,
            'father_name' => $survey->father_name,
            'mother_name' => $survey->mother_name,
            'parent_contact' => $survey->parent_contact,
            'email' => $survey->email,
        ]);

        // Update survey status
        $survey->update([
            'status' => 'approved',
            'admin_notes' => $request->notes ?? 'Approved and account created. Password: ' . $password,
        ]);

        // Send welcome email with credentials (optional)
        // $this->sendWelcomeEmail($user, $password);

        return back()->with('success', 'Survey approved! Alumni account created. Password: ' . $password);
    }

    // Reject survey (admin only)
    public function reject(Request $request, AlumniSurvey $survey)
    {
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $survey->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes,
        ]);

        // Send rejection email (optional)
        // $this->sendRejectionEmail($survey, $request->notes);

        return back()->with('success', 'Survey rejected successfully.');
    }

    // Delete survey (admin only)
    public function destroy(AlumniSurvey $survey)
    {
        $survey->delete();

        return redirect()->route('survey.index')->with('success', 'Survey deleted successfully.');
    }
}
