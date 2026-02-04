<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show alumni profile
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            // Check if user is admin
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('profile.create')->with('info', 'Please complete your alumni profile.');
        }

        return view('profile.show', compact('alumni'));
    }

    // Create alumni profile form
    public function create()
    {
        $user = Auth::user();

        if ($user->alumni) {
            return redirect()->route('profile.show');
        }

        // Use the app layout (not cms) for alumni
        return view('profile.create');
    }

    // Store new alumni profile
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->alumni) {
            return redirect()->route('profile.show');
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'state' => 'nullable|string|max:255',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'contact_number' => 'required|string|max:15',
            'current_status' => 'required|in:studying,working',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $validator->validate();

        $createData = [
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
            'email' => $user->email
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('storage/alumni_photos'), $filename);
            $createData['photo'] = 'alumni_photos/' . $filename;
        }

        // Create alumni profile
        Alumni::create($createData);

        return redirect()->route('profile.show')->with('success', 'Alumni profile created successfully!');
    }

    // Edit alumni profile
    public function edit()
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create')->with('error', 'Please create your alumni profile first.');
        }

        return view('profile.edit', compact('alumni'));
    }

    // Update alumni profile
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create');
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'state' => 'nullable|string|max:255',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'contact_number' => 'required|string|max:15',
            'current_status' => 'required|in:studying,working',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $validator->validate();

        $updateData = [
            'full_name' => $request->full_name,
            'year_graduated' => $request->year_graduated,
            'state' => $request->state,
            'tadika_name' => $request->tadika_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'contact_number' => $request->contact_number,
            'current_status' => $request->current_status,
            'institution_name' => $request->current_status === 'studying' ? $request->institution_name : null,
            'company_name' => $request->current_status === 'working' ? $request->company_name : null,
            'job_position' => $request->current_status === 'working' ? $request->job_position : null,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_contact' => $request->parent_contact,
            'ic_number' => $request->ic_number,
            'address' => $request->address
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($alumni->photo && file_exists(public_path('storage/' . $alumni->photo))) {
                unlink(public_path('storage/' . $alumni->photo));
            }

            // Store new photo
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('storage/alumni_photos'), $filename);
            $updateData['photo'] = 'alumni_photos/' . $filename;
        }

        $alumni->update($updateData);

        // Update user name if changed
        if ($user->name !== $request->full_name) {
            $user->update(['name' => $request->full_name]);
        }

        // Update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => $request->password]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
