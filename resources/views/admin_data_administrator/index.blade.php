<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('layouts.css')
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      @include('layouts.sidebar_admin')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
     <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Data Pengguna</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fa fa-plus"></i> Tambah Data</button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr align="center">
                    <th>No</th>
                    <th>Username</th>
                    <th>Peran</th>
                    <th>PIN</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($users as $user)
                        <tr align="center" id="row-user-{{ $user->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                              @if ($user->peran === 'A')
                                <span class="badge badge-danger">Admin</span>
                              @elseif ($user->peran === 'M')
                                <span class="badge badge-primary">Mahasiswa</span>
                              @else
                                <span class="badge badge-success">Dosen</span>
                              @endif
                            </td>
                            <td>{{ $user->pin }}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                @if ($user->peran === 'A' && ($adminCount ?? 1) <= 1)
                                  <button type="button" class="btn btn-danger btn-sm btn-delete-last-admin" data-username="{{ $user->username }}" title="Admin sisa satu tidak bisa dihapus">
                                    <i class="fas fa-trash"></i> Hapus
                                  </button>
                                @else
                                  <button type="button" class="btn btn-danger btn-sm btn-delete-user" data-id="{{ $user->id }}" data-username="{{ $user->username }}" data-url="{{ route('admin.user.destroy', $user->id) }}" onclick="return confirm('Yakin Hapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                  </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" align="center">Data Tidak Ditemukan</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Modal Tambah Data Pengguna (Warna Biru) -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title font-weight-bold text-white">
            <i class="fas fa-user-plus mr-2"></i> Tambah Data Pengguna
          </h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.user.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Username <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="{{ old('username') }}" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
              <label for="peran">Pilih Peran <span class="text-danger">*</span></label>
              <select class="form-control" id="peran" name="peran" required>
                <option value="">-- Pilih Peran --</option>
                <option value="M" {{ old('peran') == 'M' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="D" {{ old('peran') == 'D' ? 'selected' : '' }}>Dosen</option>
                <option value="A" {{ old('peran') == 'A' ? 'selected' : '' }}>Admin</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary font-weight-bold" name="tambah">
              <i class="fas fa-save mr-1"></i> Tambah Data
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
@include('layouts.script')
@include('layouts.modal_ganti_pin')

<script>
$(document).ready(function() {
  // Tombol hapus ketika admin sisa 1
  $(document).on('click', '.btn-delete-last-admin', function(e) {
    e.preventDefault();
    
    // Tampilkan notifikasi / modal / toast bahwa admin sisa satu tidak bisa dihapus
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan',
      text: 'admin sisa satu tidak bisa dihapus',
      confirmButtonText: 'Tutup',
      confirmButtonColor: '#d33'
    });

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3500
    });
    Toast.fire({
      icon: 'warning',
      title: 'admin sisa satu tidak bisa dihapus'
    });
  });

  // Tombol hapus untuk user biasa atau admin jika total admin > 1
  $(document).on('click', '.btn-delete-user', function(e) {
    e.preventDefault();
    var userId = $(this).data('id');
    var username = $(this).data('username');
    var deleteUrl = $(this).data('url');

    Swal.fire({
      title: 'Hapus Pengguna?',
      text: 'Apakah Anda yakin ingin menghapus user "' + username + '"?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: deleteUrl,
          type: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function(res) {
            if (res.success) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res.message || 'Gagal menghapus user.'
              });
            }
          },
          error: function(xhr) {
            var msg = 'Terjadi kesalahan saat menghapus user.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
              msg = xhr.responseJSON.message;
            }
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: msg
            });
          }
        });
      }
    });
  });
});
</script>

</body>
</html>

