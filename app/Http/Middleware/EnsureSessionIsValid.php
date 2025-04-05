<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureSessionIsValid
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentSessionId = Session::getId();
            
            if ($user->last_session_id && $user->last_session_id !== $currentSessionId) {
                Auth::logout();
                Session::invalidate();
                Session::regenerateToken();

                return redirect()->route('login')->withErrors([
                    'message' => 'Akun Anda login di perangkat lain.',
                ]);
            }
        }

        return $next($request);
    }
}

