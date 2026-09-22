<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Dosen</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset_web/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Selamat Datang, Dosen!</h1>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="card card-success card-outline">
          <div class="card-body">
            <p>Halo <strong>{{ session('user')['nama'] ?? session('user')['username'] }}</strong>, kamu login sebagai <strong>Dosen</strong>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <strong>PKL Laravel</strong>
  </footer>
</div>

<script src="{{ asset('asset_web/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('asset_web/dist/js/adminlte.min.js') }}"></script>
@include('layouts.modal_ganti_pin')
</body>
</html>
