<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi Mahasiswa</title>
    <style>
        @page {
            margin: 40px 25px 50px 25px;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
        }

        .kop-surat {
            position: relative;
            width: 100%;
            text-align: center;
            margin-bottom: 15px;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 20px;
            text-align: center;
            font-size: 8pt;
            font-style: italic;
        }

        .pagenum:before {
            content: counter(page);
        }

        .logo {
            position: absolute;
            left: 10px;
            top: 0px;
            width: 70px;
        }

        .header-text { 
            text-align: center;
        }

        .header-text h1 {
            font-size: 17pt;
            margin: 0;
            font-weight: bold;
        }

        .header-text h2 {
            font-size: 14pt;
            margin: 0;
            font-weight: bold;
        }

        .header-text p {
            font-size: 7pt;
            margin: 2px 0 0 0;
        }

        .garis {
            border-top: 2px solid black;
            margin-top: 15px;
        }

        .title-doc {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .table-info td {
            padding: 3px;
            vertical-align: top;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid black;
            padding: 5px;
        }

        .table-data th {
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .pertemuan-section {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <footer>
        Page <span class="pagenum"></span>
    </footer>

    <main>

        <div class="kop-surat">
            <img src="{{ public_path('asset_web/img/Logo_PNC.png') }}" class="logo" alt="Logo">

            <div class="header-text">
                <h1>JURUSAN KOMPUTER DAN BISNIS</h1>
                <h2>Teknik Informatika</h2>
                <p>Jalan Dr. Soetomo Nomor 1, Karangcengis, Sidakaya,</p>
                <p>Kecamatan Cilacap Selatan, Kabupaten Cilacap, Provinsi Jawa Tengah, 53212.</p>
            </div>
            <div class="garis"></div>
        </div>

        <div class="title-doc">LAPORAN PRESENSI MAHASISWA</div>

        <table class="table-info" width="100%">
            <tr>
                <td width="120">Nama Dosen</td>
                <td width="10">:</td>
                <td>{{ $dosen->nama }}</td>
            </tr>
            <tr>
                <td>Nama Matkul</td>
                <td>:</td>
                <td>{{ $matkul->nama_makul }}</td>
            </tr>
            <tr>
                <td>Nama Kelas</td>
                <td>:</td>
                <td>{{ $kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Tahun Akademik</td>
                <td>:</td>
                <td>
                    @php
                        $semester = $akd->semester == 'GL' ? 'Ganjil' : 'Genap';
                    @endphp
                    {{ $semester }} - {{ $akd->tahun }}
                </td>
            </tr>
        </table>

        <br>

        @forelse($pertemuan as $p)
            <div class="pertemuan-section">
                <div style="font-weight: bold; font-size: 12pt;">
                    Pertemuan {{ $p->pertemuan_ke }} : {{ $p->judul_pertemuan }} ({{ $p->tanggal }})
                </div>

                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">NIM</th>
                            <th width="50%">Nama Mahasiswa</th>
                            <th width="25%">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($p->presensi as $pres)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $pres->nim }}</td>
                                <td class="text-left">{{ $pres->mhs->nama ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($pres->status_kehadiran == 'h')
                                        Hadir
                                    @elseif($pres->status_kehadiran == 'i')
                                        Izin
                                    @elseif($pres->status_kehadiran == 's')
                                        Sakit
                                    @elseif($pres->status_kehadiran == 'a')
                                        Alpha
                                    @elseif($pres->status_kehadiran == 'd')
                                        Dispen
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data mahasiswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @empty
            <div class="text-center" style="margin-top: 20px; font-style: italic;">
                Belum ada data pertemuan untuk kelas ini.
            </div>
        @endforelse

    </main>
</body>

</html>
