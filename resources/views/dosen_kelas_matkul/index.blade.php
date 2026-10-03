<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('layouts.css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
      @include('layouts.sidebar_dosen')
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
        
        <form action="{{ route('dosen.kelas.index') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <select name="kode_akd" class="form-control">
                            @foreach ($periode as $p)
                                <option value="{{  $p->kode_akd }}" {{ request('kode_akd') == $p->kode_akd ? 'selected' : '' }}>{{ $p->tahun}} - {{($p->semester) == 'GL' ? 'Ganjil' : 'Genap' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary" name="cari"><i class="fas fa-search"> Tampilkan Data</i></button>
                </div>
            </div>
        </form>
        @if (request()->has('kode_akd'))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kelas Matkul</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kelas</th>
                                <th>Akademik</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelas as $data)
                                @php
                                    $akd = \App\Models\Periode::where('kode_akd',$data->kode_akd)->first();
                                    $matkul = \App\Models\Matkul::where('kode_makul',$data->kode_makul)->first();
                                    $dosen = \App\Models\Dosen::where('nik',$data->nik)->first();
                                    $jrs = \App\Models\Jurusan::where('kode_jurusan',$data->kode_jurusan)->first();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_kelas }}</td>
                                    <td>{{ $akd->tahun }} - {{ ($akd->semester) == 'GL' ? 'Ganjil' : 'Genap' }}</td>
                                    <td>{{ $matkul->nama_makul }}</td>
                                    <td>{{ $dosen->nama }}</td>
                                    <td>{{ $jrs->nama_jurusan }}</td>
                                    <td>
                                      <a href="{{ route('dosen.kelas.detail', $data->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i></a>
                                      <a href="{{ route('dosen.kelas.pertemuan', $data->id) }}" class="btn btn-success btn-sm"><i class="fas fa-qrcode"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" align="center">Tidak Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- /.row -->
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
