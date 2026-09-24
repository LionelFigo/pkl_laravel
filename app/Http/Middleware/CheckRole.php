<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Ambil data user dari session
        $user = session('user');

        // Pastikan huruf besar/kecil seragam untuk pengecekan
        $peranUser = strtolower(trim($user['peran']));
        $peranDiizinkan = strtolower(trim($role));

        // Jika peran tidak sesuai, tolak aksesnya
        if ($peranUser !== $peranDiizinkan) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
