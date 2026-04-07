<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Tadika;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->has('tadika_name') && !empty($request->tadika_name)) {
            $query->where('tadika_name', 'like', "%{$request->tadika_name}%");
        }

        $alumni = $query->paginate(10)->withQueryString();

        return view('alumni.index', compact('alumni'));
    }

    public function create()
    {
        $tadikas = Tadika::query()->orderBy('tadika_name')->get(['tadika_id', 'tadika_name']);
        $states = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_negeri')
            ->pluck('bandar_negeri');
        return view('alumni.create', compact('tadikas', 'states'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'tadika_id' => 'nullable|string',
            'other_tadika_name' => 'nullable|string|max:255|required_if:tadika_id,other',
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
            'user_email.unique' => 'Emel ini sudah didaftarkan dalam sistem kami.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $alumni = DB::transaction(function () use ($request) {
                $user = User::create([
                    'user_name' => $request->alumni_name,
                    'user_email' => $request->user_email,
                    'password' => Hash::make($request->password),
                    'user_role' => 'alumni'
                ]);

                $tadikaId = null;
                $tadikaName = null;

                if ($request->tadika_id === 'other') {
                    $tadikaName = $request->other_tadika_name;
                } elseif ($request->tadika_id) {
                    $tadika = Tadika::find($request->tadika_id);
                    if ($tadika) {
                        $tadikaId = $tadika->tadika_id;
                        $tadikaName = $tadika->tadika_name;
                    }
                }

                $alumniData = [
                    'user_id' => $user->user_id,
                    'tadika_id' => $tadikaId,
                    'alumni_name' => $request->alumni_name,
                    'alumni_ic' => $request->alumni_ic,
                    'tadika_name' => $tadikaName,
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
                ->withErrors(['alumni_create' => 'Tidak dapat membuat profil alumni. Sila semak borang dan cuba lagi.'])
                ->withInput();
        }

        return redirect()->route('alumni.show', $alumni->alumni_id)->with('success', 'Akaun alumni berjaya dibuat!');
    }

    public function show(Alumni $alumni)
    {
        return view('alumni.show', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        $tadikas = Tadika::query()->orderBy('tadika_name')->get(['tadika_id', 'tadika_name']);
        $states = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_negeri')
            ->pluck('bandar_negeri');
        return view('alumni.edit', compact('alumni', 'tadikas', 'states'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validator = Validator::make($request->all(), [
            'alumni_name' => 'required|string|max:255',
            'alumni_ic' => 'required|string|max:14',
            'grad_year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
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
            'photo_childhood' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_current' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $path = $request->file('alumni_photo')->storeAs('alumni_photos', $filename, 'public');
            $updateData['alumni_photo'] = $path;
        }

        if ($request->hasFile('photo_childhood')) {
            if ($alumni->photo_childhood && file_exists(public_path('storage/' . $alumni->photo_childhood))) {
                unlink(public_path('storage/' . $alumni->photo_childhood));
            }
            $filename = time() . '_childhood_' . $request->file('photo_childhood')->getClientOriginalName();
            $path = $request->file('photo_childhood')->storeAs('alumni_then_now', $filename, 'public');
            $updateData['photo_childhood'] = $path;
        }

        if ($request->hasFile('photo_current')) {
            if ($alumni->photo_current && file_exists(public_path('storage/' . $alumni->photo_current))) {
                unlink(public_path('storage/' . $alumni->photo_current));
            }
            $filename = time() . '_current_' . $request->file('photo_current')->getClientOriginalName();
            $path = $request->file('photo_current')->storeAs('alumni_then_now', $filename, 'public');
            $updateData['photo_current'] = $path;
        }


        DB::transaction(function () use ($alumni, $request, $updateData) {
            $alumni->update($updateData);

            if ($alumni->user) {
                $userUpdates = [
                    'user_email' => $request->user_email,
                ];

                if ($request->filled('password')) {
                    $userUpdates['password'] = Hash::make($request->password);
                }

                $alumni->user->update($userUpdates);
            }
        });

        return redirect()->route('alumni.index')->with('success', 'Maklumat alumni dan kelayakan log masuk berjaya dikemaskini.');
    }

    // Delete alumni
    public function destroy(Alumni $alumni)
    {
        // 1. Delete the associated User login account (IF it exists)
        if ($alumni->user) {
            $alumni->user->delete();
        }

        // 2. Delete the actual Alumni profile record
        $alumni->delete();

        return redirect()->route('alumni.index')->with('success', 'Alumni berjaya dipadam.');
    }

    public function resetPassword(Request $request, Alumni $alumni)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $alumni->user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Kata laluan berjaya diset semula untuk ' . $alumni->alumni_name);
    }

    public function export()
    {
        return Excel::download(new AlumniExport(), 'semua_alumni.xlsx');
    }

    public function getDistricts(Request $request)
    {
        $districts = DB::table('glo_bandar')
            ->where('bandar_negeri', $request->state)
            ->whereNotNull('bandar_nama')
            ->distinct()
            ->orderBy('bandar_nama')
            ->pluck('bandar_nama');

        return response()->json($districts);
    }

    public function getPostcodes(Request $request)
    {
        $postcodes = DB::table('glo_bandar')
            ->where('bandar_nama', $request->district)
            ->distinct()
            ->orderBy('bandar_postcode')
            ->pluck('bandar_postcode');

        return response()->json($postcodes);
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
