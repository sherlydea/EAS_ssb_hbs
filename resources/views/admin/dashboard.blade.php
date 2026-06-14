@extends('admin.layouts.app')

@section('content')

<style>

.dashboard-label{
    color:#7A1025;
    font-size:13px;
    letter-spacing:3px;
    margin-bottom:12px;
    text-transform:uppercase;
    font-weight:700;
}

.dashboard-title{
    font-size:48px;
    font-weight:900;
    margin-bottom:12px;
    color:#1a0b0f;
    line-height:1.2;
}

.dashboard-desc{
    color:#4b3a36;
    max-width:800px;
    line-height:1.8;
    margin-bottom:40px;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:18px;
    margin-bottom:35px;
}

.stat-card{
    background:white;
    border-radius:20px;
    padding:25px;
    border-top:4px solid #D4AF37;
    box-shadow:0 3px 12px rgba(0,0,0,.08);
}

.stat-label{
    font-size:12px;
    text-transform:uppercase;
    color:#777;
    margin-bottom:12px;
    letter-spacing:1px;
}

.stat-value{
    font-size:42px;
    font-weight:700;
    color:#3D000A;
}

.action-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.action-card{
    background:#3D000A;
    color:white;
    border-radius:20px;
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.action-title{
    font-size:32px;
    font-weight:700;
}

.action-desc{
    opacity:.85;
    margin-top:5px;
}

.action-btn{
    background:#D4AF37;
    color:black;
    text-decoration:none;
    padding:12px 24px;
    border-radius:30px;
    font-weight:600;
    transition: 0.2s;
}

.action-btn:hover{
    background:#e6c04a;
}

.table-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    margin-bottom:40px;
}

.table-card{
    background:white;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.table-card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 24px;
    border-bottom:1px solid #efefef;
}

.table-card-header h3{
    font-size:20px;
    font-weight:700;
    color:#18253f;
}

.table-arrow{
    width:46px;
    height:46px;
    border-radius:50%;
    background:#D4AF37;
    color:#000;
    text-decoration:none;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:22px;
    font-weight:700;
    transition:.25s;
}

.table-arrow:hover{
    background:#c59d17;
    transform:scale(1.05);
}

.table-card table{
    width:100%;
    border-collapse:collapse;
}

.table-card th{
    background:#f7f7f7;
    padding:16px 22px;
    text-align:left;
    font-size:14px;
    font-weight:700;
}

.table-card td{
    padding:18px 22px;
    border-top:1px solid #eeeeee;
    font-size:14px;
}

.table-card tbody tr{
    transition: .2s;
}

.table-card tbody tr:hover{
    background:#faf8f3;
}

.badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.pending, .menunggu {
    background:#FFF3CD;
    color:#856404;
}

.approved, .terima, .diterima, .selesai {
    background:#D4EDDA;
    color:#155724;
}

.rejected, .tolak, .ditolak {
    background:#F8D7DA;
    color:#721C24;
}

.chart-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.chart-card{
    background:white;
    border-radius:28px;
    padding:30px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.chart-title{
    font-size:22px;
    font-weight:700;
    color:#18253f;
    margin-bottom:20px;
}

canvas{
    max-height:280px;
}

.chart-canvas{
    height:260px;
    display:flex;
    justify-content:center;
    align-items:center;
}

@media(max-width:1000px){
    .table-grid,
    .chart-grid{
        grid-template-columns:1fr;
    }
}

</style>

<div class="dashboard-label">
    Dashboard Admin
</div>

<div class="dashboard-title">
    Dashboard Admin
</div>

<div class="dashboard-desc">
    Selamat datang kembali Admin. Pantau aktivitas operasional,
    verifikasi data pendaftaran, dan kelola seluruh sistem
    SSB HBS melalui satu pusat kontrol.
</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-label">Total Siswa</div>
        <div class="stat-value">{{ $totalSiswa }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Pelatih</div>
        <div class="stat-value">{{ $totalPelatih }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Turnamen</div>
        <div class="stat-value">{{ $totalTurnamen }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pendaftaran Pending</div>
        <div class="stat-value">{{ $totalPendaftaranPending }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Pembayaran</div>
        <div class="stat-value">{{ $totalPembayaran }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">SPP Menunggu</div>
        <div class="stat-value">{{ $totalSPPMenunggu }}</div>
    </div>

</div>

<div class="action-grid">

    <div class="action-card">
        <div>
            <div class="action-title">
                {{ $totalPendaftaranPending }}
            </div>
            <div class="action-desc">
                Pendaftaran Menunggu Verifikasi
            </div>
        </div>
        <a href="{{ route('admin.pendaftaran') }}" class="action-btn">
            Lihat Pendaftaran
        </a>
    </div>

    <div class="action-card">
        <div>
            <div class="action-title">
                {{ $totalPembayaran }}
            </div>
            <div class="action-desc">
                Data Pembayaran Masuk
            </div>
        </div>
        <a href="{{ route('admin.pembayaran.index') }}" class="action-btn">
            Verifikasi Pembayaran
        </a>
    </div>

</div>

<div class="table-grid">

    <div class="table-card">
        <div class="table-card-header">
            <h3>Pendaftaran Terbaru</h3>
            <a href="{{ route('admin.pendaftaran') }}" class="table-arrow">→</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftaranTerbaru as $item)
                    <tr onclick="window.location='{{ route('admin.pendaftaran.show', $item->id) }}'" style="cursor:pointer;">
                        <td style="font-weight:600;">{{ $item->nama }}</td>
                        <td>{{ $item->kategori_latihan }}</td>
                        <td>
                            <span class="badge {{ strtolower($item->status) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3>Pembayaran Terbaru</h3>
            <a href="{{ route('admin.pembayaran.index') }}" class="table-arrow">→</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Nominal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayaranTerbaru as $item)
                    <tr onclick="window.location='{{ route('admin.pembayaran.show', $item->id) }}'" style="cursor:pointer;">
                        <td style="font-weight:600;">{{ $item->nama }}</td>
                        <td style="font-weight:600; color:#7A1025;">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ strtolower($item->status) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<div class="chart-grid">

    <div class="chart-card">
        <div class="chart-title">
            Siswa per Kategori
        </div>
        <div class="chart-canvas">
            <canvas id="kategoriChart"></canvas>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">
            Status Pendaftaran
        </div>
        <div class="chart-canvas">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const kategoriLabels = [
    @foreach($siswaPerKategori as $item)
        "{{ $item->kategori_latihan }}",
    @endforeach
];

const kategoriData = [
    @foreach($siswaPerKategori as $item)
        {{ $item->total }},
    @endforeach
];

new Chart(document.getElementById('kategoriChart'), {
    type: 'bar',
    data: {
        labels: kategoriLabels,
        datasets: [{
            label: 'Jumlah Siswa',
            data: kategoriData,
            backgroundColor: [
                '#7A1025',
                '#A01237',
                '#C41E3A',
                '#8B1538',
                '#6B0F1F'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

const statusLabels = [
    @foreach($statusPendaftaran as $item)
        "{{ ucfirst($item->status) }}",
    @endforeach
];

const statusData = [
    @foreach($statusPendaftaran as $item)
        {{ $item->total }},
    @endforeach
];

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusData,
            backgroundColor: [
                '#D4AF37',
                '#7A1025',
                '#4B708B'
            ]
        }]
    },
    options: {
        responsive: true
    }
});

</script>

@endsection