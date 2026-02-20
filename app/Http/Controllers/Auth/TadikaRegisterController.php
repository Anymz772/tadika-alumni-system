<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tadika;
use App\Models\User;
use App\Models\Alumni; // Import Alumni Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class TadikaRegisterController extends Controller
{
    public function create()
    {
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

        return view('auth.tadika-register', compact('districts', 'states', 'postcodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tadika_name' => ['required', 'string', 'max:255'],
            'tadika_reg_no' => ['required', 'string', 'max:100', 'unique:tadikas,tadika_reg_no'],
            'tadika_district' => ['required', 'string', 'max:255', Rule::exists('glo_bandar', 'bandar_nama')],
            'tadika_state' => ['required', 'string', 'max:255', Rule::exists('glo_bandar', 'bandar_negeri')],
            'tadika_postcode' => ['required', 'string', 'max:50', Rule::exists('glo_bandar', 'bandar_postcode')],
            // Validate against the correct `user_email` column in the `users` table
            'tadika_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,user_email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tadika_address' => ['nullable', 'string'],
            'tadika_phone' => ['nullable', 'string', 'max:30'],
            'tadika_owner' => ['nullable', 'string', 'max:255'],
            'tadika_location' => ['nullable', 'string', 'max:255'],
            'tadika_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $tadika_logoPath = null;
        if ($request->hasFile('tadika_logo')) {
            $tadika_logoPath = $request->file('tadika_logo')->store('tadika_photos', 'public');
        }

        DB::transaction(function () use ($request, $tadika_logoPath) {
            // 1. Create User Account
            $user = User::create([
                'user_name' => $request->tadika_name,
                'user_email' => $request->tadika_email, // Map login email here
                'password' => Hash::make($request->password),
                'user_role' => 'tadika',
            ]);

            // 2. Create Tadika Profile
            $tadika = Tadika::create([
                'tadika_name' => $request->tadika_name,
                'tadika_reg_no' => $request->tadika_reg_no,
                'tadika_district' => $request->tadika_district,
                'tadika_state' => $request->tadika_state,
                'tadika_postcode' => $request->tadika_postcode,
                'tadika_email' => $request->tadika_email, // Store the tadika's business email here
                'tadika_address' => $request->tadika_address,
                'tadika_phone' => $request->tadika_phone,
                'tadika_owner' => $request->tadika_owner,
                'tadika_location' => $request->tadika_location,
                'tadika_logo' => $tadika_logoPath,
                'owner_user_id' => $user->user_id, // Linked to the new user_id column
            ]);

            // 3. ADOPT ORPHANED ALUMNI
            // Find any alumni who registered earlier and typed in this exact Tadika name, 
            // but don't have a tadika_id assigned yet, and link them to this new Tadika.
            Alumni::whereNull('tadika_id')
                  ->whereRaw('LOWER(TRIM(tadika_name)) = ?', [strtolower(trim((string) $request->tadika_name))])
                  ->update(['tadika_id' => $tadika->tadika_id]);
        });

        return redirect()->route('tadika.register.success')
            ->with('success', 'Registration successful! Your Tadika account has been created, and any matching alumni have been automatically linked.');
    }
}
