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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-header">Kelas Mata Kuliah {{ $kelas->id }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 text-center border-right">
                                    @if ($kelas->dosen->kelamin == 'l')
                                        <img src="{{ !empty($kelas->dosen->img) ? asset($kelas->dosen->img) : asset('asset_web/img/mhs_laki_laki.jpg') }}"
                                            alt="Foto Dosen" width="200px">
                                    @else
                                        <img src="{{ !empty($kelas->dosen->img) ? asset($kelas->dosen->img) : asset('asset_web/img/mhs_perempuan.jpg') }}"
                                            alt="Foto Dosen" width="200px">
                                    @endif

                                    @if ($pertemuan->status_presensi == 1)
                                        <a href="{{ route('presensi.ubah_status', ['id_pertemuan' => $pertemuan->id, 'aksi' => 'tutup']) }}"
                                            class="btn btn-danger btn-block btn-md mb-2 mt-2"
                                            onclick="return confirm('Yakin Tutup Presensi')">Tutup</a>
                                    @else
                                        <a href="{{ route('presensi.ubah_status', ['id_pertemuan' => $pertemuan->id, 'aksi' => 'buka']) }}"
                                            class="btn btn-success btn-block btn-md mb-2 mt-2"
                                            onclick="return confirm('Yakin Buka Presensi')">Buka</a>
                                    @endif


                                </div>
                                <div class="col-lg-5 border-right">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>NIK</td>
                                            <td>:</td>
                                            <td>{{ $kelas->dosen->nik }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ $kelas->dosen->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Mata Kuliah</td>
                                            <td>:</td>
                                            <td>{{ $kelas->matkul->nama_makul }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelas</td>
                                            <td>:</td>
                                            <td>{{ $kelas->nama_kelas }}</td>
                                        </tr>
                                        <tr>
                                            <td>Judul Materi</td>
                                            <td>:</td>
                                            <td>{{ $pertemuan->judul_pertemuan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jurusan</td>
                                            <td>:</td>
                                            <td>{{ $kelas->jurusan->nama_jurusan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hari</td>
                                            <td>:</td>
                                            <td>{{ date('l') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td>{{ date('d F Y', strtotime($pertemuan->tanggal)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pertemuan</td>
                                            <td>:</td>
                                            <td>{{ $pertemuan->pertemuan_ke }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-4 text-center">
                                    {!! $qr !!}

                                    <p class="mt-2">Scan QR Untuk Melakukan Presensi</p>
                                    <p id="demo" class="text-danger font-weight-bold" style="font-size: 1.2rem;">
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div id="presensi"></div>
                                </div>
                            </div>
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
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Presensi Mahasiswa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('presensi.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="id_presensi" class="form-control" id="id_presensi" hidden>
                                <input type="text" name="id_pertemuan" class="form-control" id="id_pertemuan"
                                    value="{{ $pertemuan->id }}" hidden>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="nama_mhs" hidden>
                            </div>
                            <!-- select -->
                            <div class="form-group">
                                <label>Status Kehadiran</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="">--Pilih status kehadiran--</option>
                                    <option value="h">Hadir</option>
                                    <option value="i">Izin</option>
                                    <option value="s">Sakit</option>
                                    <option value="a">Alpha</option>
                                    <option value="d">Dispen</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="btn_edit_presensi">Simpan</button>
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

    <script>
        var isModalOpen = false;

        $(document).on('click', '[data-target="#modal-edit"]', function() {
            var id_presensi = $(this).data('id_presensi');
            var nim = $(this).data('nim');
            var nama = $(this).data('nama');
            var status = $(this).data('status_kehadiran');

            $('#modal-edit input[name="id_presensi"]').val(id_presensi);
            $('#modal-edit #nama_mhs').val((nim ? nim + ' - ' : '') + (nama || ''));
            $('#modal-edit select[name="status"]').val(status);
        });

        $('#modal-edit').on('show.bs.modal', function(e) {
            isModalOpen = true;
            var button = $(e.relatedTarget);
            if (button.length) {
                var id_presensi = button.data('id_presensi');
                var nim = button.data('nim');
                var nama = button.data('nama');
                var status = button.data('status_kehadiran');

                $(this).find('input[name="id_presensi"]').val(id_presensi);
                $(this).find('#nama_mhs').val((nim ? nim + ' - ' : '') + (nama || ''));
                $(this).find('select[name="status"]').val(status);
            }
        });

        $('#modal-edit').on('hidden.bs.modal', function() {
            isModalOpen = false;
        });

        function refresh_tabel() {
            if (!isModalOpen) {
                $('#presensi').load("{{ route('presensi.tabel', $pertemuan->id) }}");
            }
            setTimeout(refresh_tabel, 2000);
        }
        $(document).ready(function() {
            refresh_tabel();
        });
        @if ($pertemuan->status_presensi == 1)
            var idPertemuan = "{{ $pertemuan->id }}";
            var storageKey = "endTime_" + idPertemuan;

            var countDownDate = localStorage.getItem(storageKey);

            if (!countDownDate) {
                countDownDate = new Date().getTime() + (1 * 60 * 1000);
                localStorage.setItem(storageKey, countDownDate);
            } else {
                countDownDate = parseInt(countDownDate);
            }

            var waktuDitinggalkan = 0;
            document.addEventListener("visibilitychange", function() {
                if (document.hidden) {
                    waktuDitinggalkan = new Date().getTime();
                } else {
                    if (waktuDitinggalkan > 0) {
                        var lamaDitinggalkan = new Date().getTime() - waktuDitinggalkan;
                        countDownDate += lamaDitinggalkan;
                        localStorage.setItem(storageKey, countDownDate);
                        waktuDitinggalkan = 0;
                    }
                }
            });

            var x = setInterval(function() {
                if (document.hidden) return;

                var now = new Date().getTime();
                var distance = countDownDate - now;

                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("demo").innerHTML = "Sisa Waktu: " + minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "WAKTU HABIS";
                    localStorage.removeItem(storageKey);

                    window.location.href =
                        "{{ route('presensi.ubah_status', ['id_pertemuan' => $pertemuan->id, 'aksi' => 'tutup']) }}";
                }
            }, 1000);
        @else
            var idPertemuan = "{{ $pertemuan->id }}";
            localStorage.removeItem("endTime_" + idPertemuan);
            document.getElementById("demo").innerHTML = "PRESENSI DITUTUP";
        @endif
    </script>

</body>

</html>
