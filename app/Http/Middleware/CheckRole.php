<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        if($user->status !== 'active') {
            Auth::logout();
            return redirect('login')->with('error', 'Tu cuenta está desactivada o suspendida.');
        }

        if(in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect('dashboard')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}
