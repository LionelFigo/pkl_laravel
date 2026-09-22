<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        // Kalau sudah login, redirect ke home sesuai peran
        if (session()->has('user')) {
            return $this->redirectByPeran(session('user')['peran']);
        }

        return view('login');
    }

    /**
     * Cek username + password saja (AJAX) — sebelum modal PIN muncul
     * Return JSON: { valid: true } atau { valid: false, message: '...' }
     */
    public function checkCredentials(Request $request)
    {
        $username = trim($request->input('username'));
        $rawPassword = trim($request->input('password'));
        $passwordSha1 = sha1($rawPassword);

        $exists = DB::table('user')
            ->where('username', $username)
            ->where(function ($query) use ($passwordSha1, $rawPassword) {
                $query->where('password', $passwordSha1)
                      ->orWhere('password', $rawPassword);
            })
            ->exists();

        if (!$exists) {
            return response()->json([
                'valid'   => false,
                'message' => 'Username atau Password salah!'
            ]);
        }

        return response()->json(['valid' => true]);
    }

    /**
     * Proses login (username + password sha1 / plaintext + pin)
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'pin'      => 'required',
        ]);

        $username = trim($request->input('username'));
        $rawPassword = trim($request->input('password'));
        $passwordSha1 = sha1($rawPassword);
        $pin      = trim($request->input('pin'));
        $pinSha1  = sha1($pin);

        // Query ke tabel user menggunakan kolom 'password'
        $user = DB::table('user')
            ->where('username', $username)
            ->where(function ($query) use ($passwordSha1, $rawPassword) {
                $query->where('password', $passwordSha1)
                      ->orWhere('password', $rawPassword);
            })
            ->where(function ($query) use ($pin, $pinSha1) {
                $query->where('pin', $pin)
                      ->orWhere('pin', $pinSha1);
            })
            ->first();

        if (!$user) {
            return back()->with('error', 'Username, Password, atau PIN salah!');
        }

        // Simpan data user ke session
        session([
            'user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'nama'     => $user->nama ?? $user->username,
                'peran'    => $user->peran,
            ]
        ]);

        return $this->redirectByPeran($user->peran);
    }


    /**
     * Logout — hapus session dan redirect ke login
     */
    public function logout()
    {
        session()->forget('user');
        return redirect('/');
    }

    /**
     * Redirect berdasarkan peran (sama seperti native)
     * M = Mahasiswa, A = Admin, selain itu = Dosen
     */
    private function redirectByPeran(string $peran)
    {
        $peranUpper = strtoupper(trim($peran));

        if ($peranUpper === 'M') {
            return redirect()->route('home.mahasiswa');
        } elseif ($peranUpper === 'A') {
            return redirect()->route('home.admin');
        } else {
            return redirect()->route('home.dosen');
        }
    }
}
