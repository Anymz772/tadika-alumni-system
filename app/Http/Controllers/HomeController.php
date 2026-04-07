<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Tadika;
use App\Models\Alumni;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalTadikas = Tadika::count();
        $totalAlumni = Alumni::count();
        $recentTadikas = Tadika::where('created_at', '>=', now()->subYears(10))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('home', compact('totalTadikas', 'totalAlumni', 'recentTadikas'));
    }

    public function tadikaList(Request $request)
    {
        $query = Tadika::query()
            ->where('created_at', '>=', now()->subYears(10));

        if ($request->filled('search')) {
            $query->where('tadika_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('district')) {
            $query->where('tadika_district', 'like', '%' . $request->district . '%');
        }

        if ($request->filled('state')) {
            $query->where('tadika_state', 'like', '%' . $request->state . '%');
        }

        $tadikas = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $states = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_negeri')
            ->pluck('bandar_negeri');

        $districts = DB::table('glo_bandar')
            ->distinct()
            ->orderBy('bandar_nama')
            ->pluck('bandar_nama');

        return view('tadika.public_index', compact('tadikas', 'states', 'districts'));
    }
}
