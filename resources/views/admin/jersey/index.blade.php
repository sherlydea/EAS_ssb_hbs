@extends('admin.layouts.app')

@section('content')

<style>
.page-header h2{
    font-size:48px;
    font-weight:700;
    color:#1A2238;
    margin-bottom:5px;
}

.page-desc{
    color:#666;
    margin-bottom:35px;
}

/* Hero Section */
.hero-section {
    background: #650018;
    color: white;
    border-radius: 28px;
    padding: 28px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.hero-section strong {
    font-size: 20px;
    font-weight: 700;
    display: block;
    margin-bottom: 6px;
}

.hero-subtitle {
    opacity: 0.85;
    font-size: 14px;
}

/* Statistik Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 35px;
}

.stat-card {
    background: white;
    border-radius: 22px;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,.05);
    border-top: 4px solid #D4AF37;
}

.stat-card h3 {
    font-size: 40px;
    font-weight: 700;
    color: #1A2238;
    margin: 0 0 5px 0;
}

.stat-card p {
    color: #888;
    font-size: 12px;
    text-transform: uppercase;
    margin: 0;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Area Filter & Tab Menu Atas Tabel */
.filter-area{
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.search-box{
    width: 350px;
}

.search-box input{
    width: 100%;
    border: none;
    background: #F5F1E8;
    border-radius: 999px;
    padding: 12px 18px;
    outline: none;
    font-size: 14px;
}

.filter-menu{
    display: flex;
    gap: 8px;
    flex-wrap: nowrap;
    align-items: center;
}

.filter-menu a{
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 999px;
    color: #444;
    background: #F5F1E8;
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    transition: 0.2s;
    white-space: nowrap;
}

.filter-menu .active{
    background: #650018;
    color: white;
}

.filter-menu a:hover:not(.active) {
    background: #e2dbcf;
}

/* Table Card Area */
.table-card {
    background: white;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.05);
    margin-bottom: 35px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #F5F1E8;
}

th {
    padding: 12px 16px;
    text-align: left;
    font-size: 13px;
    font-weight: 700;
    color: #1A2238;
}

td {
    padding: 12px 16px;
    border-top: 1px solid #eee;
    font-size: 14px;
    color: #333;
}

tbody tr {
    transition: .2s;
}

tbody tr:hover {
    background: #f3eee0;
}

/* Badge Status Sesuai 4 Kondisi Database */
.badge-status {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
}
.status-menunggu { background: #FFF3CD; color: #856404; }
.status-diproses { background: #E8EAF6; color: #3F51B5; }
.status-selesai { background: #D4EDDA; color: #155724; }
.status-ditolak { background: #F8D7DA; color: #721C24; }

/* Link Bukti */
.bukti-link {
    color: #8a6500;
    font-weight: 700;
    text-decoration: none;
}
.bukti-link:hover {
    text-decoration: underline;
}

/* Kelompok Tombol Aksi */
.action-buttons {
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}

.btn-terima, .btn-tolak, .btn-selesai {
    border: none;
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
}

.btn-terima { background: #2E7D32; color: white; }
.btn-terima:hover { background: #1B5E20; }

.btn-tolak { background: #C62828; color: white; }
.btn-tolak:hover { background: #B71C1C; }

.btn-selesai { background: #28a745; color: white; }
.btn-selesai:hover { background: #218838; }

@media(max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .filter-area {
        flex-direction: column;
        align-items: stretch;
    }
    .search-box {
        width: 100%;
    }
    .filter-menu {
        flex-wrap: wrap;
        justify-content: start;
    }
}

@media(max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<div class="page-header">
    <h2>Pesanan Jersey</h2>
    <p class="page-desc">
        Pantau pemesanan atribut jersey, detail kustomisasi nama/nomor punggung, dan kelola status produksi logistik siswa.
    </p>
</div>

<div class="hero-section">
    <div>
        <strong>{{ $pesanan->count() }} Total Pemesanan</strong>
        <div class="hero-subtitle">
            Kelola verifikasi pembayaran dan tahapan vendor produksi konveksi jersey.
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $pesanan->count() }}</h3>
        <p>Total Pesanan</p>
    </div>
    <div class="stat-card">
        <h3>{{ $pesanan->where('status','Menunggu')->count() }}</h3>
        <p>Menunggu Verifikasi</p>
    </div>
    <div class="stat-card">
        <h3>{{ $pesanan->where('status','Diproses')->count() }}</h3>
        <p>Sedang Diproses</p>
    </div>
    <div class="stat-card">
        <h3>{{ $pesanan->where('status','Selesai')->count() }}</h3>
        <p>Selesai / Diambil</p>
    </div>
</div>

<div class="table-card">

    <div class="filter-area">
        <form method="GET" action="{{ route('admin.jersey.index') }}" class="search-box">
            <input
                type="text"
                name="search"
                placeholder="Cari nama siswa..."
                value="{{ request('search') }}"
                onkeyup="this.form.submit()"
            >
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>

        <div class="filter-menu">
            <a href="{{ route('admin.jersey.index', ['search' => request('search')]) }}" class="{{ !request('status') || request('status') == 'semua' ? 'active' : '' }}">Semua</a>
            <a href="{{ route('admin.jersey.index', ['status' => 'Menunggu', 'search' => request('search')]) }}" class="{{ request('status')=='Menunggu' ? 'active' : '' }}">Menunggu</a>
            <a href="{{ route('admin.jersey.index', ['status' => 'Diproses', 'search' => request('search')]) }}" class="{{ request('status')=='Diproses' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('admin.jersey.index', ['status' => 'Selesai', 'search' => request('search')]) }}" class="{{ request('status')=='Selesai' ? 'active' : '' }}">Selesai</a>
            <a href="{{ route('admin.jersey.index', ['status' => 'Ditolak', 'search' => request('search')]) }}" class="{{ request('status')=='Ditolak' ? 'active' : '' }}">Ditolak</a>
        </div>
    </div>

    @if($pesanan->count() > 0)
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Tipe Jersey</th>
                    <th>Ukuran</th>
                    <th>Nama & Nomor</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600;">{{ $item->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
                    <td><span class="badge-status" style="background:#F5EFE7; color:#650018;">{{ $item->tipe_jersey }}</span></td>
                    <td style="font-weight: 700;">{{ $item->ukuran }}</td>
                    <td>
                        <span style="color: #650018; font-weight: 600;">{{ $item->nama_punggung ?? '-' }}</span> 
                        <span style="color: #666;">{{ $item->nomor_punggung ? '/ #'.$item->nomor_punggung : '' }}</span>
                    </td>
                    <td style="font-weight: 600; color: #1A2238;">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge-status @if($item->status == 'Menunggu') status-menunggu @elseif($item->status == 'Diproses') status-diproses @elseif($item->status == 'Selesai') status-selesai @else status-ditolak @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        @if(!empty($item->bukti_pembayaran))
                            <a href="{{ asset('uploads/bukti_jersey/'.$item->bukti_pembayaran) }}" target="_blank" class="bukti-link">
                                Lihat Bukti
                            </a>
                        @else
                            <span style="color: #aaa;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if($item->status == 'Menunggu')
                                <form action="{{ route('admin.jersey.terima', $item->id) }}" method="POST" style="display:inline;" class="action-confirm-form" data-msg="Terima dan konfirmasi pembayaran pesanan jersey ini?">
                                    @csrf
                                    <button type="submit" class="btn-terima">Terima</button>
                                </form>
                                <form action="{{ route('admin.jersey.tolak', $item->id) }}" method="POST" style="display:inline;" class="action-confirm-form" data-msg="Tolak bukti pembayaran pesanan jersey ini?">
                                    @csrf
                                    <button type="submit" class="btn-tolak">Tolak</button>
                                </form>
                            @elseif($item->status == 'Diproses')
                                <form action="{{ route('admin.jersey.selesai', $item->id) }}" method="POST" style="display:inline;" class="action-confirm-form" data-msg="Tandai produksi jersey selesai dan siap diambil?">
                                    @csrf
                                    <button type="submit" class="btn-selesai">Selesai</button>
                                </form>
                            @else
                                <span style="color: #2DBE60; font-weight: 700; font-size: 13px; padding-left: 4px;">✓ Selesai</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 50px 20px; color: #888;">
        <div style="font-size:16px; font-weight:600; color:#444;">Tidak ada pesanan jersey</div>
        <div style="font-size:13px; margin-top:5px;">Data pemesanan jersey tidak ditemukan atau tidak sesuai kriteria filter.</div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.action-confirm-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const message = form.getAttribute('data-msg') || 'Apakah Anda yakin ingin memproses aksi ini?';
            const yakin = confirm(message);
            if (!yakin) {
                e.preventDefault();
            }
        });
    });
});
</script>

@endsection