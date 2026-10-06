<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Jurusan</title>
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
        <h2>LAPORAN DATA JURUSAN</h2>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Kode Jurusan</th>
                <th width="45%">Nama Jurusan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurusan as $jrs)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $jrs->kode_jurusan }}</td>
                <td class="text-center" align="center">{{ $jrs->nama_jurusan }}</td>
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