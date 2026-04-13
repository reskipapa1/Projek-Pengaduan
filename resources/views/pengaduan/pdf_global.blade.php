<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Semua Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">LAPORAN REKAPITULASI PENGADUAN</h2>
    <p style="text-align: center;">Tanggal Cetak: {{ date('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelapor</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Waktu Pengaduan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->user->name ?? 'Anonim' }}</td>
                <td>{{ strtoupper($item->kategori) }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $item->lokasi)) }}</td>
                <td>{{ strtoupper($item->status) }}</td>
                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
