<?php 

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. If user is Admin, redirect to Admin Dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // 2. If user is Tadika, redirect to Tadika Dashboard
        if ($user->isTadika()) {
            return redirect()->route('tadika.dashboard');
        }

        // 3. User must be Alumni. Check if profile exists.
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create')->with('info', 'Please complete your alumni profile.');
        }

        return view('profile.show', compact('alumni'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        // Security check: Prevent Admin/Tadika from accessing the alumni creation form
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isTadika()) return redirect()->route('tadika.dashboard');

        if ($user->alumni) {
            return redirect()->route('profile.show');
        }

        return view('profile.create');
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->alumni) {
            return redirect()->route('profile.show');
        }

        $validator = Validator::make($request->all(), [
            'alumni_name' => 'required|string|max:255',
            'alumni_ic' => 'nullable|string|max:14',
            'grad_year' => 'required|digits:4|integer',
            'alumni_state' => 'nullable|string|max:255',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'alumni_phone' => 'required|string|max:15',
            'alumni_status' => 'required|in:studying,working',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:15',
            'alumni_address' => 'nullable|string|max:500',
            'alumni_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validator->sometimes('institution', 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'studying';
        });
        $validator->sometimes(['company', 'job_position'], 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'working';
        });

        if ($request->alumni_status === 'studying' && empty($request->institution)) {
            $validator->errors()->add('institution', 'Institution Name is required when studying.');
        }
        if ($request->alumni_status === 'working' && empty($request->company)) {
            $validator->errors()->add('company', 'Company Name is required when working.');
        }
        if ($request->alumni_status === 'working' && empty($request->job_position)) {
            $validator->errors()->add('job_position', 'Job Position is required when working.');
        }

        $validator->validate();

        $createData = [
            'user_id' => $user->user_id,
            'alumni_name' => $request->alumni_name,
            'alumni_ic' => $request->alumni_ic,
            'alumni_state' => $request->alumni_state,
            'tadika_name' => $request->tadika_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'grad_year' => $request->grad_year,
            'alumni_status' => $request->alumni_status,
            'institution' => $request->alumni_status === 'studying' ? $request->institution : null,
            'company' => $request->alumni_status === 'working' ? $request->company : null,
            'job_position' => $request->alumni_status === 'working' ? $request->job_position : null,
            'alumni_phone' => $request->alumni_phone,
            'alumni_address' => $request->alumni_address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_phone' => $request->parent_phone,
            'alumni_email' => $user->user_email
        ];

        if ($request->hasFile('alumni_photo')) {
            $filename = time() . '_' . $request->file('alumni_photo')->getClientOriginalName();
            $request->file('alumni_photo')->move(public_path('storage/alumni_photos'), $filename);
            $createData['alumni_photo'] = 'alumni_photos/' . $filename;
        }

        Alumni::create($createData);

        return redirect()->route('profile.show')->with('success', 'Alumni profile created successfully!');
    }

    public function edit()
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create')->with('error', 'Please create your alumni profile first.');
        }

        return view('profile.edit', compact('alumni'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create');
        }

        $validator = Validator::make($request->all(), [
            'alumni_name' => 'required|string|max:255',
            'grad_year' => 'required|digits:4|integer',
            'alumni_state' => 'nullable|string|max:255',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'alumni_phone' => 'required|string|max:15',
            'alumni_status' => 'required|in:studying,working',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:15',
            'alumni_ic' => 'nullable|string|max:14',
            'alumni_address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'alumni_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validator->sometimes('institution', 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'studying';
        });
        $validator->sometimes(['company', 'job_position'], 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'working';
        });

        if ($request->alumni_status === 'studying' && empty($request->institution)) {
            $validator->errors()->add('institution', 'Institution Name is required when studying.');
        }
        if ($request->alumni_status === 'working' && empty($request->company)) {
            $validator->errors()->add('company', 'Company Name is required when working.');
        }
        if ($request->alumni_status === 'working' && empty($request->job_position)) {
            $validator->errors()->add('job_position', 'Job Position is required when working.');
        }

        $validator->validate();

        $updateData = [
            'alumni_name' => $request->alumni_name,
            'grad_year' => $request->grad_year,
            'alumni_state' => $request->alumni_state,
            'tadika_name' => $request->tadika_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'alumni_phone' => $request->alumni_phone,
            'alumni_status' => $request->alumni_status,
            'institution' => $request->alumni_status === 'studying' ? $request->institution : null,
            'company' => $request->alumni_status === 'working' ? $request->company : null,
            'job_position' => $request->alumni_status === 'working' ? $request->job_position : null,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_phone' => $request->parent_phone,
            'alumni_ic' => $request->alumni_ic,
            'alumni_address' => $request->alumni_address
        ];

        if ($request->hasFile('alumni_photo')) {
            if ($alumni->alumni_photo && file_exists(public_path('storage/' . $alumni->alumni_photo))) {
                unlink(public_path('storage/' . $alumni->alumni_photo));
            }
            $filename = time() . '_' . $request->file('alumni_photo')->getClientOriginalName();
            $request->file('alumni_photo')->move(public_path('storage/alumni_photos'), $filename);
            $updateData['alumni_photo'] = 'alumni_photos/' . $filename;
        }

        $alumni->update($updateData);

        if ($user->user_name !== $request->alumni_name) {
            $user->update(['user_name' => $request->alumni_name]);
        }

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}