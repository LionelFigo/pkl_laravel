<?php

namespace Tests\Feature;

use App\Models\Pertemuan;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PresensiMhsTest extends TestCase
{
    public function test_mahasiswa_presensi_page_accessible_by_mahasiswa()
    {
        $response = $this->withSession([
            'user' => [
                'id'       => 999,
                'username' => 'test_nim',
                'nama'     => 'Test Mahasiswa',
                'peran'    => 'm',
            ]
        ])->get('/mahasiswa_presensi');

        $response->assertStatus(200);
        $response->assertSee('Presensi Mahasiswa');
        $response->assertSee('html5-qrcode');
    }

    public function test_check_role_blocks_cross_authority_and_redirects_to_login()
    {
        // Admin mencoba mengakses halaman mahasiswa
        $response = $this->withSession([
            'user' => [
                'id'       => 100,
                'username' => 'admin_user',
                'nama'     => 'Admin Test',
                'peran'    => 'a',
            ]
        ])->get('/mahasiswa_presensi');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'User Melakukan Cross Authority');
        $this->assertNull(session('user'));
    }

    public function test_proses_presensi_ditutup_when_status_pertemuan_is_0()
    {
        $pertemuanId = DB::table('pertemuan')->insertGetId([
            'id_kelas'        => 1,
            'tanggal'         => date('Y-m-d'),
            'judul_pertemuan' => 'Test Pertemuan Tertutup',
            'status_presensi' => 0,
            'pertemuan_ke'    => 99,
        ]);

        $response = $this->withSession([
            'user' => [
                'id'       => 999,
                'username' => 'test_nim',
                'nama'     => 'Test Mahasiswa',
                'peran'    => 'm',
            ]
        ])->get('/mahasiswa_presensi/proses?id_pertemuan=' . $pertemuanId);

        $response->assertRedirect(route('mahasiswa.presensi'));
        $response->assertSessionHas('error', 'Presensi Ditutup');

        DB::table('pertemuan')->where('id', $pertemuanId)->delete();
    }

    public function test_proses_presensi_sudah_absen()
    {
        $pertemuanId = DB::table('pertemuan')->insertGetId([
            'id_kelas'        => 1,
            'tanggal'         => date('Y-m-d'),
            'judul_pertemuan' => 'Test Pertemuan Terbuka',
            'status_presensi' => 1,
            'pertemuan_ke'    => 99,
        ]);

        $presensiId = DB::table('presensi')->insertGetId([
            'id_pertemuan'     => $pertemuanId,
            'nim'              => 'test_nim',
            'status_kehadiran' => 'h',
        ]);

        $response = $this->withSession([
            'user' => [
                'id'       => 999,
                'username' => 'test_nim',
                'nama'     => 'Test Mahasiswa',
                'peran'    => 'm',
            ]
        ])->get('/mahasiswa_presensi/proses?id_pertemuan=' . $pertemuanId);

        $response->assertRedirect(route('mahasiswa.presensi'));
        $response->assertSessionHas('error', 'Anda Sudah Melakukan Absensi');

        DB::table('presensi')->where('id', $presensiId)->delete();
        DB::table('pertemuan')->where('id', $pertemuanId)->delete();
    }

    public function test_proses_presensi_berhasil_melakukan_absensi()
    {
        $pertemuanId = DB::table('pertemuan')->insertGetId([
            'id_kelas'        => 1,
            'tanggal'         => date('Y-m-d'),
            'judul_pertemuan' => 'Test Pertemuan Terbuka',
            'status_presensi' => 1,
            'pertemuan_ke'    => 99,
        ]);

        $presensiId = DB::table('presensi')->insertGetId([
            'id_pertemuan'     => $pertemuanId,
            'nim'              => 'test_nim',
            'status_kehadiran' => 'a',
        ]);

        $response = $this->withSession([
            'user' => [
                'id'       => 999,
                'username' => 'test_nim',
                'nama'     => 'Test Mahasiswa',
                'peran'    => 'm',
            ]
        ])->get('/mahasiswa_presensi/proses?id_pertemuan=' . $pertemuanId);

        $response->assertRedirect(route('mahasiswa.presensi'));
        $response->assertSessionHas('success', 'Berhasil Melakukan Absensi');

        $updated = DB::table('presensi')->where('id', $presensiId)->first();
        $this->assertEquals('h', $updated->status_kehadiran);

        DB::table('presensi')->where('id', $presensiId)->delete();
        DB::table('pertemuan')->where('id', $pertemuanId)->delete();
    }
}
