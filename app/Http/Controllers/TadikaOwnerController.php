<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Notifications\TadikaOwnerInAppMessage;
use App\Models\Tadika;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumniExport;

class TadikaOwnerController extends Controller
{
    public function dashboard()
    {
        $tadika = auth()->user()->ownedTadika;
        
        $alumniCount = 0;
        $newAlumniCount = 0;
        
        // New variables for our widgets
        $recentAlumni = collect();
        $statusChartData = ['studying' => 0, 'working' => 0];
        $gradYearLabels = [];
        $gradYearValues = [];

        if ($tadika) {
            // Base query to keep things dry
            $alumniQuery = $tadika->alumni();
            
            $alumniCount = $alumniQuery->count();
            
            $newAlumniCount = (clone $alumniQuery)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // 1. Fetch 5 most recent registrations
            $recentAlumni = (clone $alumniQuery)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // 2. Fetch data for Status Pie Chart (Studying vs Working)
            $statusCounts = (clone $alumniQuery)
                ->select('alumni_status', \DB::raw('count(*) as total'))
                ->whereNotNull('alumni_status')
                ->groupBy('alumni_status')
                ->pluck('total', 'alumni_status')
                ->toArray();
            
            $statusChartData['studying'] = $statusCounts['studying'] ?? 0;
            $statusChartData['working'] = $statusCounts['working'] ?? 0;

            // 3. Fetch data for Graduation Year Bar Chart
            $gradYearCounts = (clone $alumniQuery)
                ->select('grad_year', \DB::raw('count(*) as total'))
                ->whereNotNull('grad_year')
                ->groupBy('grad_year')
                ->orderBy('grad_year', 'asc')
                ->pluck('total', 'grad_year')
                ->toArray();

            $gradYearLabels = array_keys($gradYearCounts);
            $gradYearValues = array_values($gradYearCounts);
        }

        return view('tadika_owner.dashboard', compact(
            'tadika', 
            'alumniCount', 
            'newAlumniCount',
            'recentAlumni',
            'statusChartData',
            'gradYearLabels',
            'gradYearValues'
        ));
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

        return redirect()->route('tadika.profile.edit')->with('success', 'Profil Tadika dikemas kini.');
    }

    public function viewAlumniList()
    {
        $tadika = auth()->user()->ownedTadika;

        if (!$tadika) {
            return redirect()->route('tadika.profile.edit')->with('error', 'Sila sediakan profil Tadika anda terlebih dahulu.');
        }

        $alumni = $tadika->alumni()->with('user')->paginate(20);

        return view('tadika_owner.alumni', compact('tadika', 'alumni'));
    }

    public function showAlumni(\App\Models\Alumni $alumni)
    {
        $this->authorizeTadikaOwner($alumni);
        return view('tadika_owner.alumni_show', compact('alumni'));
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

        return redirect()->route('tadika.alumni')->with('success', 'Butiran alumni berjaya dikemas kini.');
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
            return back()->with('error', 'Alumni ini tidak mempunyai akaun log masuk yang dipautkan.');
        }

        try {
            $alumni->user->notify(new TadikaOwnerInAppMessage([
                'subject' => $data['subject'],
                'message' => $data['message'],
                'sender_name' => auth()->user()->user_name,
            ]));
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghantar mesej: ' . $e->getMessage());
        }

        return back()->with('success', 'Mesej dihantar dalam aplikasi kepada ' . $alumni->alumni_name);
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
            return back()->with('error', 'Sila sediakan profil Tadika anda terlebih dahulu.');
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
            return back()->with('error', 'Beberapa mesej gagal dihantar: ' . implode(', ', array_slice($failed, 0, 5)));
        }

        return back()->with('success', 'Mesej siaran dihantar dalam aplikasi kepada semua akaun alumni yang dipautkan.');
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
    public function exportAlumniExcel()
    {
        $tadika = auth()->user()->ownedTadika;

        if (!$tadika) {
            return back()->with('error', 'Sila sediakan profil Tadika anda terlebih dahulu.');
        }

        $fileName = 'Senarai_Alumni_' . str_replace(' ', '_', $tadika->tadika_name) . '_' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new AlumniExport($tadika->tadika_id), $fileName);
    }
}
