<!DOCTYPE html>
<html>
<head>
    <title>Laporan SSB HBS</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #eee; }
        .summary-list { margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>LAPORAN SSB HBS</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
    <hr>

    <h3>Ringkasan Statistik</h3>
    <ul class="summary-list">
        <li>Total Siswa : {{ $totalSiswa }}</li>
        <li>Total Pelatih : {{ $totalPelatih }}</li>
        <li>Total Jadwal : {{ $totalJadwal }}</li>
        <li>Total Pendapatan : Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</li>
    </ul>

    <h3>Data Pembayaran</h3>
    <table>
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Periode</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->siswa->nama ?? '-' }}</td>
                <td>{{ $item->bulan }}</td>
                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>