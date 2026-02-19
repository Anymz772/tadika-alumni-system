<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Alumni;

class CheckAlumniOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $alumni = $request->route('alumni');
        
        if (!$alumni) {
            return $next($request);
        }
        
        // If the route passes the ID string, find the model. 
        // If it passes the Model object (Route Binding), use it directly.
        if (!$alumni instanceof Alumni) {
            $alumni = Alumni::find($alumni);
        }
        
        if (!$alumni) {
            abort(404, 'Alumni not found');
        }
        
        // Admins can bypass this check
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }
        
        // Use user_id to match your new database primary key
        if (auth()->user()->user_id !== $alumni->user_id) {
            abort(403, 'Unauthorized: You can only access your own profile');
        }
        
        return $next($request);
    }
}