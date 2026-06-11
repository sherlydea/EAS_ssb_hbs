@extends('admin.layouts.app')

@section('content')

<style>
/* ==========================================================================
   GAYA VISUAL KONSISTEN SSB HBS (STANDARISASI MULTI-MODUL)
   ========================================================================== */

.page-label{
    color:#D4AF37;
    font-size:13px;
    letter-spacing:4px;
    text-transform:uppercase;
    margin-bottom:10px;
}

.page-title{
    font-size:56px;
    font-weight:700;
    color:#1A2238;
    margin-bottom:10px;
    line-height:1.1;
}

.page-desc{
    color:#666;
    margin-bottom:35px;
}

.alert-box{
    background:#650018;
    color:white;
    border-radius:28px;
    padding:28px 32px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.alert-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:6px;
}

.alert-desc{
    opacity:.85;
}

.alert-btn{
    background:#D4AF37;
    color:#1A2238;
    text-decoration:none;
    padding:16px 30px;
    border-radius:999px;
    font-weight:700;
    transition: 0.2s;
}
.alert-btn:hover {
    background: #b5922e;
}

/* Responsive Grid untuk Statistik */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
    margin-bottom: 35px;
}

.stat-card{
    background:white;
    border-radius:22px;
    padding:24px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    border-top:4px solid #D4AF37;
}

.stat-title{
    color:#888;
    font-size:12px;
    text-transform:uppercase;
    margin-bottom:12px;
}

.stat-value{
    font-size:40px;
    font-weight:700;
    color:#1A2238;
}

.stat-desc{
    font-size:12px;
    color:#999;
    margin-top:8px;
}

.table-card{
    background:white;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    margin-bottom:35px;
}

.filter-area{
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
}

.search-box{
    width:350px; /* Diperkecil sedikit agar porsi tombol filter lebih luas */
}

.search-box input{
    width:100%;
    border:none;
    background:#F5F1E8;
    border-radius:999px;
    padding:12px 18px;
    outline:none;
    font-size: 14px;
}

/* PERBAIKAN UTAMA: Menu Tab Filter Dibuat Ramping & Sebaris */
.filter-menu{
    display:flex;
    gap:8px;
    flex-wrap:nowrap; /* Mengunci agar tidak pecah jadi 2 baris */
    align-items: center;
}

.filter-menu a{
    text-decoration:none;
    padding: 8px 16px;       /* Padding dikecilkan agar proporsional */
    border-radius:999px;
    color:#444;
    background:#F5F1E8;
    font-size: 13px;         /* Ukuran font disamakan dengan standar tombol aksi */
    font-weight:700;         /* Ketebalan font disamakan */
    text-align:center;
    transition: 0.2s;
    white-space: nowrap;     /* Mencegah teks melar ke bawah */
}

.filter-menu .active{
    background:#650018;
    color:white;
}

.filter-menu a:hover:not(.active) {
    background: #e2dbcf;
}

/* Aturan Konstruksi Tabel Proporsional Rapat */
table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#F5F1E8;
}

table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 13px;
    font-weight: 700;
    color:#1A2238;
}

table td {
    padding: 12px 16px;
    border-top:1px solid #eee;
    font-size:14px;
    color:#333;
}

tbody tr{
    transition:.2s;
}

tbody tr:hover{
    background:#fafafa;
}

/* Standarisasi Komponen Badges */
.badge-status, .badge, .kategori-badge {
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 999px;
    display: inline-block;
}

.badge-belum{ background:#F8D7DA; color:#721C24; }
.badge-menunggu{ background:#FFF3CD; color:#856404; }
.badge-lunas{ background:#D4EDDA; color:#155724; }
.badge-ditolak{ background:#F8D7DA; color:#721C24; }

/* Standarisasi Kelompok Tombol Aksi */
.action-buttons {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    align-items: center;
}

.verify-btn, .detail-btn {
    border: none;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 700;
    border-radius: 10px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    box-sizing: border-box;
}

.verify-btn {
    background: #2E7D32;
    color: white;
}
.verify-btn:hover { 
    background: #1B5E20; 
    color: white; 
}

.detail-btn {
    background: #F5EFE7;
    border: 1px solid rgba(122, 16, 37, 0.15);
    color: #1A2238;
}
.detail-btn:hover { 
    background: #e2dbcf; 
}

.table-info{
    padding:0 25px 15px;
    color:#777;
    font-size:13px;
    font-weight: 500;
}

.empty-state{
    text-align:center;
    padding:50px 20px;
    color:#888;
}

.empty-state h4{
    margin-top:15px;
    margin-bottom:10px;
    color:#444;
}

/* Responsive Handling */
@media(max-width:1200px){
    .stats-grid{ grid-template-columns:repeat(2,1fr); }
    .filter-area{ flex-direction:column; align-items:stretch; }
    .search-box{ width:100%; }
    .filter-menu{ flex-wrap: wrap; justify-content: start; }
}

@media(max-width:768px) {
    .stats-grid { grid-template-columns: 1fr; }
    .action-buttons { flex-direction: column; gap: 4px; }
}
</style>

<div class="page-label">PEMBAYARAN SPP</div>

<h1 class="page-title">Manajemen Pembayaran SPP</h1>

<p class="page-desc">
    Kelola tagihan, verifikasi bukti pembayaran, dan pantau status pembayaran siswa SSB HBS.
</p>

{{-- ALERT BANNER VERIFIKASI --}}
<div class="alert-box">
    <div>
        <div class="alert-title">{{ $menunggu }} Pembayaran Menunggu Verifikasi</div>
        <div class="alert-desc">Segera periksa bukti pembayaran siswa yang masih memerlukan persetujuan admin.</div>
    </div>
    <a href="{{ route('admin.pembayaran.index',['status'=>'Menunggu Verifikasi']) }}" class="alert-btn">
        Verifikasi Sekarang
    </a>
</div>

{{-- STATISTIK KARTU WIDGETS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Tagihan</div>
        <div class="stat-value">{{ $totalTagihan }}</div>
        <div class="stat-desc">Data pembayaran terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Belum Bayar</div>
        <div class="stat-value" style="color:#721C24">{{ $belumBayar }}</div>
        <div class="stat-desc">Siswa belum bayar</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Menunggu Verifikasi</div>
        <div class="stat-value" style="color:#D4AF37">{{ $menunggu }}</div>
        <div class="stat-desc">Menunggu persetujuan admin</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Lunas</div>
        <div class="stat-value" style="color:#2E7D32">{{ $lunas }}</div>
        <div class="stat-desc">Pembayaran terverifikasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Ditolak</div>
        <div class="stat-value" style="color:#C62828">{{ $ditolak }}</div>
        <div class="stat-desc">Pembayaran ditolak admin</div>
    </div>
</div>

{{-- AREA FILTER DAN KONTEN TABEL --}}
<div class="table-card">
    <div class="filter-area">
        <form method="GET" class="search-box">
            <input
                type="text"
                name="search"
                placeholder="Cari nama siswa..."
                value="{{ request('search') }}"
                onkeyup="this.form.submit()"
            >
        </form>

        <div class="filter-menu">
            <a href="{{ route('admin.pembayaran.index') }}" class="{{ !request('status') ? 'active' : '' }}">Semua</a>
            <a href="?status=Belum Bayar" class="{{ request('status')=='Belum Bayar' ? 'active' : '' }}">Belum Bayar</a>
            <a href="?status=Menunggu Verifikasi" class="{{ request('status')=='Menunggu Verifikasi' ? 'active' : '' }}">Menunggu Verifikasi</a>
            <a href="?status=Lunas" class="{{ request('status')=='Lunas' ? 'active' : '' }}">Lunas</a>
            <a href="?status=Ditolak" class="{{ request('status')=='Ditolak' ? 'active' : '' }}">Ditolak</a>
        </div>
    </div>

    <div class="table-info">
        Menampilkan {{ $tagihans->count() }} data pembayaran
    </div>

    @if($tagihans->count())
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kategori</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tagihans as $i => $item)
            <tr>
                <td>{{ $tagihans->firstItem() + $i }}</td>
                <td style="font-weight: 600;">{{ $item->siswa->nama ?? '-' }}</td>
                <td><span class="badge" style="background:#F5EFE7; color:#650018;">{{ $item->siswa->kategori_latihan ?? '-' }}</span></td>
                <td>{{ $item->bulan }} {{ $item->tahun }}</td>
                <td style="font-weight: 600; color: #1A2238;">Rp {{ number_format($item->nominal,0,',','.') }}</td>
                <td>
                    @if($item->status == 'Belum Bayar')
                        <span class="badge badge-belum">Belum Bayar</span>
                    @elseif($item->status == 'Menunggu Verifikasi')
                        <span class="badge badge-menunggu">Menunggu Verifikasi</span>
                    @elseif($item->status == 'Lunas')
                        <span class="badge badge-lunas">Lunas</span>
                    @else
                        <span class="badge badge-ditolak">Ditolak</span>
                    @endif
                </td>
                <td>
                    {{ $item->tanggal_bayar
                        ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y')
                        : '-' }}
                </td>
                <td>
                    <div class="action-buttons">
                        @if($item->status == 'Menunggu Verifikasi')
                            <a href="{{ route('admin.pembayaran.show',$item->id) }}" class="verify-btn">
                                Verifikasi
                            </a>
                        @else
                            <a href="{{ route('admin.pembayaran.show',$item->id) }}" class="detail-btn">
                                Detail
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="padding:25px; display:flex; justify-content:center;">
        {{ $tagihans->links() }}
    </div>

    @else
    <div class="empty-state">
        <div style="font-size:48px;">📄</div>
        <h4>Belum ada pembayaran masuk</h4>
        <div>Data pembayaran siswa akan muncul di sini.</div>
    </div>
    @endif
</div>
@endsection