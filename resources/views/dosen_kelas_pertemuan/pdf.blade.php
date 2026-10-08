<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt; 
            /* Memberikan ruang untuk header (margin-top) dan footer (margin-bottom) */
            margin-top: 3.5cm; 
            margin-bottom: 2cm;
        }
        
        /* HEADER (Kop Surat) */
        header { 
            position: fixed; 
            top: 0cm; 
            left: 0cm; 
            right: 0cm; 
            height: 3cm; 
            border-bottom: 2px solid black; 
            padding-bottom: 10px;
        }
        header img { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 80px; 
        }
        .header-text { 
            text-align: center; 
        }
        .instansi { font-size: 17pt; font-weight: bold; margin-bottom: 3px; }
        .jurusan { font-size: 14pt; font-weight: bold; margin-bottom: 3px; }
        .alamat { font-size: 8pt; line-height: 1.2; }
        
        /* FOOTER (Nomor Halaman) */
        footer { 
            position: fixed; 
            bottom: 0cm; 
            left: 0cm; 
            right: 0cm; 
            height: 1cm; 
            text-align: center; 
            font-family: Arial, sans-serif; 
            font-size: 8pt; 
            font-style: italic;
        }
        .pagenum:before { content: counter(page); }

        /* KONTEN UTAMA */
        h3 { text-align: center; font-size: 14pt; margin: 0 0 15px 0; font-weight: bold; }
        
        /* Tabel Informasi Kelas */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { padding: 3px; border: none; vertical-align: top;}
        .col-label { width: 140px; }
        .col-titikdua { width: 10px; text-align: center; }

        /* Tabel Data Mahasiswa */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { border: 1px solid black; padding: 6px; text-align: center; }
        .data-table th { font-weight: bold; }
        .text-left { text-align: left !important; }
    </style>
</head>
<body>
    
    <header>
        <!-- Gunakan public_path() agar DomPDF bisa membaca file gambar lokal -->
        <img src="{{ public_path('asset_web/img/Logo_PNC.png') }}" alt="Logo" >
        <div class="header-text">
            <div class="instansi">JURUSAN KOMPUTER DAN BISNIS</div>
            <div class="jurusan">Teknik Informatika</div>
            <div class="alamat">
                Jalan Dr. Soetomo Nomor 1, Karangcengis, Sidakaya,<br>
                Kecamatan Cilacap Selatan, Kabupaten Cilacap, Provinsi Jawa Tengah, 53212.
            </div>
        </div>
    </header>

    <footer>
        Page <span class="pagenum"></span>
    </footer>

    <main>
        <h3>LAPORAN ABSENSI</h3>

        <table class="info-table">
            <tr>
                <td class="col-label">Nama Dosen</td>
                <td class="col-titikdua">:</td>
                <td>{{ $dosen->nama }}</td>
            </tr>
            <tr>
                <td class="col-label">Nama Matkul</td>
                <td class="col-titikdua">:</td>
                <td>{{ $matkul->nama_makul }}</td>
            </tr>
            <tr>
                <td class="col-label">Nama Kelas</td>
                <td class="col-titikdua">:</td>
                <td>{{ $kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td class="col-label">Tahun Akademik</td>
                <td class="col-titikdua">:</td>
                <td>{{ ($akd->semester) == 'GL' ? 'Ganjil' : 'Genap' }} - {{ $akd->tahun }}</td>
            </tr>
            <tr>
                <td class="col-label">Jumlah Pertemuan</td>
                <td class="col-titikdua">:</td>
                <td>{{ $jml_pertemuan }}</td>
            </tr>
            <tr>
                <td class="col-label">Kontrak Persentase</td>
                <td class="col-titikdua">:</td>
                <td>{{ $kelas->bobot_persen}}%</td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">NIM - Nama Mahasiswa</th>
                    <th style="width: 15%;">Jumlah Hadir</th>
                    <th style="width: 17%;">Persentase Hadir</th>
                    <th style="width: 18%;">Nilai Kontrak</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data_mhs as $mhs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $mhs->nim }} - {{ $mhs->nama }}</td>
                    <td>{{ $mhs->jml_hadir }}</td>
                    <td>{{ $mhs->persentase }}%</td>
                    <td>{{ $mhs->nilai_kontrak }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Tidak ada data mahasiswa</td>
                </tr>
                @endempty
            </tbody>
        </table>
    </main>
</body>
</html>