<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah last_session_id masih ada di tabel sessions
            if ($user->last_session_id) {
                $exists = DB::table('sessions')->where('id', $user->last_session_id)->exists();

                if (!$exists) {
                    // Jika session hilang (expired/terhapus), reset last_session_id
                    $user->last_session_id = null;
                    $user->save();
                }
            }
        }

        return $next($request);
    }
}
