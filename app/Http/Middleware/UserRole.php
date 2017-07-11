<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $type = Auth::user()->type;
        
        if ($role == 'admin' && $type>0) return Redirect::to('/');

        if ($role == 'sell' && $type != 1) return Redirect::to('/');

        if ($role == 'user' && $type<1) return Redirect::to('/admin/index');

        return $next($request);
    }
}
