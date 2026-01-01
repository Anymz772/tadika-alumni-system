<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAlumniOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $alumniId = $request->route('alumni');
        
        if (!$alumniId) {
            return $next($request);
        }
        
        $alumni = \App\Models\Alumni::find($alumniId);
        
        if (!$alumni) {
            abort(404, 'Alumni not found');
        }
        
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }
        
        if (auth()->id() !== $alumni->user_id) {
            abort(403, 'Unauthorized: You can only access your own profile');
        }
        
        return $next($request);
    }
}