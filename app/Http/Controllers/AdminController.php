<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('home_admin.index');
    }

    public function dataAdministrator()
    {
        $users = User::all();
        $adminCount = User::whereIn('peran', ['a', 'A'])->count();

        return view('admin_data_administrator.index', compact('users', 'adminCount'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:user,username',
            'nama'     => 'required|string|max:255',
            'peran'    => 'required|in:M,D,A,m,d,a'
        ], [
            'username.unique'   => 'Username sudah digunakan',
            'username.required' => 'Username wajib diisi',
            'nama.required'     => 'Nama wajib diisi',
            'peran.required'    => 'Peran wajib diisi'
        ]);

        User::create([
            'username' => trim($request->username),
            'nama'     => trim($request->nama),
            'peran'    => strtolower($request->peran),
            'password' => sha1(trim($request->username)), // password default sama dengan username
            'pin'      => sha1('1234'),
        ]);

        return back()->with('success', 'Data Berhasil Ditambahkan');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin_data_administrator.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'  => 'required|string|max:255',
            'peran' => 'required|in:M,D,A,m,d,a'
        ], [
            'nama.required'  => 'Nama wajib diisi',
            'peran.required' => 'Peran wajib diisi'
        ]);

        if (strtoupper($user->peran) === 'A' && strtoupper($request->peran) !== 'A') {
            $adminCount = User::whereIn('peran', ['a', 'A'])->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'admin sisa satu tidak bisa diubah perannya');
            }
        }

        $user->update([
            'nama'  => trim($request->nama),
            'peran' => strtolower($request->peran)
        ]);

        return redirect()->route('admin.data_administrator')->with('success', 'Data berhasil diperbarui');
    }

    public function destroyUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan.'
                ], 404);
            }
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        // Cek jika user yang akan dihapus adalah Admin dan admin yang tersisa hanya 1
        if (strtoupper($user->peran) === 'A') {
            $adminCount = User::whereIn('peran', ['a', 'A'])->count();
            if ($adminCount <= 1) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'admin sisa satu tidak bisa dihapus'
                    ], 422);
                }
                return back()->with('error', 'admin sisa satu tidak bisa dihapus');
            }
        }

        $user->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil dihapus!'
            ]);
        }

        return back()->with('success', 'Data pengguna berhasil dihapus!');
    }
}


