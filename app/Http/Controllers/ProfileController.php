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

        $request->validate([
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'contact_number' => 'required|string|max:15',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:15',
        ]);

        // Create alumni profile
        Alumni::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'ic_number' => $request->ic_number,
            'year_graduated' => $request->year_graduated,
            'current_workplace' => $request->current_workplace,
            'job_position' => $request->job_position,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_contact' => $request->parent_contact,
            'email' => $user->email
        ]);

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

        $request->validate([
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'contact_number' => 'required|string|max:15',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_contact' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = $request->only([
            'full_name',
            'year_graduated',
            'contact_number',
            'father_name',
            'mother_name',
            'parent_contact',
            'ic_number',
            'current_workplace',
            'job_position',
            'address'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($alumni->photo && \Storage::disk('public')->exists($alumni->photo)) {
                \Storage::disk('public')->delete($alumni->photo);
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('alumni_photos', 'public');
            $updateData['photo'] = $photoPath;
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
