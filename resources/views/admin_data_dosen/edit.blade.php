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
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
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
                            <h3 class="card-title">Edit Data dosen</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.dosen.update', $dosen->nik) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="nik" value="{{ $dosen->nik }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $dosen->nama) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kontak">Kontak</label>
                                    <input type="number" name="kontak" id="kontak" maxlength="13" value="{{ old('kontak', $dosen->kontak) }}" class="form-control">
                                </div>
                                 <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $dosen->email) }}" required>
                                </div>
                                 <div class="form-group">
                                    <label for="kelamin">Jenis Kelamin</label>
                                    <select name="kelamin" class="form-control">
                                        <option value="">--Piih jenis Kelamin--</option>
                                        <option value="l" {{ old('kelamin', $dosen->kelamin) == 'l' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="p" {{ old('kelamin', $dosen->kelamin) == 'p' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="modal-footer justify-content-between px-0">
                                    <a href="{{ route('admin.dosen.index') }}" class="btn btn-default">Batal</a>
                                    <button type="submit" class="btn btn-primary" name="edit">
                                    <i class="fas fa-save mr-1"></i> Edit
                                    </button>
                                </div>
                            </form>
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

        <!-- Main Footer -->
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @include('layouts.script')
    @include('layouts.modal_ganti_pin')

</body>

</html>
