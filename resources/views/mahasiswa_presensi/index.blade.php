<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('layouts.css')
  <style>
    #reader {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
    }
    #reader video {
      border-radius: 8px;
    }
  </style>
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
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          {{ session('user')['nama'] ?? session('user')['username'] }} - [{{ session('user')['peran'] ?? 'M' }}] <i class="far fa-user"></i>
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
          <a href="#" class="d-block">SISTEM MANAJEMEN</a>
        </div>
      </div>

      <!-- Sidebar Menu --> 
      @include('layouts.sidebar_mahasiswa')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Presensi Mahasiswa</h1>
          </div>
        </div>
      </div> 
    </div>
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-qrcode mr-2"></i>Scan QR Code Presensi</h3>
          </div>
          <div class="card-body text-center">
            <div id="reader"></div>
            <p class="text-muted mt-3">Silakan arahkan kamera ke QR Code pertemuan untuk melakukan presensi.</p>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.script')
@include('layouts.modal_ganti_pin')

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>   
<script>
    let isProcessing = false;

    function onScanSuccess(decodedText, decodedResult) {
      if (isProcessing) return;
      isProcessing = true;

      try {
        html5QrcodeScanner.clear();
      } catch (e) {
        console.error(e);
      }

      window.location.href = "{{ route('mahasiswa.presensi.proses') }}?id_pertemuan=" + encodeURIComponent(decodedText);
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>

@if(session('alert'))
<script>
    alert("{{ session('alert') }}");
</script>
@endif

</body>
</html>
