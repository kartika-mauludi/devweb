<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if(!auth::check()){
            return redirect()->route('login');
        }
        if (auth()->user()->is_superadmin == 1) {
            return $next($request);
        }

        return redirect('login')->with('error',"you dont have permisson");
       
    }
}
