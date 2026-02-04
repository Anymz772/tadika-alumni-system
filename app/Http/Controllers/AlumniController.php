<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AlumniController extends Controller
{
    // Display alumni list with search
    public function index(Request $request)
    {
        $query = Alumni::with('user')->orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('year_from') && !empty($request->year_from)) {
            $query->where('year_graduated', '>=', $request->year_from);
        }

        if ($request->has('year_to') && !empty($request->year_to)) {
            $query->where('year_graduated', '<=', $request->year_to);
        }

        if ($request->has('workplace') && !empty($request->workplace)) {
            $query->where(function ($q) use ($request) {
                $q->where('current_workplace', 'like', "%{$request->workplace}%")
                    ->orWhere('company_name', 'like', "%{$request->workplace}%")
                    ->orWhere('institution_name', 'like', "%{$request->workplace}%");
            });
        }

        $alumni = $query->paginate(10)->withQueryString();

        return view('alumni.index', compact('alumni'));
    }

    // Show create form
    public function create()
    {
        return view('alumni.create');
    }

    // Store new alumni
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'ic_number' => 'required|numeric|digits:12',
            'year_graduated' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'contact_number' => 'required|digits_between:10,15',
            'current_status' => 'required|in:studying,working',
            'institution_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|digits_between:10,15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'email.unique' => 'This email is already registered in our system.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'alumni'
        ]);

        // Prepare alumni data
        $alumniData = [
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
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('storage/alumni_photos'), $filename);
            $alumniData['photo'] = 'alumni_photos/' . $filename;
        }

        // Create alumni profile
        $alumni = Alumni::create($alumniData);

        return redirect()->route('alumni.show', $alumni->id)->with('success', 'Alumni account created successfully!');
    }

    // Show single alumni (admin view)
    public function show(Alumni $alumni)
    {
        return view('alumni.show', compact('alumni'));
    }

    // Show edit form
    public function edit(Alumni $alumni)
    {
        return view('alumni.edit', compact('alumni'));
    }

    // Update alumni
    public function update(Request $request, Alumni $alumni)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'ic_number' => 'required|numeric|digits:12',
            'year_graduated' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($alumni->user_id),
            ],
            'contact_number' => 'required|digits_between:10,15',
            'current_status' => 'required|in:studying,working',
            'institution_name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|digits_between:10,15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email is already registered in our system.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle photo upload
        $updateData = [
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
            'email' => $request->email,
        ];

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

        // 1. Update the profile details in the 'alumnis' table
        $alumni->update($updateData);

        // 2. Prepare the data for the 'users' table (Login table)
        $userUpdates = [
            'email' => $request->email,
            'name' => $request->full_name,
        ];

        // 3. ONLY update password if the user actually typed one
        if ($request->filled('password')) {
            $userUpdates['password'] = $request->password;
        }

        // 4. Update the actual User account linked to this alumni
        $alumni->user->update($userUpdates);

        return redirect()->route('alumni.index')->with('success', 'Alumni and Login credentials updated successfully.');
    }

    // Delete alumni
    public function destroy(Alumni $alumni)
    {
        $alumni->user->delete();

        return redirect()->route('alumni.index')->with('success', 'Alumni deleted successfully.');
    }

    // Reset password for alumni
    public function resetPassword(Request $request, Alumni $alumni)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $alumni->user->update([
            'password' => $request->password
        ]);

        return back()->with('success', 'Password reset successfully for ' . $alumni->full_name);
    }
}
