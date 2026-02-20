<?php

namespace App\Http\Controllers;

use App\Models\Tadika;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TadikaAdminController extends Controller
{
    // Display tadika list with search
    public function index(Request $request)
    {
        $query = Tadika::with('owner')->orderBy('tadika_id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tadika_name', 'like', "%{$search}%")
                    ->orWhere('tadika_email', 'like', "%{$search}%")
                    ->orWhere('tadika_phone', 'like', "%{$search}%")
                    ->orWhere('tadika_address', 'like', "%{$search}%");
            });
        }

        if ($request->has('district') && !empty($request->district)) {
            $query->where('tadika_district', 'like', "%{$request->district}%");
        }

        if ($request->has('state') && !empty($request->state)) {
            $query->where('tadika_state', 'like', "%{$request->state}%");
        }

        $tadikas = $query->paginate(10)->withQueryString();

        return view('tadika.index', compact('tadikas'));
    }

    public function create()
    {
        return view('tadika.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tadika_name' => 'required|string|max:255',
            'tadika_reg_no' => 'required|string|max:50|unique:tadikas',
            'tadika_address' => 'required|string|max:500',
            'tadika_district' => 'required|string|max:100',
            'tadika_state' => 'required|string|max:100',
            'tadika_postcode' => 'required|string|max:10',
            'tadika_phone' => 'required|digits_between:10,15',
            'tadika_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('tadikas'),
            ],
            'tadika_location' => 'nullable|string|max:255',
            'tadika_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_name' => 'required|string|max:255',
            'owner_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'user_email'),
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $tadika = DB::transaction(function () use ($request) {
                // Create owner user
                $owner = User::create([
                    'user_name' => $request->owner_name,
                    'user_email' => $request->owner_email,
                    'password' => Hash::make($request->password),
                    'user_role' => 'tadika'
                ]);

                $tadikaData = [
                    'tadika_name' => $request->tadika_name,
                    'tadika_reg_no' => $request->tadika_reg_no,
                    'tadika_address' => $request->tadika_address,
                    'tadika_district' => $request->tadika_district,
                    'tadika_state' => $request->tadika_state,
                    'tadika_postcode' => $request->tadika_postcode,
                    'tadika_phone' => $request->tadika_phone,
                    'tadika_email' => $request->tadika_email,
                    'tadika_location' => $request->tadika_location,
                    'owner_user_id' => $owner->user_id,
                    'tadika_owner' => $request->owner_name,
                ];

                if ($request->hasFile('tadika_logo')) {
                    $filename = time() . '_' . $request->file('tadika_logo')->getClientOriginalName();
                    $request->file('tadika_logo')->move(public_path('storage/tadika_logos'), $filename);
                    $tadikaData['tadika_logo'] = 'tadika_logos/' . $filename;
                }

                return Tadika::create($tadikaData);
            });

            return redirect()->route('tadika.show', $tadika->tadika_id)->with('success', 'Tadika account created successfully!');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->withErrors(['tadika_create' => 'Unable to create tadika. Please check the form and try again.'])
                ->withInput();
        }
    }

    public function show(Tadika $tadika)
    {
        $tadika->load('owner', 'alumni');
        return view('tadika.show', compact('tadika'));
    }

    public function edit(Tadika $tadika)
    {
        $tadika->load('owner');
        return view('tadika.edit', compact('tadika'));
    }

    public function update(Request $request, Tadika $tadika)
    {
        $validator = Validator::make($request->all(), [
            'tadika_name' => 'required|string|max:255',
            'tadika_reg_no' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tadikas')->ignore($tadika->tadika_id, 'tadika_id'),
            ],
            'tadika_address' => 'required|string|max:500',
            'tadika_district' => 'required|string|max:100',
            'tadika_state' => 'required|string|max:100',
            'tadika_postcode' => 'required|string|max:10',
            'tadika_phone' => 'required|digits_between:10,15',
            'tadika_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('tadikas')->ignore($tadika->tadika_id, 'tadika_id'),
            ],
            'tadika_location' => 'nullable|string|max:255',
            'tadika_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_name' => 'required|string|max:255',
            'owner_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'user_email')->ignore($tadika->owner_user_id, 'user_id'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::transaction(function () use ($request, $tadika) {
                $updateData = [
                    'tadika_name' => $request->tadika_name,
                    'tadika_reg_no' => $request->tadika_reg_no,
                    'tadika_address' => $request->tadika_address,
                    'tadika_district' => $request->tadika_district,
                    'tadika_state' => $request->tadika_state,
                    'tadika_postcode' => $request->tadika_postcode,
                    'tadika_phone' => $request->tadika_phone,
                    'tadika_email' => $request->tadika_email,
                    'tadika_location' => $request->tadika_location,
                    'tadika_owner' => $request->owner_name,
                ];

                if ($request->hasFile('tadika_logo')) {
                    if ($tadika->tadika_logo && file_exists(public_path('storage/' . $tadika->tadika_logo))) {
                        unlink(public_path('storage/' . $tadika->tadika_logo));
                    }
                    $filename = time() . '_' . $request->file('tadika_logo')->getClientOriginalName();
                    $request->file('tadika_logo')->move(public_path('storage/tadika_logos'), $filename);
                    $updateData['tadika_logo'] = 'tadika_logos/' . $filename;
                }

                $tadika->update($updateData);

                // Update owner information
                $ownerUpdates = [
                    'user_email' => $request->owner_email,
                    'user_name' => $request->owner_name,
                ];

                if ($request->filled('password')) {
                    $ownerUpdates['password'] = Hash::make($request->password);
                }

                $tadika->owner->update($ownerUpdates);
            });

            return redirect()->route('tadika.index')->with('success', 'Tadika and owner information updated successfully.');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->withErrors(['update_error' => 'Unable to update tadika. Please try again.'])
                ->withInput();
        }
    }

    // Delete tadika
    public function destroy(Tadika $tadika)
    {
        try {
            DB::transaction(function () use ($tadika) {
                // Delete the owner user
                if ($tadika->owner) {
                    $tadika->owner->delete();
                }

                // Delete the tadika
                $tadika->delete();
            });

            return redirect()->route('tadika.index')->with('success', 'Tadika deleted successfully.');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->withErrors(['delete_error' => 'Unable to delete tadika. Please try again.']);
        }
    }

    public function resetPassword(Request $request, Tadika $tadika)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $tadika->owner->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password reset successfully for ' . $tadika->tadika_name);
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['password_error' => 'Unable to reset password. Please try again.']);
        }
    }
}
