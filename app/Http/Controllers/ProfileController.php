<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show alumni profile
    public function show()
    {
        $user = Auth::user();
        $alumni = Auth::user()->alumni;
        
        if (!$alumni) {
            return redirect()->route('profile.create')->with('info', 'Please complete your alumni profile.');
        }
        
        // Use the app layout (not cms) for alumni
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
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:15',
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
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'contact_number' => 'required|string|max:15',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:15',
        ]);

        $alumni->update($request->all());

        // Update user name if changed
        if ($user->name !== $request->full_name) {
            $user->update(['name' => $request->full_name]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}