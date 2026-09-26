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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Data Detail Kelas</b></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-borderless border-0">
                            <tr>
                                <td>Nama Kelas</td>
                                <td>:</td>
                                <td>{{ $kelas->nama_kelas }}</td>
                            </tr>
                            <tr>
                                <td>Dosen Pengajar</td>
                                <td>:</td>
                                @php
                                    $dosen = \App\Models\Dosen::where('nik', $kelas->nik)->first();
                                @endphp
                                <td>{{ $dosen->nama }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-borderless border-0">
                            <tr>
                                <td>Tahun Akademik</td>
                                <td>:</td>
                                @php
                                    $akd = \App\Models\Periode::where('kode_akd', $kelas->kode_akd)->first();
                                @endphp
                                <td>{{ $akd->tahun }} - {{ ($akd->semester) == 'GL' ? 'Ganjil' : 'Genap' }}</td>
                            </tr>
                            <tr>
                                <td>Jurusan</td>
                                <td>:</td>
                                @php
                                    $jrs = \App\Models\Jurusan::where('kode_jurusan', $kelas->kode_jurusan)->first();
                                @endphp
                                <td>{{ $jrs->nama_jurusan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Data Mahasiswa</b></h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"> Tambah Data</i></button>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor Data</button>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                   @forelse ($detail as $data)
                    @php
                        $mhs = \App\Models\Mahasiswa::where('nim', $data->nim)->first();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>
                            <a href="{{ route('admin.kelas.hapus_detail', [$data->nim, $kelas->id]) }}" class="btn btn-danger btn-sm" type="button" onclick="return confirm('Yakin Hapus?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td>Tidak Ada Data</td>
                    </tr>
                   @endforelse
                  </tbody>
                </table>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       
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

   <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Mahasiswa </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.kelas.store_detail') }}" method="post">
            @csrf
            <div class="modal-body">
                  <div class="form-group">
                    <input type="int" name="id_kelas" class="form-control" id="id_kelas" value="" hidden>
                    </div>
                      <div class="form-group">
                        <label>Mahasiswa</label>
                        <input type="text" name="id_kls_mk" value="{{ $kelas->id }}" hidden>
                        <select class="form-control" name="nim">
                          @php
                            $data_mhs = \App\Models\Mahasiswa::all();
                          @endphp
                          @foreach ($data_mhs as $mahasiswa)
                            <option value="{{ $mahasiswa->nim }}">{{ $mahasiswa->nama }}</option>
                          @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="btn_tambah_detail_mhs">Tambah</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-impor">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Impor Data </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="impor.php" method="post" enctype="multipart/form-data">
                @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="file">Upload File Template</label>
                  <input type="int" value="" name="id_kelas" hidden>
                  <input type="file" class="form-control" name="file_excel" required >
                </div>
                {{-- <div>
                  <label for="download">Download Data</label>
                </div>
                <div class="form-group">
                  <input type="int" value="" name="id_kelas" hidden>
                  <a href="excel.php" target="_blank" class="btn btn-success btn-sm mb-2" type="button"><i class="fas fa-file-pdf"></i> Export Excel</a>
                </div> --}}
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary" name="impor_detail">Impor</button>
                </div>
              </div>    
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.script')
@include('layouts.modal_ganti_pin')

</body>
</html>
