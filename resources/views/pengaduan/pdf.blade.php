<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan #{{ $pengaduan->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        .section-title {
            background-color: #f0f0f0;
            padding: 5px 10px;
            font-weight: bold;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 5px;
        }
        .info-table td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .info-table td:nth-child(2) {
            width: 10px;
            text-align: center;
        }
        .foto {
            max-width: 300px;
            max-height: 200px;
            display: block;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            color: #fff;
            font-size: 12px;
            display: inline-block;
        }
        .bg-pending { background-color: #f56565; }
        .bg-diproses { background-color: #ecc94b; color: #000; }
        .bg-selesai { background-color: #48bb78; }
        .progres-item {
            border: 1px solid #e2e8f0;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DETAIL LAPORAN PENGADUAN</h2>
        <p>Tanggal Cetak: {{ date('d M Y H:i') }}</p>
    </div>

    <div class="section-title">1. Informasi Pelapor & Keluhan</div>
    <table class="info-table">
        <tr>
            <td>ID Laporan</td>
            <td>:</td>
            <td>#{{ $pengaduan->id }}</td>
        </tr>
        <tr>
            <td>Pelapor</td>
            <td>:</td>
            <td>{{ $pengaduan->user->name ?? 'Tidak diketahui' }}</td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $pengaduan->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>:</td>
            <td>{{ ucwords(str_replace('_', ' ', $pengaduan->lokasi)) }}</td>
        </tr>
        <tr>
            <td>Alamat Detail</td>
            <td>:</td>
            <td>{{ $pengaduan->alamat }}</td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>:</td>
            <td>{{ strtoupper($pengaduan->kategori) }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $pengaduan->isi_laporan }}</td>
        </tr>
        <tr>
            <td>Status Terkini</td>
            <td>:</td>
            <td>
                @php
                    $statusClass = 'bg-pending';
                    if($pengaduan->status == 'diproses') $statusClass = 'bg-diproses';
                    if($pengaduan->status == 'selesai') $statusClass = 'bg-selesai';
                @endphp
                <span class="badge {{ $statusClass }}">{{ strtoupper($pengaduan->status) }}</span>
            </td>
        </tr>
        <tr>
            <td>Foto Laporan</td>
            <td>:</td>
            <td>
                @if($pengaduan->foto_pengaduan)
                    <?php
                        // Untuk dompdf, lebih baik gunakan base64 image agar tidak terkendala path
                        $path = storage_path('app/public/' . $pengaduan->foto_pengaduan);
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        if (file_exists($path)) {
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            echo '<img src="'.$base64.'" class="foto">';
                        } else {
                            echo '<span style="color:red">File gambar tidak ditemukan</span>';
                        }
                    ?>
                @else
                    Tidak ada foto
                @endif
            </td>
        </tr>
    </table>

    @if($pengaduan->penugasan && count($pengaduan->penugasan->progres) > 0)
    <div style="page-break-before: always;"></div>
    @endif

    <div class="section-title">2. Detail Penanganan & Progres</div>
    @if($pengaduan->penugasan)
        <table class="info-table">
            <tr>
                <td>Petugas Lapangan</td>
                <td>:</td>
                <td>{{ $pengaduan->penugasan->petugas->name ?? 'Tidak ada nama petugas' }}</td>
            </tr>
            <tr>
                <td>Status Penugasan</td>
                <td>:</td>
                <td>{{ strtoupper($pengaduan->penugasan->status_penugasan) }}</td>
            </tr>
        </table>

        @if(count($pengaduan->penugasan->progres) > 0)
            <h4>Histori Pekerjaan:</h4>
            @foreach($pengaduan->penugasan->progres as $index => $progres)
                <div class="progres-item">
                    <strong>Pembaruan #{{ $index + 1 }}</strong><br>
                    <p>{{ $progres->keterangan_progres }}</p>
                    
                    @if($progres->foto_bukti)
                        <?php
                            // Cek jika foto_bukti adalah url cloudinary atau path lokal
                            $foto_bukti = $progres->foto_bukti;
                            if (str_starts_with($foto_bukti, 'http')) {
                                echo '<img src="'.$foto_bukti.'" class="foto">';
                            } else {
                                $path = storage_path('app/public/' . $foto_bukti);
                                if (file_exists($path)) {
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    echo '<img src="'.$base64.'" class="foto">';
                                } else {
                                    echo '<span style="color:red">File bukti pengerjaan tidak dapat dimuat</span>';
                                }
                            }
                        ?>
                    @endif
                </div>
            @endforeach
        @else
            <p><i>Belum ada progress pengerjaan yang dilaporkan oleh petugas.</i></p>
        @endif
    @else
        <p><i>Laporan ini belum ditugaskan ke petugas manapun.</i></p>
    @endif

</body>
</html>
