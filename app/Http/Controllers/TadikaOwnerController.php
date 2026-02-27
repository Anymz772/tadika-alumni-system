<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Notifications\TadikaOwnerInAppMessage;
use App\Models\Tadika;

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
        $districts = DB::table('glo_bandar')
            ->whereNotNull('bandar_nama')
            ->distinct()
            ->orderBy('bandar_nama')
            ->pluck('bandar_nama');
        $states = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_negeri')
            ->pluck('bandar_negeri');
        $postcodes = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_postcode')
            ->pluck('bandar_postcode');

        return view('tadika_owner.edit', compact('tadika', 'districts', 'states', 'postcodes'));
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
            'tadika_district' => ['required', 'string', 'max:255', Rule::exists('glo_bandar', 'bandar_nama')],
            'tadika_state' => ['required', 'string', 'max:255', Rule::exists('glo_bandar', 'bandar_negeri')],
            'tadika_postcode' => ['required', 'string', 'max:50', Rule::exists('glo_bandar', 'bandar_postcode')],
            'tadika_phone' => ['nullable', 'string', 'max:30'],
            'tadika_email' => ['nullable', 'email', 'max:255'],
            'tadika_owner' => ['nullable', 'string', 'max:255'],
            'tadika_location' => ['nullable', 'string', 'max:255'],
            'tadika_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = $request->user();
        $tadika = $user->ownedTadika;

        if ($request->hasFile('tadika_logo')) {
            $filename = time() . '_' . $request->file('tadika_logo')->getClientOriginalName();
            $uploadPath = public_path('storage/tadika_photos');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $request->file('tadika_logo')->move($uploadPath, $filename);
            $data['tadika_logo'] = 'tadika_photos/' . $filename;
        }

        if ($tadika) {
            $tadika->update($data);
        } else {
            $user->ownedTadika()->create($data);
        }

        return redirect()->route('tadika.profile.edit')->with('success', 'Tadika profile updated.');
    }

    public function viewAlumniList()
    {
        $tadika = auth()->user()->ownedTadika;

        if (!$tadika) {
            return redirect()->route('tadika.profile.edit')->with('error', 'Please set up your Tadika profile first.');
        }

        $alumni = $tadika->alumni()->with('user')->paginate(20);

        return view('tadika_owner.alumni', compact('tadika', 'alumni'));
    }

    /**
     * Ensure that the given alumni belongs to the logged-in tadika owner.
     *
     * @param  \App\Models\Alumni  $alumni
     * @return void
     */
    protected function authorizeTadikaOwner($alumni)
    {
        $tadika = auth()->user()->ownedTadika;
        if (! $tadika || $alumni->tadika_id !== $tadika->tadika_id) {
            abort(403);
        }
    }

    public function editAlumni(\App\Models\Alumni $alumni)
    {
        $this->authorizeTadikaOwner($alumni);
        return view('tadika_owner.alumni_edit', compact('alumni'));
    }

    public function updateAlumni(Request $request, \App\Models\Alumni $alumni)
    {
        $this->authorizeTadikaOwner($alumni);

        $request->validate([
            'alumni_name' => 'required|string|max:255',
            'alumni_ic' => 'required|string|max:14',
            'grad_year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'tadika_name' => 'nullable|string|max:255',
            'alumni_state' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'user_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'user_email')->ignore($alumni->user_id, 'user_id'),
                Rule::unique('alumni', 'alumni_email')->ignore($alumni->alumni_id, 'alumni_id'),
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

        $updateData = [
            'alumni_name' => $request->alumni_name,
            'alumni_ic' => $request->alumni_ic,
            'grad_year' => $request->grad_year,
            'tadika_name' => $request->tadika_name,
            'tadika_id' => $this->resolveTadikaIdByName($request->tadika_name),
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
            'alumni_email' => $request->user_email,
        ];

        if ($request->hasFile('alumni_photo')) {
            if ($alumni->alumni_photo && file_exists(public_path('storage/' . $alumni->alumni_photo))) {
                unlink(public_path('storage/' . $alumni->alumni_photo));
            }
            $filename = time() . '_' . $request->file('alumni_photo')->getClientOriginalName();
            $request->file('alumni_photo')->move(public_path('storage/alumni_photos'), $filename);
            $updateData['alumni_photo'] = 'alumni_photos/' . $filename;
        }

        DB::transaction(function () use ($alumni, $request, $updateData) {
            $alumni->update($updateData);

            if ($alumni->user) {
                $userUpdates = [
                    'user_email' => $request->user_email,
                    'user_name' => $request->alumni_name,
                ];

                if ($request->filled('password')) {
                    $userUpdates['password'] = Hash::make($request->password);
                }

                $alumni->user->update($userUpdates);
            }
        });

        return redirect()->route('tadika.alumni')->with('success', 'Alumni details updated successfully.');
    }

    public function messageAlumniForm(\App\Models\Alumni $alumni)
    {
        $this->authorizeTadikaOwner($alumni);
        return view('tadika_owner.message', compact('alumni'));
    }

    public function sendMessageAlumni(Request $request, \App\Models\Alumni $alumni)
    {
        $this->authorizeTadikaOwner($alumni);

        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if (! $alumni->user) {
            return back()->with('error', 'This alumni does not have a linked login account.');
        }

        try {
            $alumni->user->notify(new TadikaOwnerInAppMessage([
                'subject' => $data['subject'],
                'message' => $data['message'],
                'sender_name' => auth()->user()->user_name,
            ]));
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }

        return back()->with('success', 'Message sent in app to ' . $alumni->alumni_name);
    }

    public function messageAllForm()
    {
        // reuse single message view without an alumni object
        return view('tadika_owner.message');
    }

    public function sendMessageAll(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $tadika = auth()->user()->ownedTadika;
        if (! $tadika) {
            return back()->with('error', 'Please set up your Tadika profile first.');
        }

        $alumniUsers = $tadika->alumni()
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('user_id')
            ->values();

        $failed = [];

        foreach ($alumniUsers as $user) {
            try {
                $user->notify(new TadikaOwnerInAppMessage([
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                    'sender_name' => auth()->user()->user_name,
                ]));
            } catch (\Throwable $e) {
                report($e);
                $failed[] = $user->user_email ?? ('user_id:' . $user->user_id);
            }
        }

        if (count($failed) > 0) {
            return back()->with('error', 'Some messages failed to send: ' . implode(', ', array_slice($failed, 0, 5)));
        }

        return back()->with('success', 'Broadcast message sent in app to all linked alumni accounts.');
    }

    private function resolveTadikaIdByName(?string $tadikaName): ?int
    {
        $name = trim((string) $tadikaName);
        if ($name === '') {
            return null;
        }

        $tadika = Tadika::query()
            ->whereRaw('LOWER(TRIM(tadika_name)) = ?', [strtolower($name)])
            ->first();

        return $tadika?->tadika_id;
    }
}
