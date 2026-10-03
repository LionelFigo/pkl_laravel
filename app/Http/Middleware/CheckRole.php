<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil data user dari session
        $user = session('user');

        // Jika belum login atau tidak memiliki peran
        if (!$user || !isset($user['peran'])) {
            session()->forget('user');
            return redirect()->route('login')->with('error', 'User Melakukan Cross Authority');
        }

        // Kumpulkan semua role yang diizinkan (mendukung parameter variadic dan dipisah koma)
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $clean = ltrim(strtolower(trim($r)), ':');
                if ($clean !== '') {
                    $allowedRoles[] = $clean;
                }
            }
        }

        $peranUser = strtolower(trim($user['peran']));

        // Jika ada role yang ditentukan dan peran user tidak sesuai, tolak akses dan logout sesuai logika native
        if (!empty($allowedRoles) && !in_array($peranUser, $allowedRoles)) {
            session()->forget('user');
            return redirect()->route('login')->with('error', 'User Melakukan Cross Authority');
        }

        return $next($request);
    }
}
