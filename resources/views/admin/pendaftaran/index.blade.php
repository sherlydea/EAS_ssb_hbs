@extends('admin.layouts.app')

@section('content')

<style>
.page-label{
    color:#D4AF37;
    font-size:13px;
    letter-spacing:3px;
    text-transform:uppercase;
    margin-bottom:12px;
}

.page-title{
    font-size:42px;
    font-weight:700;
    color:#1A2238;
    margin-bottom:10px;
}

.page-desc{
    color:#555;
    max-width:750px;
    line-height:1.8;
    margin-bottom:35px;
}

.verify-banner{
    background:#3D000A;
    color:white;
    border-radius:24px;
    padding:28px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.verify-count{
    font-size:34px;
    font-weight:700;
}

.verify-desc{
    margin-top:5px;
    opacity:.9;
}

.verify-btn{
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

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:40px;
}

.stat-card{
    background:white;
    border-radius:20px;
    padding:24px;
    box-shadow:0 4px 10px rgba(0,0,0,.05);
}

.stat-title{
    font-size:13px;
    text-transform:uppercase;
    color:#888;
    margin-bottom:10px;
}

.stat-value{
    font-size:42px;
    font-weight:700;
}

.total{ border-top:4px solid #D4AF37; }
.pending{ border-top:4px solid #D4AF37; }
.approved{ border-top:4px solid #2DBE60; }
.rejected{ border-top:4px solid #D93025; }

.filter-card{
    background:white;
    border-radius:24px;
    padding:25px;
    margin-bottom:30px;
}

.search-form{
    display:flex;
    gap:16px;
    margin-bottom:20px;
}

.search-box{
    flex:1;
    height:56px;
    border:1px solid #ddd;
    border-radius:999px;
    padding:0 20px;
    font-size:15px;
}

.search-button{
    height:56px;
    padding:0 28px;
    border:none;
    border-radius:999px;
    background:#7A1025;
    color:white;
    font-weight:700;
    cursor:pointer;
    transition: 0.2s;
}

.search-button:hover{
    background:#5e0d1d;
}

.status-tabs{
    display:flex;
    gap:30px;
}

.table-card{
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 4px 10px rgba(0,0,0,.05);
}

.table-card table{
    width:100%;
    border-collapse:collapse;
}

.table-card th{
    background:#F8F5EE;
    padding:18px;
    text-align:left;
    font-size:14px;
    font-weight: 700;
}

.table-card td{
    padding:18px;
    border-top:1px solid #eee;
}

.status-badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display: inline-block;
}

.status-pending{ background:#FFF3CD; color:#856404; }
.status-diterima{ background:#D4EDDA; color:#155724; }
.status-ditolak{ background:#F8D7DA; color:#721C24; }

.detail-btn{
    border:none;
    background:#7A1025;
    color:white;
    padding:8px 16px;
    border-radius:10px;
    cursor:pointer;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: 0.2s;
}

.detail-btn:hover {
    background:#5e0d1d;
}

.table-summary{
    text-align:center;
    color:#4B5563;
    font-size:14px;
    margin-bottom:18px;
}

.status-tabs a{
    text-decoration:none;
    color:#666;
    font-weight:500;
    padding-bottom:10px;
    border-bottom:2px solid transparent;
    transition: 0.2s;
}

.status-tabs a.active{
    color:#111827;
    font-weight:700;
    border-bottom:2px solid #7A1025;
}

/* PAGINATION CUSTOM */
.pagination-container{
    display:flex;
    justify-content:center;
    align-items:center;
    margin-top:16px;
}

.pagination{
    display:flex;
    align-items:center;
    gap:10px;
    padding:0;
}

.pagination a,
.pagination span{
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition:.2s;
}

.pagination a{
    color:#1A2238;
    background:transparent;
}
.pagination a:hover{
    background:#F5EFE7;
}

.pagination .active{
    background:#650018;
    color:white;
    font-weight:700;
}

.pagination .arrow{
    font-size:26px;
    color:#650018;
    font-weight:700;
    line-height:1;
}

.pagination span:not(.active){
    background:transparent;
}

/* Memperhalus efek scroll saat melompat ke Anchor Link */
html {
    scroll-behavior: smooth;
}

@media(max-width:1100px) {
    .stats-grid {
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:700px) {
    .verify-banner {
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }

    .stats-grid {
        grid-template-columns:1fr;
    }
}
</style>

<div class="page-label">Pendaftaran Siswa</div>

<h1 class="page-title">Manajemen Pendaftaran Siswa</h1>

<p class="page-desc">Kelola dan verifikasi seluruh pendaftaran siswa baru SSB HBS secara terpusat dan efisien.</p>

{{-- BANNER VERIFIKASI --}}
<div class="verify-banner">
    <div>
        <div class="verify-count">{{ $totalPending }} Pendaftaran Menunggu Verifikasi</div>
        <div class="verify-desc">Segera periksa berkas pendaftaran untuk mempercepat proses penerimaan siswa baru.</div>
    </div>

    <a href="{{ route('admin.pendaftaran', ['status' => 'pending']) }}#area-tabel" class="verify-btn">
        Verifikasi Sekarang
    </a>
</div>

{{-- KARTU STATISTIK PENDAFTARAN --}}
<div class="stats-grid">
    <div class="stat-card total">
        <div class="stat-title">Total Pendaftaran</div>
        <div class="stat-value">{{ $totalPendaftaran }}</div>
    </div>

    <div class="stat-card pending">
        <div class="stat-title">Pending</div>
        <div class="stat-value">{{ $totalPending }}</div>
    </div>

    <div class="stat-card approved">
        <div class="stat-title">Diterima</div>
        <div class="stat-value">{{ $totalDiterima }}</div>
    </div>

    <div class="stat-card rejected">
        <div class="stat-title">Ditolak</div>
        <div class="stat-value">{{ $totalDitolak }}</div>
    </div>
</div>

{{-- FILTER DAN PENCARIAN DATA --}}
<div class="filter-card" id="area-tabel" style="scroll-margin-top: 100px;">
    <form class="search-form" method="GET" action="{{ route('admin.pendaftaran') }}#area-tabel">
        <input type="text" name="search" class="search-box" placeholder="Cari nama atau email..." value="{{ request('search') }}">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <button type="submit" class="search-button">Cari</button>
    </form>

    <div class="status-tabs">
        <a href="{{ route('admin.pendaftaran', ['status' => 'semua', 'search' => request('search')]) }}#area-tabel"
           class="{{ request('status') == null || request('status') == 'semua' ? 'active' : '' }}">
            Semua
        </a>

        <a href="{{ route('admin.pendaftaran', ['status' => 'pending', 'search' => request('search')]) }}#area-tabel"
           class="{{ request('status') == 'pending' ? 'active' : '' }}">
            Pending
        </a>

        <a href="{{ route('admin.pendaftaran', ['status' => 'diterima', 'search' => request('search')]) }}#area-tabel"
           class="{{ request('status') == 'diterima' ? 'active' : '' }}">
            Diterima
        </a>

        <a href="{{ route('admin.pendaftaran', ['status' => 'ditolak', 'search' => request('search')]) }}#area-tabel"
           class="{{ request('status') == 'ditolak' ? 'active' : '' }}">
            Ditolak
        </a>
    </div>
</div>

{{-- TABEL DATA PENDAFTARAN SISWA --}}
<div class="table-card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Kategori</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $item)
                    <tr>
                        <td>{{ $pendaftarans->firstItem() + $loop->index }}</td>
                        <td style="font-weight: 600;">{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->kategori_latihan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($item->status) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.pendaftaran.show', $item->id) }}" class="detail-btn">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 30px;">Tidak ada data pendaftaran yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding:20px 24px 28px; text-align:center;">
        @if($pendaftarans->count() > 0)
            <p class="table-summary">
                Menampilkan {{ $pendaftarans->firstItem() }}
                - {{ $pendaftarans->lastItem() }}
                dari {{ $pendaftarans->total() }} pendaftaran
            </p>
        @endif

        {{-- Pagination Custom --}}
        <div class="pagination-container">
            @if ($pendaftarans->lastPage() > 1)
                <div class="pagination">
                    {{-- Previous --}}
                    @if ($pendaftarans->onFirstPage())
                        <span class="arrow">&#8249;</span>
                    @else
                        <a class="arrow" href="{{ $pendaftarans->previousPageUrl() }}#area-tabel">&#8249;</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $pendaftarans->lastPage(); $i++)
                        @if ($i == $pendaftarans->currentPage())
                            <span class="active">{{ $i }}</span>
                        @else
                            <a href="{{ $pendaftarans->url($i) }}#area-tabel">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if ($pendaftarans->hasMorePages())
                        <a class="arrow" href="{{ $pendaftarans->nextPageUrl() }}#area-tabel">&#8250;</a>
                    @else
                        <span class="arrow">&#8250;</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection