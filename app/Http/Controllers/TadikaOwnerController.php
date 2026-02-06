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
            'name' => ['required', 'string', 'max:255'],
            'registration_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tadikas', 'registration_number')->ignore(optional($request->user()->ownedTadika)->id),
            ],
            'address' => ['nullable', 'string'],
            'district' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // Validate image upload
        ]);

        $user = $request->user();
        $tadika = $user->ownedTadika;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('tadika_photos', 'public');
            $data['logo'] = $path;
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
