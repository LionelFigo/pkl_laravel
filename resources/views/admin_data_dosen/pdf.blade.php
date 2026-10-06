<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Dosen</title>
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
        <h2>LAPORAN DATA DOSEN</h2>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>NIK</th>
                <th width="50%">Nama Mahasiswa</th>
                <th>Kontak</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dosen as $dsn)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $dsn->nik }}</td>
                <td>{{ $dsn->nama }}</td>
                <td>{{ $dsn->kontak }}</td>
                <td>{{ $dsn->email }}</td>
                <td>{{ ($dsn->kelamin) == 'l' ? 'Laki-Laki' : 'Perempuan' }}</td> 
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Data dosen tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>