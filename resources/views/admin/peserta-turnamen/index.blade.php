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

.btn-tambah {
    background: #D4AF37;
    color: #1A2238;
    text-decoration: none;
    padding: 16px 30px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 14px;
    transition: .2s;
    white-space: nowrap;
}

.btn-tambah:hover {
    background: #b5922e;
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

/* Table Card Area */
.table-card {
    background: white;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.05);
    margin-bottom: 35px;
    padding: 20px 0 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #F5F1E8;
}

th {
    padding: 18px;
    text-align: left;
    font-size: 13px;
    font-weight: 700;
    color: #1A2238;
}

td {
    padding: 18px;
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

/* Badge Status Pembayaran */
.badge-status {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}
.status-lunas { background: #D4EDDA; color: #155724; }
.status-menunggu { background: #FFF3CD; color: #856404; }
.status-belum { background: #F8D7DA; color: #721C24; }

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
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

.btn-terima, .btn-tolak, .btn-konfirmasi, .btn-edit, .btn-delete {
    border: none;
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}

.btn-terima {
    background: #2E7D32;
    color: white;
}
.btn-terima:hover {
    background: #1B5E20;
}

.btn-tolak {
    background: #C62828;
    color: white;
}
.btn-tolak:hover {
    background: #B71C1C;
}

.btn-konfirmasi {
    background: #28a745;
    color: white;
}
.btn-konfirmasi:hover {
    background: #218838;
}

.btn-edit {
    background: #D4AF37;
    color: #1A2238;
}
.btn-edit:hover {
    background: #b5922e;
}

.btn-delete {
    background: #d21919;
    color: white;
}
.btn-delete:hover {
    background: #a81313;
}

/* Garis Pembatas Vertikal Antara Verifikasi Pembayaran & Data Management */
.divider-aksi {
    width: 2px;
    height: 24px;
    background: #e2e8f0;
    margin: 0 4px;
}

@media(max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 768px) {
    .hero-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .divider-aksi {
        display: none;
    }
}
</style>

<div class="page-header">
    <h2>Peserta Turnamen</h2>
    <p class="page-desc">
        Pantau pendaftaran, biaya pendaftaran, dan verifikasi bukti pembayaran peserta turnamen SSB HBS.
    </p>
</div>

<div class="hero-section">
    <div>
        <strong>{{ $peserta->count() }} Pendaftaran Peserta</strong>
        <div class="hero-subtitle">
            Kelola data siswa yang mengikuti ajang turnamen eksternal.
        </div>
    </div>
    <a href="{{ route('admin.peserta-turnamen.create') }}" class="btn-tambah">
        Tambah Peserta
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $peserta->count() }}</h3>
        <p>Total Peserta</p>
    </div>
    <div class="stat-card">
        <h3>{{ $peserta->where('status_pembayaran','Lunas')->count() }}</h3>
        <p>Pembayaran Lunas</p>
    </div>
    <div class="stat-card">
        <h3>{{ $peserta->where('status_pembayaran','Menunggu Konfirmasi')->count() }}</h3>
        <p>Menunggu Konfirmasi</p>
    </div>
    <div class="stat-card">
        <h3>{{ $peserta->where('status_pembayaran','Belum Bayar')->count() }}</h3>
        <p>Belum Bayar</p>
    </div>
</div>

<div class="table-card">
    @if($peserta->count() > 0)
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Turnamen</th>
                    <th>Biaya Pendaftaran</th>
                    <th>Status Bayar</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600;">{{ $item->nama_siswa }}</td>
                    <td>{{ $item->nama_turnamen }}</td>
                    <td style="font-weight: 600; color: #1A2238;">
                        Rp {{ number_format($item->biaya, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge-status @if($item->status_pembayaran == 'Lunas') status-lunas @elseif($item->status_pembayaran == 'Menunggu Konfirmasi') status-menunggu @else status-belum @endif">
                            {{ $item->status_pembayaran }}
                        </span>
                    </td>
                    <td>
                        @if($item->bukti_pembayaran)
                            <a href="{{ asset('uploads/bukti_turnamen/'.$item->bukti_pembayaran) }}" target="_blank" class="bukti-link">
                                Lihat Bukti
                            </a>
                        @else
                            <span style="color: #aaa;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if($item->status_pembayaran == 'Menunggu Konfirmasi')
                                <form action="{{ route('admin.peserta-turnamen.terima', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-terima">
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ route('admin.peserta-turnamen.tolak', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-tolak">
                                        Tolak
                                    </button>
                                </form>
                            @elseif($item->status_pembayaran == 'Belum Bayar')
                                <form action="{{ route('admin.peserta-turnamen.konfirmasi', $item->id) }}" method="POST" class="confirm-payment-form" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-konfirmasi">
                                        Konfirmasi
                                    </button>
                                </form>
                            @endif

                            @if($item->status_pembayaran != 'Lunas')
                                @if($item->status_pembayaran == 'Menunggu Konfirmasi' || $item->status_pembayaran == 'Belum Bayar')
                                    <div class="divider-aksi"></div>
                                @endif

                                <a href="{{ route('admin.peserta-turnamen.edit', $item->id) }}" class="btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('admin.peserta-turnamen.destroy', $item->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        Hapus
                                    </button>
                                </form>
                            @elseif($item->status_pembayaran == 'Lunas')
                                <span style="color: #aaa; padding-left: 10px; font-weight: 600;">-</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="padding:40px; text-align:center; color:#888;">
        <div style="font-size:16px; font-weight:600; color:#444;">Belum ada data pendaftaran peserta</div>
        <div style="font-size:13px; margin-top:5px;">Data relasi peserta turnamen belum dicatat pada sistem.</div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // Intersept konfirmasi klik submit form pembayaran instan secara sentralisasi
    document.querySelectorAll('.confirm-payment-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const yakin = confirm('Konfirmasi pembayaran peserta ini secara manual (Lunas)?');
            if (!yakin) {
                e.preventDefault();
            }
        });
    });

    // Intersept konfirmasi hapus data pendaftaran peserta turnamen (Unobtrusive JS)
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const yakin = confirm('Yakin ingin menghapus data pendaftaran peserta turnamen ini?');
            if (!yakin) {
                e.preventDefault();
            }
        });
    });

});
</script>

@endsection