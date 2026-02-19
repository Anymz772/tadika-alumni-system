<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TadikaOwnerController extends Controller
{
    public function dashboard()
    {
        $tadika = auth()->user()->ownedTadika;
        $alumniCount = $tadika ? $tadika->alumni()->count() : 0;

        return view('tadika_owner.dashboard', compact('tadika', 'alumniCount'));
    }

    public function editProfile()
    {
        $tadika = auth()->user()->ownedTadika;

        return view('tadika_owner.edit', compact('tadika'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'tadika_name' => ['required', 'string', 'max:255'],
            'tadika_reg_no' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tadikas', 'tadika_reg_no')->ignore(optional($request->user()->ownedTadika)->tadika_id, 'tadika_id'),
            ],
            'tadika_address' => ['nullable', 'string'],
            'tadika_district' => ['required', 'string', 'max:255'],
            'tadika_state' => ['required', 'string', 'max:255'],
            'tadika_phone' => ['nullable', 'string', 'max:30'],
            'tadika_email' => ['nullable', 'email', 'max:255'],
            'tadika_owner' => ['nullable', 'string', 'max:255'],
            'tadika_location' => ['nullable', 'string', 'max:255'],
            'tadika_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = $request->user();
        $tadika = $user->ownedTadika;

        if ($request->hasFile('tadika_logo')) {
            $path = $request->file('tadika_logo')->store('tadika_photos', 'public');
            $data['tadika_logo'] = $path;
        }

        if ($tadika) {
            $tadika->update($data);
        } else {
            $user->ownedTadika()->create($data);
        }

        return redirect()->route('tadika.edit')->with('success', 'Tadika profile updated.');
    }

    public function viewAlumniList()
    {
        $tadika = auth()->user()->ownedTadika;

        if (!$tadika) {
            return redirect()->route('tadika.edit')->with('error', 'Please set up your Tadika profile first.');
        }

        $alumni = $tadika->alumni()->with('user')->paginate(20);

        return view('tadika_owner.alumni', compact('tadika', 'alumni'));
    }
}