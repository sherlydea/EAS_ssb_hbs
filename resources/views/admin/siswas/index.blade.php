@extends('admin.layouts.app')

@section('content')

<style>
/* Smooth scrolling global untuk halaman ini */
html {
    scroll-behavior: smooth;
}

/* ===============================
   Header Halaman
=============================== */
.page-label {
    color:#D4AF37;
    font-size:13px;
    letter-spacing:3px;
    text-transform:uppercase;
    margin-bottom:12px;
}
.page-title {
    font-size:42px;
    font-weight:700;
    color:#1A2238;
    margin-bottom:10px;
}
.page-desc {
    color:#555;
    max-width:750px;
    line-height:1.8;
    margin-bottom:35px;
}

/* ===============================
   Banner Statistik
=============================== */
.verify-banner {
    background:#3D000A;
    color:white;
    border-radius:24px;
    padding:28px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}
.verify-count {
    font-size:34px;
    font-weight:700;
}
.verify-desc {
    margin-top:5px;
    opacity:.9;
}
.verify-btn {
    background:#D4AF37;
    color:black;
    text-decoration:none;
    padding:14px 28px;
    border-radius:999px;
    font-weight:600;
    transition: 0.2s;
}
.verify-btn:hover {
    background:#e6c04a;
}

/* ===============================
   Statistik Kartu
=============================== */
.stats-grid {
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:20px;
    margin-bottom:40px;
}
.stat-card {
    background:white;
    border-radius:20px;
    padding:24px;
    box-shadow:0 4px 10px rgba(0,0,0,.05);
    border-top: 4px solid #D4AF37;
}
.stat-title {
    font-size:13px;
    text-transform:uppercase;
    color:#888;
    margin-bottom:10px;
}
.stat-value {
    font-size:42px;
    font-weight:700;
    color: #3D000A;
}

/* ===============================
   Filter & Tabs
=============================== */
.filter-card {
    background:white;
    border-radius:24px;
    padding:25px;
    margin-bottom:30px;
}
.search-form {
    display:flex;
    gap:16px;
    margin-bottom:12px;
}
.search-box {
    flex:1;
    height:56px;
    border:1px solid #ddd;
    border-radius:999px;
    padding:0 20px;
    font-size:15px;
}
.status-tabs {
    display:flex;
    gap:30px;
}
.status-tabs a {
    text-decoration:none;
    color:#666;
    font-weight:500;
    padding-bottom:10px;
    border-bottom:2px solid transparent;
    transition: 0.2s;
}
.status-tabs a.active {
    color:#111827;
    font-weight:700;
    border-bottom:2px solid #7A1025;
}

/* ===============================
   Tabel Data
=============================== */
.table-card {
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 4px 10px rgba(0,0,0,.05);
}
.table-card table {
    width:100%;
    border-collapse:collapse;
}
.table-card th {
    background:#F8F5EE;
    padding:18px;
    text-align:left;
    font-size:14px;
    font-weight: 700;
}
.table-card td {
    padding:18px;
    border-top:1px solid #eee;
}
.detail-btn {
    border:none;
    background:#7A1025;
    color:white;
    padding:8px 16px;
    border-radius:10px;
    cursor:pointer;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
}
.detail-btn:hover {
    background: #5e0d1d;
}
.kategori-badge{
    background:#F5EFE7;
    color:#650018;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}
/* ===============================
   Table Summary & Pagination
=============================== */
.table-summary {
    text-align:center;
    margin-bottom:12px;
    color:#4B5563;
    font-size:14px;
}
.pagination-container {
    display:flex;
    justify-content:center;
    align-items:center;
    gap:12px;
    margin-bottom:24px;
}
.pagination {
    display:flex;
    align-items:center;
    gap:8px;
}
.pagination a, .pagination span {
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition: 0.2s;
}
.pagination a { color:#1A2238; background:transparent; }
.pagination a:hover { background:#F5EFE7; }
.pagination .active { background:#650018; color:white; font-weight:700; }
.pagination .arrow { font-size:20px; color:#650018; font-weight:700; }

/* ===============================
   Grafik
=============================== */
.chart-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
    margin-top:40px;
    scroll-margin-top: 100px; /* Jarak aman agar header tidak tertutup topbar navbar */
}
.chart-card {
    background:white;
    border-radius:24px;
    padding:30px;
    height:420px;
    box-shadow:0 4px 10px rgba(0,0,0,.05);
}
.chart-card canvas {
    width:100% !important;
    height:320px !important;
}
.chart-title {
    font-size:22px;
    font-weight:700;
    color:#1A2238;
    margin-bottom:20px;
}

/* Responsive Grid */
@media(max-width:1100px) { .stats-grid { grid-template-columns:repeat(3,1fr); } }
@media(max-width:700px) {
    .verify-banner { flex-direction:column; align-items:flex-start; gap:20px; }
    .stats-grid { grid-template-columns:1fr; }
    .chart-grid { grid-template-columns:1fr; }
}
</style>

<div class="page-label">Data Siswa</div>
<h1 class="page-title">Manajemen Data Siswa</h1>
<p class="page-desc">Kelola seluruh data siswa aktif SSB HBS yang telah terverifikasi dan terdaftar.</p>

{{-- Banner Statistik --}}
<div class="verify-banner">
    <div>
        <div class="verify-count">{{ $totalSiswa }} Siswa Aktif Terdaftar</div>
        <div class="verify-desc">Kelola data siswa aktif yang sudah lolos verifikasi resmi.</div>
    </div>
    <a href="#grafik-siswa" class="verify-btn">Lihat Statistik</a>
</div>

{{-- Kartu Statistik --}}
<div class="stats-grid">
    <div class="stat-card"><div class="stat-title">TOTAL SISWA</div><div class="stat-value">{{ $totalSiswa }}</div></div>
    <div class="stat-card"><div class="stat-title">SISWA U-10</div><div class="stat-value">{{ $totalU10 }}</div></div>
    <div class="stat-card"><div class="stat-title">SISWA U-13</div><div class="stat-value">{{ $totalU13 }}</div></div>
    <div class="stat-card"><div class="stat-title">SISWA U-15</div><div class="stat-value">{{ $totalU15 }}</div></div>
    <div class="stat-card"><div class="stat-title">SISWA U-18</div><div class="stat-value">{{ $totalU18 }}</div></div>
</div>

{{-- Filter Data --}}
<div class="filter-card">
    <form class="search-form" method="GET" action="{{ route('admin.siswas.index') }}">
        <input type="hidden" name="kategori" value="{{ request('kategori', 'semua') }}">
        <input type="text" name="search" class="search-box" placeholder="Cari nama siswa atau nomor HP..." value="{{ request('search') }}">
    </form>
    <div class="status-tabs">
        @php $categories = ['semua','U-10','U-13','U-15','U-18']; @endphp
        @foreach($categories as $cat)
            <a href="{{ route('admin.siswas.index', ['kategori'=>$cat, 'search'=>request('search')]) }}"
               class="{{ request('kategori','semua') == $cat ? 'active' : '' }}">{{ strtoupper($cat) }}</a>
        @endforeach
    </div>
</div>

{{-- Tabel Data --}}
<div class="table-card">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th><th>Nama Siswa</th><th>Kategori</th><th>Nomor HP</th><th>Tanggal Bergabung</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $item)
                    <tr>
                        <td>{{ $siswas->firstItem() + $loop->index }}</td>
                        <td style="font-weight: 600;">{{ $item->nama }}</td>
                        <td><span class="kategori-badge">{{ $item->kategori_latihan }}</span></td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.siswas.show',$item->id) }}" class="detail-btn">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align: center; padding: 40px; color: #888; font-weight: 500;">Tidak ada data siswa yang cocok dengan kriteria pencarian.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Summary & Pagination --}}
        <div style="padding:20px 24px 28px;">
            @if($siswas->count() > 0)
                <p class="table-summary">Menampilkan {{ $siswas->firstItem() }} - {{ $siswas->lastItem() }} dari {{ $siswas->total() }} siswa (Hasil Filter)</p>
            @endif
            <div class="pagination-container">
                @if ($siswas->lastPage() > 1)
                    <div class="pagination">
                        @if ($siswas->onFirstPage())
                            <span class="arrow">&#8249;</span>
                        @else
                            <a class="arrow" href="{{ $siswas->appends(['kategori'=>request('kategori'),'search'=>request('search')])->previousPageUrl() }}">&#8249;</a>
                        @endif
                        @for ($i=1; $i<=$siswas->lastPage(); $i++)
                            @if ($i == $siswas->currentPage())
                                <span class="active">{{ $i }}</span>
                            @else
                                <a href="{{ $siswas->appends(['kategori'=>request('kategori'),'search'=>request('search')])->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor
                        @if ($siswas->hasMorePages())
                            <a class="arrow" href="{{ $siswas->appends(['kategori'=>request('kategori'),'search'=>request('search')])->nextPageUrl() }}">&#8250;</a>
                        @else
                            <span class="arrow">&#8250;</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Grafik --}}
<div class="chart-grid" id="grafik-siswa">
    <div class="chart-card">
        <h3 class="chart-title">Distribusi Siswa per Kategori</h3>
        <canvas id="chartKategori"></canvas>
    </div>
    <div class="chart-card">
        <h3 class="chart-title">Pertumbuhan Jumlah Siswa</h3>
        <canvas id="chartPertumbuhan"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Chart Distribusi
    new Chart(document.getElementById('chartKategori'), {
        type: 'bar',
        data: {
            labels: ['U-10','U-13','U-15','U-18'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [{{ $totalU10 }},{{ $totalU13 }},{{ $totalU15 }},{{ $totalU18 }}],
                backgroundColor: ['#650018','#8B1E3F','#D4AF37','#B08D2F'],
                borderRadius: 8
            }]
        },
        options: {
            responsive:true,
            maintainAspectRatio: false,
            plugins:{ legend:{display:false} },
            scales:{ y:{ beginAtZero:true } }
        }
    });

    // Chart Pertumbuhan
    new Chart(document.getElementById('chartPertumbuhan'), {
        type: 'line',
        data: {
            labels: @json($labelsPertumbuhan),
            datasets: [{
                label: 'Total Siswa',
                data: @json($dataPertumbuhan),
                borderColor: '#650018',
                backgroundColor: 'rgba(101,0,24,0.08)',
                borderWidth: 3,
                pointBackgroundColor: '#D4AF37',
                pointBorderColor: '#650018',
                pointRadius: 5,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins:{ legend:{ display:true, position:'top' } },
            scales:{ y:{ beginAtZero:true } }
        }
    });

});
</script>

@endsection