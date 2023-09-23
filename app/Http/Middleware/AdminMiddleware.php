<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
           $user = Auth::user();

            if (Auth::check() && $user->isAdmin()) {
                return $next($request);
            }

        
        return redirect('/');
    }
    
    
}
