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
            <h3 class="card-title"><strong>Edit Data Kelas Mata Kuliah</strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="kode_akd">Periode Akademik</label>
                <select name="kode_akd" class="form-control">
                  @foreach ($periode as $akademik)
                    <option value="{{ $akademik->kode_akd }}" {{ old('kode_akd', $kelas->kode_akd) == $akademik->kode_akd ? 'selected' : '' }} >{{ $akademik->tahun }} - {{ $akademik->semester }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kode_makul">Mata Kuliah</label>
                <select name="kode_makul" class="form-control">
                  @foreach ($matkul as $data_matkul)
                    <option value="{{ $data_matkul->kode_makul }}" {{ old('kode_makul', $kelas->kode_makul) == $data_matkul->kode_makul ? 'selected' : '' }} >{{ $data_matkul->nama_makul }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kode_jurusan">Jurusan</label>
                <select name="kode_jurusan" class="form-control">
                  @foreach ($jurusan as $jrs)
                    <option value="{{ $jrs->kode_jurusan }}" {{ old('kode_jurusan', $kelas->kode_jurusan) == $jrs->kode_jurusan ? 'selected' : '' }} >{{ $jrs->nama_jurusan }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="nik">Dosen</label>
                <select name="nik" class="form-control">
                  @foreach ($dosen as $data_dosen)
                    <option value="{{ $data_dosen->nik }}" {{ old('nik', $kelas->nik) == $data_dosen->nik ? 'selected' : '' }} >{{ $data_dosen->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" class="form-control" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
              </div>
              <div class="modal-footer justify-content-between px-0">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-default">Batal</a>
                <button type="submit" class="btn btn-primary" name="edit">
                  <i class="fas fa-save mr-1"></i> Edit
                </button>
              </div>
            </form>
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

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.script')
@include('layouts.modal_ganti_pin')

</body>
</html>
