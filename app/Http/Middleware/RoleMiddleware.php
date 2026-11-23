<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Mengembalikan 403 Forbidden secara server-side jika role pengguna tidak sesuai.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Mendukung multi-role seperti 'admin,ormawa' maupun beberapa argumen middleware
        $authorized = false;
        foreach ($roles as $roleGroup) {
            $roleNames = array_map('trim', explode(',', $roleGroup));
            foreach ($roleNames as $roleName) {
                if ($user->hasRole($roleName)) {
                    $authorized = true;
                    break 2;
                }
            }
        }

        if (!$authorized) {
            abort(403, 'Akses Ditolak (403 Forbidden): Anda tidak memiliki hak akses role untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
