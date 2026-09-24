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
          <a href="{{route('logout')}}" class="dropdown-item">
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
          <a href="#" class="d-block">SISTEM MANAJEMEN</a>
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
       
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Dosen</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-danger mb-2"data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                <a href="{{ route('admin.dosen.reset') }}" onclick="return confirm('Yakin ingin mereset Data?')" type="button" class="btn btn-danger mb-2"><i class="fas fa-exclamation-triangle"> Reset Data</i></a>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor Data</button>
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-download"><i class="fas fa-download"></i> Download Template</button>
                <a href="#" class="btn btn-danger mb-2" target="_blank" type="button"><i class="fas fa-file-pdf"> Export pdf</i></a>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <td width="5%">no</td>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Kelamin</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($dosen as $data)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nik }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->kontak }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            @if($data->kelamin == 'l')
                             Laki-Laki
                            @else
                             Perempuan
                            @endif
                        </td>
                        <td align="center">
                            <button class="btn btn-default" data-toggle="modal" data-target="#modal-foto" data-nik="{{ $data->nik }}">
                                @if(!empty($data->img))
                                <img src="{{ asset(str_replace('../', '', $data->img)) }}" alt="Foto" width="50px">
                                @else
                                <img src="{{ asset($data->kelamin == 'l' ? 'asset_web/img/mhs_laki_laki.jpg' : 'asset_web/img/mhs_perempuan.jpg') }}" alt="Foto MHS" width="50px">
                                @endif
                            </button>
                        </td>
                        <td>
                            <a href="{{ route('admin.dosen.edit', $data->nik) }}" class="btn btn-warning btn-sm" type="button"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('admin.dosen.hapus', $data->nik) }}" class="btn btn-danger btn-sm" type="button" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
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

  <!-- Main Footer -->
   <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Dosen </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.dosen.store') }}" method="post">
              @csrf
            <div class="modal-body">
              <div class="form-group">
                    <label for="nik">Nik</label>
                    <input type="number" maxlength="10" name="nik" class="form-control" id="nik" placeholder="Masukkan nik" required>
                  </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="number" maxlength="13" name="kontak" class="form-control" id="kontak" placeholder="Masukkan Kontak" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" maxlength="100" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
                  </div>
                  <!-- select -->
                      <div class="form-group">
                        <label>Kelamin</label>
                        <select class="form-control" name="kelamin">
                          <option>Pilih Jenis Kelamin</option>
                          <option value="l">Laki-Laki</option>
                          <option value="p">Perempuan</option>
                        </select>
                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="btn_tambah_dosen">Tambah</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-foto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Foto Dosen </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.dosen.foto') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" name="nik" hidden>
                  <label for="file">Upload Foto </label>
                  <input type="file" class="form-control" name="file_foto" required >
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="btn_foto">Upload</button>
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
            <form action="{{ route('admin.dosen.impor') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="file">Upload File Template</label>
                  <input type="file" class="form-control" name="file_excel" required >
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="btn_impor">Impor</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-download">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Download Template </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="impor.php" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <p>Silahkan Download Template Berikut</p>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="window.location.href='template/template.xls'">Download File</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
       <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Dosen </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="ubah.php" method="post">
              @csrf
            <div class="modal-body">
              <div class="form-group">
                    <label for="nik">nik</label>
                    <input type="number" maxlength="10" name="nik" class="form-control" id="nik" placeholder="Masukkan nik" readonly>
                  </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="number" maxlength="13" name="kontak" class="form-control" id="kontak" placeholder="Masukkan Kontak" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" maxlength="100" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
                  </div>
                  <!-- select -->
                      <div class="form-group">
                        <label>Kelamin</label>
                        <select class="form-control" name="kelamin">
                          <option>Pilih Jenis Kelamin</option>
                          <option value="l">Laki-Laki</option>
                          <option value="p">Perempuan</option>
                        </select>
                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="btn_edit">Edit</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('layouts.script')

<script>
  $('#modal-edit').on('show.bs.modal', function (e){
    var nik = $(e.relatedTarget).data('nik');
    var nama = $(e.relatedTarget).data('nama');
    var kontak = $(e.relatedTarget).data('kontak');
    var email = $(e.relatedTarget).data('email');
    var kelamin = $(e.relatedTarget).data('kelamin');

    $(e.currentTarget).find('input[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);
  });

  $('#modal-foto').on('show.bs.modal', function(e){
    var nik = $(e.relatedTarget).data('nik');

    $(e.currentTarget).find('input[name="nik"]').val(nik);
  })
</script>
</body>
</html>
<?php 
?>