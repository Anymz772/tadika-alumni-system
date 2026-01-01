<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_alumni' => Alumni::count(),
            'total_users' => User::count(),
            'recent_alumni' => Alumni::whereYear('created_at', date('Y'))->count(),
            'alumni_by_year' => Alumni::selectRaw('year_graduated, COUNT(*) as count')
                ->groupBy('year_graduated')
                ->orderBy('year_graduated', 'desc')
                ->limit(5)
                ->get()
        ];

        $recentAlumni = Alumni::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAlumni'));
    }
}