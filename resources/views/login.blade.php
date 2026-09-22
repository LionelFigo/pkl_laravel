<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('asset_web/dist/css/adminlte.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/toastr/toastr.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('asset_web/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Sistem Informasi XYZ</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form id="form-login" action="{{ route('login.post') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username"
                 value="{{ old('username') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="social-auth-links text-center mb-3">
          <!-- Tombol memicu Modal PIN -->
          <button type="button" id="btn-show-pin" class="btn btn-block btn-primary">
            <i class="fas fa-sign-in-alt mr-2"></i> Login Akun
          </button>
        </div>

        <!-- Modal PIN -->
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-key mr-2"></i>Masukkan PIN</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Masukkan PIN Anda</p>
                <div class="input-group mb-3">
                  <input type="password" name="pin" class="form-control"
                         placeholder="Masukkan PIN anda" maxlength="6" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-key"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal -->

      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Scripts -->
<script src="{{ asset('asset_web/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset_web/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/toastr/toastr.min.js') }}"></script>

<script>
$(document).ready(function() {

  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  // Tombol Login — cek username+password dulu via AJAX sebelum buka modal PIN
  $('#btn-show-pin').on('click', function() {
    var username = $('input[name="username"]').val().trim();
    var password = $('input[name="password"]').val().trim();

    // Validasi field kosong
    if (username === '' || password === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Peringatan',
        text: 'Silakan isi Username dan Password terlebih dahulu!'
      });
      return;
    }

    // Disable tombol agar tidak diklik 2x
    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memeriksa...');

    // AJAX cek username + password ke server
    $.ajax({
      url: '{{ route("check.credentials") }}',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        username: username,
        password: password
      },
      success: function(res) {
        if (res.valid) {
          // Username & password benar — buka modal PIN
          $('#modal-default').modal('show');
        } else {
          // Salah — tampil toast error, modal tidak dibuka
          Toast.fire({
            icon: 'error',
            title: res.message
          });
        }
      },
      error: function() {
        Toast.fire({
          icon: 'error',
          title: 'Terjadi kesalahan, coba lagi.'
        });
      },
      complete: function() {
        // Kembalikan tombol ke semula
        $btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt mr-2"></i> Login Akun');
      }
    });
  });

  // Toast error dari server (misal PIN salah setelah submit form)
  @if (session('error'))
    Toast.fire({
      icon: 'error',
      title: '{{ session('error') }}'
    });
  @endif

});
</script>
</body>
</html>
