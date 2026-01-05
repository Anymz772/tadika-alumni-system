<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumniController extends Controller
{
    // Display alumni list with search
    public function index(Request $request)
    {
        $query = Alumni::with('user')->latest();

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
            $query->where('current_workplace', 'like', "%{$request->workplace}%");
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'contact_number' => 'required|string|max:15',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:15',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni'
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
            'email' => $request->email
        ]);

        return redirect()->route('alumni.index')->with('success', 'Alumni created successfully.');
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
        $request->validate([
            'full_name' => 'required|string|max:255',
            'year_graduated' => 'required|digits:4|integer',
            'contact_number' => 'required|string|max:15',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $alumni->user_id,
        ]);

        // Update alumni record
        $alumni->update([
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
            'email' => $request->email,
        ]);

        // Update user email if changed
        if ($request->email !== $alumni->user->email) {
            $alumni->user->update(['email' => $request->email]);
        }

        // Update user name if full_name is different
        if ($alumni->user->name !== $request->full_name) {
            $alumni->user->update(['name' => $request->full_name]);
        }

        return redirect()->route('alumni.index')->with('success', 'Alumni updated successfully.');
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
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password reset successfully for ' . $alumni->full_name);
    }
}
