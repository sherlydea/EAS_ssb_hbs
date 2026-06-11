@extends('admin.layouts.app')

@section('content')

<style>
/* 1. LAYOUT & TYPOGRAPHY */
.page-label { color: #D4AF37; font-size: 13px; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 10px; }
.page-title { font-size: 42px; font-weight: 700; color: #1A2238; margin-bottom: 10px; }
.page-desc { color: #666; margin-bottom: 35px; }

/* 2. STATISTIK CARDS */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 35px; }
.stat-card { background: white; border-radius: 22px; padding: 18px 22px; box-shadow: 0 4px 12px rgba(0,0,0,.05); border-top: 4px solid #D4AF37; }
.stat-title { color: #888; font-size: 12px; text-transform: uppercase; margin-bottom: 10px; font-weight: 600; }
.stat-value { font-size: 28px; font-weight: 700; color: #1A2238; }

/* 3. EXPORT ACTIONS */
.report-actions { display: flex; gap: 12px; margin-bottom: 30px; }
.export-btn { padding: 12px 22px; border-radius: 12px; text-decoration: none; font-weight: 700; color: white; transition: 0.2s; }
.export-btn.pdf { background: #C62828; }
.export-btn.pdf:hover { background: #a81313; }
.export-btn.excel { background: #2E7D32; }
.export-btn.excel:hover { background: #1B5E20; }

/* 4. CHARTS */
.chart-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px; }
.chart-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,.05); }
.chart-title { font-size: 20px; font-weight: 700; color: #1A2238; margin-bottom: 25px; }
.chart-container { position: relative; width: 100%; height: 220px; max-width: 320px; margin: auto; }

/* 5. TABLE & BADGE */
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
table th { background: #F8F5EE; padding: 12px; text-align: left; font-size: 13px; color: #1A2238; }
table td { padding: 12px; border-top: 1px solid #eee; font-size: 14px; color: #333; }

.badge { padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-block; }
.badge-belum { background: #EEE8E1; color: #444; }
.badge-menunggu { background: #F8E7A3; color: #7A5A00; }
.badge-lunas { background: #D4EDDA; color: #155724; }
.badge-ditolak { background: #F8D7DA; color: #721C24; }

@media(max-width: 1024px) { .chart-grid { grid-template-columns: 1fr; } }
</style>

<div class="page-label">LAPORAN & STATISTIK</div>
<h1 class="page-title">Pusat Analisis Data & Keuangan</h1>
<p class="page-desc">Rekapitulasi pertumbuhan siswa, persebaran lisensi pelatih, dan grafik akumulasi pendapatan kas SSB HBS.</p>

<div class="report-actions">
    <a href="{{ route('admin.report.pdf') }}" class="export-btn pdf">Export PDF</a>
    <a href="{{ route('admin.report.excel') }}" class="export-btn excel">Export Excel</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Siswa Aktif</div>
        <div class="stat-value">{{ $totalSiswa }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Staff Pelatih</div>
        <div class="stat-value">{{ $totalPelatih }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Alokasi Jadwal</div>
        <div class="stat-value">{{ $totalJadwal }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Pendapatan (Lunas)</div>
        <div class="stat-value" style="color: #2E7D32;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Tagihan</div>
        <div class="stat-value">{{ $totalTagihan }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Lunas</div>
        <div class="stat-value" style="color:#2E7D32">{{ $totalLunas }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Belum Bayar</div>
        <div class="stat-value" style="color:#D32F2F">{{ $totalBelumBayar }}</div>
    </div>
</div>

<div class="chart-grid">
    <div class="chart-card">
        <h3 class="chart-title">Status Pembayaran SPP</h3>
        <div class="chart-container">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <h3 class="chart-title">Komposisi Siswa per Kategori</h3>
        <div class="chart-container">
            <canvas id="kategoriChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card mb-10">
    <h3 class="chart-title">Pembayaran Terbaru</h3>
    <table>
        <thead>
            <tr><th>Siswa</th><th>Periode</th><th>Nominal</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($pembayaranTerbaru as $item)
            <tr>
                <td>{{ $item->siswa->nama ?? 'N/A' }}</td>
                <td>{{ $item->bulan }} {{ $item->tahun }}</td>
                <td>Rp {{ number_format($item->nominal,0,',','.') }}</td>
                <td>
                    @if($item->status == 'Lunas')
                        <span class="badge badge-lunas">Lunas</span>
                    @elseif($item->status == 'Belum Bayar')
                        <span class="badge badge-belum">Belum Bayar</span>
                    @elseif($item->status == 'Menunggu Verifikasi')
                        <span class="badge badge-menunggu">Menunggu Verifikasi</span>
                    @else
                        <span class="badge badge-ditolak">Ditolak</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Belum Bayar', 'Menunggu', 'Lunas', 'Ditolak'],
            datasets: [{
                data: @json($statusPembayaran),
                backgroundColor: ['#BDBDBD', '#D4AF37', '#2E7D32', '#C62828']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('kategoriChart'), {
        type: 'pie',
        data: {
            labels: [@foreach($chartKategori as $item) '{{ $item->kategori_latihan }}', @endforeach],
            datasets: [{
                data: [@foreach($chartKategori as $item) {{ $item->total }}, @endforeach],
                backgroundColor: ['#650018', '#D4AF37', '#1A2238', '#8B1E3F']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>

@endsection