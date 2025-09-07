<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          $minVersion = '2.0.0'; // versi minimal ekstensi

        $current = $request->header('X-Extension-Version');

        if (!$current || version_compare($current, $minVersion, '<')) {
            return response()->json([
                'status' => 'blocked',
                'message' => 'Ekstensi Anda sudah kedaluwarsa. Harap update.'
            ], 403);
        }
        return $next($request);
    }
}
