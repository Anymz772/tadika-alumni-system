<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AlumniController extends Controller
{
    // Display alumni list with search
    public function index(Request $request)
    {
        // Updated id to alumni_id
        $query = Alumni::with('user')->orderBy('alumni_id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('alumni_name', 'like', "%{$search}%")
                    ->orWhere('alumni_email', 'like', "%{$search}%")
                    ->orWhere('alumni_phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('year_from') && !empty($request->year_from)) {
            $query->where('grad_year', '>=', $request->year_from);
        }

        if ($request->has('year_to') && !empty($request->year_to)) {
            $query->where('grad_year', '<=', $request->year_to);
        }

        if ($request->has('workplace') && !empty($request->workplace)) {
            $query->where(function ($q) use ($request) {
                // Changed current_workplace to workplace
                $q->where('workplace', 'like', "%{$request->workplace}%")
                    ->orWhere('company', 'like', "%{$request->workplace}%")
                    ->orWhere('institution', 'like', "%{$request->workplace}%");
            });
        }

        $alumni = $query->paginate(10)->withQueryString();

        return view('alumni.index', compact('alumni'));
    }

    public function create()
    {
        return view('alumni.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255',
            'user_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'user_email'), // Target user_email column
                Rule::unique('alumni', 'alumni_email'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'alumni_name' => 'required|string|max:255',
            'alumni_ic' => 'required|string|max:14',
            'grad_year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'tadika_name' => 'nullable|string|max:255',
            'alumni_state' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'alumni_phone' => 'required|digits_between:10,15',
            'alumni_status' => 'required|in:studying,working',
            'institution' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'alumni_address' => 'required|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|digits_between:10,15',
            'alumni_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'user_email.unique' => 'This email is already registered in our system.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $alumni = DB::transaction(function () use ($request) {
                $user = User::create([
                    'user_name' => $request->user_name,
                    'user_email' => $request->user_email,
                    'password' => Hash::make($request->password),
                    'user_role' => 'alumni'
                ]);

                $alumniData = [
                    'user_id' => $user->user_id,
                    'alumni_name' => $request->alumni_name,
                    'alumni_ic' => $request->alumni_ic,
                    'tadika_name' => $request->tadika_name,
                    'alumni_state' => $request->alumni_state,
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
                    'alumni_email' => $request->user_email // Can sync with user_email
                ];

                if ($request->hasFile('alumni_photo')) {
                    $filename = time() . '_' . $request->file('alumni_photo')->getClientOriginalName();
                    $request->file('alumni_photo')->move(public_path('storage/alumni_photos'), $filename);
                    $alumniData['alumni_photo'] = 'alumni_photos/' . $filename;
                }

                return Alumni::create($alumniData);
            });
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->withErrors(['alumni_create' => 'Unable to create alumni profile. Please check the form and try again.'])
                ->withInput();
        }

        return redirect()->route('alumni.show', $alumni->alumni_id)->with('success', 'Alumni account created successfully!');
    }

    public function show(Alumni $alumni)
    {
        return view('alumni.show', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        return view('alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validator = Validator::make($request->all(), [
            'alumni_name' => 'required|string|max:255',
            'alumni_ic' => 'required|string|max:14',
            'grad_year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'tadika_name' => 'nullable|string|max:255',
            'alumni_state' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'alumni_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'user_email')->ignore($alumni->user_id, 'user_id'),
            ],
            'alumni_phone' => 'required|digits_between:10,15',
            'alumni_status' => 'required|in:studying,working',
            'institution' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job_position' => 'nullable|string|max:255',
            'alumni_address' => 'required|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|digits_between:10,15',
            'alumni_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'alumni_name' => $request->alumni_name,
            'alumni_ic' => $request->alumni_ic,
            'grad_year' => $request->grad_year,
            'tadika_name' => $request->tadika_name,
            'alumni_state' => $request->alumni_state,
            'gender' => $request->gender,
            'age' => $request->age,
            'alumni_status' => $request->alumni_status,
            'institution' => $request->institution,
            'company' => $request->company,
            'job_position' => $request->job_position,
            'alumni_phone' => $request->alumni_phone,
            'alumni_address' => $request->alumni_address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_phone' => $request->parent_phone,
            'alumni_email' => $request->alumni_email,
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

        $userUpdates = [
            'user_email' => $request->alumni_email,
            'user_name' => $request->alumni_name,
        ];

        if ($request->filled('password')) {
            $userUpdates['password'] = Hash::make($request->password);
        }

        $alumni->user->update($userUpdates);

        return redirect()->route('alumni.index')->with('success', 'Alumni and Login credentials updated successfully.');
    }

    public function destroy(Alumni $alumni)
    {
        $alumni->user->delete();
        return redirect()->route('alumni.index')->with('success', 'Alumni deleted successfully.');
    }

    public function resetPassword(Request $request, Alumni $alumni)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $alumni->user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password reset successfully for ' . $alumni->alumni_name);
    }
}
