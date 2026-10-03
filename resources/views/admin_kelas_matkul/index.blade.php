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
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <form action="{{ route('admin.kelas.index') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <select name="kode_akd" class="form-control">
                            @foreach ($periode as $p)
                                <option value="{{  $p->kode_akd }}">{{ $p->tahun}} - {{($p->semester) == 'GL' ? 'Ganjil' : 'Genap' }}</option>
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
                    <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"> Tambah Data</i></button>
                    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor Data</button>

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
                                        <a href="{{ route('admin.kelas.detail', $data->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i></a>
                                        <a href="{{ route('admin.kelas.pertemuan', $data->id) }}" class="btn btn-success btn-sm"><i class="fas fa-qrcode"></i></a>
                                        <a href="{{ route('admin.kelas.edit', $data->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('admin.kelas.hapus', $data->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" align="center">Tidak Ada Data</td>
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
  <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Periode </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.kelas.store') }}" method="post">
              @csrf
            <div class="modal-body">
                @php
                $data_akd = \App\Models\Periode::all();
                $data_matkul = \App\Models\Matkul::all();
                $data_dosen = \App\Models\Dosen::all();
                $data_jrs = \App\Models\Jurusan::all();
                @endphp
                <div class="form-group">
                    <label for="semester">Periode Akademik</label>
                    <select name="kode_akd" class="form-control">
                      @foreach ($data_akd as $akademik)
                        <option value="{{ $akademik->kode_akd }}">{{ $akademik->tahun }} - {{ ($akademik->semester) == 'GL' ? 'Ganjil' : 'Genap' }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kode_makul">Mata Kuliah</label>
                    <select name="kode_makul" class="form-control">
                      @foreach ($data_matkul as $matkul)
                        <option value="{{ $matkul->kode_makul }}">{{ $matkul->nama_makul }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kode_jurusan">Jurusan</label>
                    <select name="kode_jurusan" class="form-control">
                      @foreach ($data_jrs as $jrs)
                        <option value="{{ $jrs->kode_jurusan }}">{{ $jrs->nama_jurusan }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nik">Dosen</label>
                    <select name="nik" class="form-control">
                      @foreach ($data_dosen as $dosen)
                        <option value="{{ $dosen->nik }}">{{ $dosen->nama }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label for="nama_kelas">Nama Kelas</label>
                  <input type="text" class="form-control" name="nama_kelas" placeholder="Masukkan Nama Kelas" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="btn_tambah_mahasiswa">Tambah</button>
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
            <form action="{{ route('admin.kelas.impor_detail') }}" method="post" enctype="multipart/form-data">
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
