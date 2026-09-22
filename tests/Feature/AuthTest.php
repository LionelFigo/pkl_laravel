<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_check_credentials_success()
    {
        $response = $this->postJson('/check-credentials', [
            'username' => 'figo',
            'password' => 'figo',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['valid' => true]);
    }

    public function test_check_credentials_invalid_password()
    {
        $response = $this->postJson('/check-credentials', [
            'username' => 'figo',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['valid' => false]);
    }

    public function test_login_mahasiswa_redirects_to_home_mahasiswa()
    {
        $response = $this->post('/login', [
            'username' => 'figo',
            'password' => 'figo',
            'pin'      => '1234',
        ]);

        $response->assertRedirect(route('home.mahasiswa'));
        $this->assertEquals('M', session('user')['peran']);
    }

    public function test_login_admin_redirects_to_home_admin()
    {
        $response = $this->post('/login', [
            'username' => 'adminprodi',
            'password' => 'adminprodi',
            'pin'      => '1234',
        ]);

        $response->assertRedirect(route('home.admin'));
        $this->assertEquals('A', session('user')['peran']);
    }

    public function test_login_dosen_redirects_to_home_dosen()
    {
        $response = $this->post('/login', [
            'username' => 'dosen',
            'password' => 'dosen',
            'pin'      => '1234',
        ]);

        $response->assertRedirect(route('home.dosen'));
        $this->assertEquals('D', session('user')['peran']);
    }

    public function test_admin_data_administrator_page()
    {
        $response = $this->withSession([
            'user' => [
                'id' => 20,
                'username' => 'admin',
                'nama' => 'admin',
                'peran' => 'A',
                'is_first_login' => false,
            ]
        ])->get('/admin_data_administrator');

        $response->assertStatus(200);
        $response->assertSee('figo');
        $response->assertSee('dosen');
    }

    public function test_update_pin_success()
    {
        $response = $this->withSession([
            'user' => [
                'id' => 1,
                'username' => 'figo',
                'nama' => 'Figo Firgiawan',
                'peran' => 'M',
                'is_first_login' => true,
            ]
        ])->postJson('/update-pin', [
            'pin'              => '9876',
            'pin_confirmation' => '9876',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Cek database
        $this->assertDatabaseHas('user', [
            'id'             => 1,
            'pin'            => 9876,
            'is_first_login' => 0,
        ]);

        // Kembalikan PIN figo ke 1234
        \Illuminate\Support\Facades\DB::table('user')->where('id', 1)->update([
            'pin' => 1234,
            'is_first_login' => 1,
        ]);
    }

    public function test_update_pin_validation_fails_mismatch()
    {
        $response = $this->withSession([
            'user' => [
                'id' => 1,
                'username' => 'figo',
                'nama' => 'Figo Firgiawan',
                'peran' => 'M',
                'is_first_login' => true,
            ]
        ])->postJson('/update-pin', [
            'pin'              => '1234',
            'pin_confirmation' => '9999',
        ]);

        $response->assertStatus(422);
    }

    public function test_cannot_delete_last_admin()
    {
        // Pastikan hanya ada 1 admin
        $admins = \App\Models\User::where('peran', 'A')->get();
        // Buat temporary admin jika ada 2 admin, atau hapus yang lain sementara dalam transaction
        // Mari kita buat skenario di mana hanya ada 1 admin di DB
        $tempUser = \App\Models\User::create([
            'username' => 'temp_admin',
            'sandi' => sha1('temp'),
            'peran' => 'A',
            'pin' => 1234,
            'nama' => 'Temp Admin',
            'is_first_login' => 0,
        ]);

        // Hapus tempUser sehingga tersisa admin-admin asli
        $tempUser->delete();

        // Ambil semua admin saat ini
        $adminList = \App\Models\User::where('peran', 'A')->get();
        if ($adminList->count() > 1) {
            // Ubah sementara peran admin lain agar tersisa tepat 1 admin
            $otherAdmins = $adminList->slice(1);
            foreach ($otherAdmins as $adm) {
                \Illuminate\Support\Facades\DB::table('user')->where('id', $adm->id)->update(['peran' => 'X']);
            }
        }

        $singleAdmin = \App\Models\User::where('peran', 'A')->first();

        $response = $this->withSession([
            'user' => [
                'id' => $singleAdmin->id,
                'username' => $singleAdmin->username,
                'nama' => $singleAdmin->nama,
                'peran' => 'A',
                'is_first_login' => false,
            ]
        ])->deleteJson('/admin/user/' . $singleAdmin->id);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'admin sisa satu tidak bisa dihapus',
        ]);

        // Kembalikan peran admin yang diubah sementara
        if (isset($otherAdmins)) {
            foreach ($otherAdmins as $adm) {
                \Illuminate\Support\Facades\DB::table('user')->where('id', $adm->id)->update(['peran' => 'A']);
            }
        }
    }

    public function test_can_delete_admin_when_more_than_one_admin()
    {
        // Tambahkan dummy admin
        $dummyAdmin = \App\Models\User::create([
            'username' => 'dummy_admin_test',
            'sandi' => sha1('dummy'),
            'peran' => 'A',
            'pin' => 1234,
            'nama' => 'Dummy Admin',
            'is_first_login' => 0,
        ]);

        $response = $this->withSession([
            'user' => [
                'id' => 20,
                'username' => 'admin',
                'nama' => 'admin',
                'peran' => 'A',
                'is_first_login' => false,
            ]
        ])->deleteJson('/admin/user/' . $dummyAdmin->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Data pengguna berhasil dihapus!',
        ]);

        $this->assertDatabaseMissing('user', [
            'id' => $dummyAdmin->id,
        ]);
    }

    public function test_store_user_success()
    {
        $uniqueUsername = 'user_test_' . time();
        $response = $this->withSession([
            'user' => [
                'id' => 20,
                'username' => 'admin',
                'nama' => 'admin',
                'peran' => 'A',
                'is_first_login' => false,
            ]
        ])->post('/admin/user/tambah', [
            'username' => $uniqueUsername,
            'nama'     => 'User Test Nama',
            'peran'    => 'M',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('user', [
            'username' => $uniqueUsername,
            'nama'     => 'User Test Nama',
            'peran'    => 'M',
            'pin'      => 1234,
        ]);
    }

    public function test_edit_user_page()
    {
        $response = $this->withSession([
            'user' => [
                'id' => 20,
                'username' => 'admin',
                'nama' => 'admin',
                'peran' => 'A',
                'is_first_login' => false,
            ]
        ])->get('/admin/user/1/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Data Pengguna');
        $response->assertSee('figo');
    }

    public function test_update_user_success()
    {
        $response = $this->withSession([
            'user' => [
                'id' => 20,
                'username' => 'admin',
                'nama' => 'admin',
                'peran' => 'A',
                'is_first_login' => false,
            ]
        ])->put('/admin/user/1/update', [
            'nama'  => 'Figo Firgiawan Updated',
            'peran' => 'M',
        ]);

        $response->assertRedirect(route('admin.data_administrator'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('user', [
            'id'   => 1,
            'nama' => 'Figo Firgiawan Updated',
        ]);

        // Kembalikan nama semula
        \App\Models\User::where('id', 1)->update(['nama' => 'Figo Firgiawan']);
    }
}


