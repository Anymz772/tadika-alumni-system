<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Tadika; // Import Tadika Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class AlumniRegisterController extends Controller
{
    public function create(Request $request)
    {
        $states = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_negeri')
            ->pluck('bandar_negeri');

        $prefilledTadika = null;
        if ($request->has('ref')) {
            $prefilledTadika = Tadika::find($request->query('ref'));
        }

        return view('auth.alumni-register', compact('states', 'prefilledTadika'));
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

    public function getTadikas(Request $request)
    {
        $tadikas = Tadika::query()
            ->where('tadika_state', $request->state)
            ->where('tadika_district', $request->district)
            ->where('tadika_postcode', $request->postcode)
            ->orderBy('tadika_name')
            ->get(['tadika_id', 'tadika_name']);

        return response()->json($tadikas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class, 'user_email'),
                Rule::unique('alumni', 'alumni_email'),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alumni_name' => ['required', 'string', 'max:255'],
            'alumni_state' => ['required', 'string', 'max:255', Rule::exists('glo_bandar', 'bandar_negeri')],
            'alumni_district' => ['required', 'string', 'max:255', Rule::exists('glo_bandar', 'bandar_nama')],
            'alumni_postcode' => ['required', 'string', 'max:10', Rule::exists('glo_bandar', 'bandar_postcode')],
            'tadika_id' => ['required', 'string'],
            'other_tadika_name' => ['nullable', 'string', 'max:255', 'required_if:tadika_id,other'],
        ]);

        try {
            $user = DB::transaction(function () use ($request) {
                // 1. Create the User (Login Credentials)
                $user = User::create([
                    'user_name' => $request->alumni_name,
                    'user_email' => $request->user_email,
                    'password' => Hash::make($request->password),
                    'user_role' => 'alumni',
                ]);

                $tadikaId = null;
                $tadikaName = null;

                if ($request->tadika_id === 'other') {
                    $tadikaName = $request->other_tadika_name;
                    // We don't create a new tadika here, just store the name.
                    // A separate admin process could handle new tadikas.
                } elseif ($request->tadika_id) {
                    $tadika = Tadika::find($request->tadika_id);
                    if ($tadika) {
                        $tadikaId = $tadika->tadika_id;
                        $tadikaName = $tadika->tadika_name;
                    }
                }

                // 3. Create the Alumni Profile
                Alumni::create([
                    'user_id' => $user->user_id,
                    'tadika_id' => $tadikaId,
                    'alumni_name' => $request->alumni_name,
                    'alumni_state' => $request->alumni_state,
                    'alumni_district' => $request->alumni_district,
                    'alumni_postcode' => $request->alumni_postcode,
                    'tadika_name' => $tadikaName, // Always save the text name for reference
                    'alumni_email' => $request->user_email
                ]);

                return $user;
            });
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()
                ->withErrors(['alumni_create' => 'Pendaftaran gagal semasa membuat profil alumni. Sila cuba lagi.'])
                ->withInput();
        }

        // Log in the user
        auth()->login($user);

        // Redirect to profile
        return redirect()->route('profile.show')->with('success', 'Pendaftaran berjaya! Selamat datang ke Sistem Alumni Tadika.');
    }
}
