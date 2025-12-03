<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // Kalau user belum login
        if (!$user) {
            abort(403, 'Anda belum login.');
        }

        // Buat role tidak sensitif kapital
        $userRole = strtolower($user->role);
        $allowedRoles = array_map('strtolower', $roles);

        // Debug: tampilkan role jika error
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Akses ditolak. Role Anda: ' . $userRole);
        }

        return $next($request);
    }
}
