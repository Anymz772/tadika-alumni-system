<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $totalUsers = User::count();
        $totalTadikas = Tadika::count();
        $totalAlumni = Alumni::count();

        return view('home', compact('totalUsers', 'totalTadikas', 'totalAlumni'));
    }
}
