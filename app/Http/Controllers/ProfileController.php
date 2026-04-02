<?php 

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Tadika;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. If user is Admin, redirect to Admin Dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // 2. If user is Tadika, redirect to Tadika Dashboard
        if ($user->isTadika()) {
            return redirect()->route('tadika.dashboard');
        }

        // 3. User must be Alumni. Check if profile exists.
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create')->with('info', 'Sila lengkapkan profil alumni anda.');
        }

        $messages = $user->notifications()
            ->latest()
            ->take(20)
            ->get();

        // Mark newly seen messages as read when alumni opens profile.
        $user->unreadNotifications()->update(['read_at' => now()]);

        return view('profile.show', compact('alumni', 'messages'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        // Security check: Prevent Admin/Tadika from accessing the alumni creation form
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isTadika()) return redirect()->route('tadika.dashboard');

        if ($user->alumni) {
            return redirect()->route('profile.show');
        }

        // Provide an empty Alumni object so view can reference properties safely
        $alumni = new Alumni();
        return view('profile.create', compact('alumni'));
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->alumni) {
            return redirect()->route('profile.show');
        }

        $validator = Validator::make($request->all(), [
            'alumni_name' => 'required|string|max:255',
            'alumni_ic' => 'nullable|string|max:14',
            'grad_year' => 'nullable|digits:4|integer|min:2000|max:' . date('Y'),
            'alumni_state' => 'nullable|string|max:255',
            'alumni_district' => 'nullable|string|max:255',
            'alumni_postcode' => 'nullable|string|max:10',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'alumni_phone' => 'required|string|max:15',
            'alumni_status' => 'required|in:studying,working',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:15',
            'alumni_address' => 'nullable|string|max:500',
            'alumni_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_childhood' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_current' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validator->sometimes('institution', 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'studying';
        });
        $validator->sometimes(['company', 'job_position'], 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'working';
        });

        if ($request->alumni_status === 'studying' && empty($request->institution)) {
            $validator->errors()->add('institution', 'Nama Institusi diperlukan apabila sedang belajar.');
        }
        if ($request->alumni_status === 'working' && empty($request->company)) {
            $validator->errors()->add('company', 'Nama Syarikat diperlukan apabila bekerja.');
        }
        if ($request->alumni_status === 'working' && empty($request->job_position)) {
            $validator->errors()->add('job_position', 'Jawatan diperlukan apabila bekerja.');
        }

        $validator->validate();

        $createData = [
            'user_id' => $user->user_id,
            'tadika_id' => $this->resolveTadikaIdByName($request->tadika_name),
            'alumni_name' => $request->alumni_name,
            'alumni_ic' => $request->alumni_ic,
            'alumni_state' => $request->alumni_state,
            'alumni_district' => $request->alumni_district,
            'alumni_postcode' => $request->alumni_postcode,
            'tadika_name' => $request->tadika_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'grad_year' => $request->grad_year,
            'alumni_status' => $request->alumni_status,
            'institution' => $request->alumni_status === 'studying' ? $request->institution : null,
            'company' => $request->alumni_status === 'working' ? $request->company : null,
            'job_position' => $request->alumni_status === 'working' ? $request->job_position : null,
            'alumni_phone' => $request->alumni_phone,
            'alumni_address' => $request->alumni_address,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_phone' => $request->parent_phone,
            'alumni_email' => $user->user_email
        ];

        if ($request->hasFile('alumni_photo')) {
            $filename = time() . '_' . $request->file('alumni_photo')->getClientOriginalName();
            $path = $request->file('alumni_photo')->storeAs('alumni_photos', $filename, 'public');
            $createData['alumni_photo'] = $path;
        }

        if ($request->hasFile('photo_childhood')) {
            $filename = time() . '_childhood_' . $request->file('photo_childhood')->getClientOriginalName();
            $path = $request->file('photo_childhood')->storeAs('alumni_then_now', $filename, 'public');
            $createData['photo_childhood'] = $path;
        }

        if ($request->hasFile('photo_current')) {
            $filename = time() . '_current_' . $request->file('photo_current')->getClientOriginalName();
            $path = $request->file('photo_current')->storeAs('alumni_then_now', $filename, 'public');
            $createData['photo_current'] = $path;
        }

        Alumni::create($createData);

        return redirect()->route('profile.show')->with('success', 'Profil alumni berjaya dibuat!');
    }

    public function edit()
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create')->with('error', 'Sila buat profil alumni anda terlebih dahulu.');
        }

        return view('profile.edit', compact('alumni'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile.create');
        }

        $validator = Validator::make($request->all(), [
            'alumni_name' => 'required|string|max:255',
            'grad_year' => 'nullable|digits:4|integer|min:2000|max:' . date('Y'),
            'alumni_state' => 'nullable|string|max:255',
            'alumni_district' => 'nullable|string|max:255',
            'alumni_postcode' => 'nullable|string|max:10',
            'tadika_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'age' => 'nullable|integer|min:1|max:100',
            'alumni_phone' => 'required|string|max:15',
            'alumni_status' => 'required|in:studying,working',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:15',
            'alumni_ic' => 'nullable|string|max:14',
            'alumni_address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'alumni_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_childhood' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_current' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validator->sometimes('institution', 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'studying';
        });
        $validator->sometimes(['company', 'job_position'], 'required|string|max:255', function ($input) {
            return $input->alumni_status === 'working';
        });

        if ($request->alumni_status === 'studying' && empty($request->institution)) {
            $validator->errors()->add('institution', 'Nama Institusi diperlukan apabila sedang belajar.');
        }
        if ($request->alumni_status === 'working' && empty($request->company)) {
            $validator->errors()->add('company', 'Nama Syarikat diperlukan apabila bekerja.');
        }
        if ($request->alumni_status === 'working' && empty($request->job_position)) {
            $validator->errors()->add('job_position', 'Jawatan diperlukan apabila bekerja.');
        }

        $validator->validate();

        $updateData = [
            'alumni_name' => $request->alumni_name,
            'grad_year' => $request->grad_year,
            'alumni_state' => $request->alumni_state,
            'alumni_district' => $request->alumni_district,
            'alumni_postcode' => $request->alumni_postcode,
            'tadika_name' => $request->tadika_name,
            'tadika_id' => $this->resolveTadikaIdByName($request->tadika_name),
            'gender' => $request->gender,
            'age' => $request->age,
            'alumni_phone' => $request->alumni_phone,
            'alumni_status' => $request->alumni_status,
            'institution' => $request->alumni_status === 'studying' ? $request->institution : null,
            'company' => $request->alumni_status === 'working' ? $request->company : null,
            'job_position' => $request->alumni_status === 'working' ? $request->job_position : null,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_phone' => $request->parent_phone,
            'alumni_ic' => $request->alumni_ic,
            'alumni_address' => $request->alumni_address
        ];

        if ($request->hasFile('alumni_photo')) {
            if ($alumni->alumni_photo && Storage::disk('public')->exists($alumni->alumni_photo)) {
                Storage::disk('public')->delete($alumni->alumni_photo);
            }
            $filename = time() . '_' . $request->file('alumni_photo')->getClientOriginalName();
            $path = $request->file('alumni_photo')->storeAs('alumni_photos', $filename, 'public');
            $updateData['alumni_photo'] = $path;
        }

        if ($request->hasFile('photo_childhood')) {
            if ($alumni->photo_childhood && Storage::disk('public')->exists($alumni->photo_childhood)) {
                Storage::disk('public')->delete($alumni->photo_childhood);
            }
            $filename = time() . '_childhood_' . $request->file('photo_childhood')->getClientOriginalName();
            $path = $request->file('photo_childhood')->storeAs('alumni_then_now', $filename, 'public');
            $updateData['photo_childhood'] = $path;
        }

        if ($request->hasFile('photo_current')) {
            if ($alumni->photo_current && Storage::disk('public')->exists($alumni->photo_current)) {
                Storage::disk('public')->delete($alumni->photo_current);
            }
            $filename = time() . '_current_' . $request->file('photo_current')->getClientOriginalName();
            $path = $request->file('photo_current')->storeAs('alumni_then_now', $filename, 'public');
            $updateData['photo_current'] = $path;
        }

        $alumni->update($updateData);

        if ($user->user_name !== $request->alumni_name) {
            $user->update(['user_name' => $request->alumni_name]);
        }

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile.show')->with('success', 'Profil berjaya dikemaskini.');
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
