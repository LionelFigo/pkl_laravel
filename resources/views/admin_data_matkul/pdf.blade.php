<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #e4e4e4;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN DATA MATA KULIAH</h2>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Matkul</th>
                <th>Nama Matkul</th>
                <th width="10%">Jumlah SKS</th>
                <th width="10%">Jumlah CPMK</th>
            </tr>
        </thead>
        <tbody>
            @forelse($matkul as $m)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $m->kode_makul}}</td>
                <td>{{ $m->nama_makul }}</td>
                <td class="text-center">{{ $m->jml_sks }}</td>
                <td class="text-center">{{ $m->jml_cpmk }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Data mahasiswa tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>