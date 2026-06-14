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
.hero-section{
    background:#650018;
    color:white;
    border-radius:28px;
    padding:28px 32px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.hero-section strong{
    font-size:22px;
    display:block;
    margin-bottom:6px;
}

.hero-subtitle{
    opacity:.9;
    font-size:14px;
}

.btn-tambah{
    background:#D4AF37;
    color:#1A2238;
    text-decoration:none;
    padding:15px 30px;
    border-radius:999px;
    font-weight:700;
    transition: .2s;
    white-space: nowrap;
}

.btn-tambah:hover{
    background:#bc9825;
}

/* Statistik Grid */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:35px;
}

.stat-card{
    background:white;
    border-radius:22px;
    padding:24px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    border-top:4px solid #D4AF37;
}

.stat-card h3{
    font-size:40px;
    margin:0;
    color:#1A2238;
}

.stat-card p{
    margin-top:10px;
    color:#888;
    font-size:12px;
    text-transform:uppercase;
    font-weight:600;
}

/* Area Filter */
.table-card{
    background:white;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.filter-area{
    padding:25px;
}

.filter-form{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.search-input,
.filter-select,
.btn-filter,
.btn-reset{
    height:54px;
    box-sizing: border-box;
}

.search-input {
    min-width:320px;
    border:none;
    background:#F5F1E8;
    border-radius:999px;
    padding:0 20px;
    font-size:14px;
    outline:none;
}

.filter-select{
    min-width:190px;
    border:none;
    background:#F5F1E8;
    border-radius:999px;
    padding:0 45px 0 20px;
    outline:none;
    font-size:14px;
    color:#444;
    cursor:pointer;
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6 6 6-6' stroke='%23666' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat:no-repeat;
    background-position:right 18px center;
}

.btn-filter{
    border:none;
    background:#1A2238;
    color:white;
    padding:0 25px;
    border-radius:999px;
    font-weight:600;
    cursor:pointer;
    font-size:14px;
    transition: .2s;
}

.btn-filter:hover{
    background:#2d3b61;
}

.btn-reset{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 25px;
    background:#999;
    color:white;
    text-decoration:none;
    border-radius:999px;
    font-weight:600;
    font-size:14px;
    transition: .2s;
}

.btn-reset:hover{
    background:#777;
}

/* Tabel Konstruksi */
table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#F5F1E8;
}

th{
    padding:18px;
    text-align:left;
    color:#1A2238;
    font-size:13px;
    font-weight:700;
}

td{
    padding:18px;
    border-top:1px solid #eee;
    font-size:14px;
    color:#333;
}

tbody tr:hover{
    background:#f3eee0;
}

.badge-lisensi{
    background:#FFE7A8;
    color:#7A5200;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

/* Kelompok Aksi */
.action-links{
    display:flex;
    gap:16px;
    align-items:center;
}

.edit-link{
    color:#8a6500;
    text-decoration:none;
    font-weight:700;
    font-size:14px;
}

.edit-link:hover{
    text-decoration:underline;
}

/* Perbaikan Ganti Warna Tombol Hapus Supaya Konsisten Marun */
.delete-btn {
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
    font-size: 14px;
    color: #7A1025;
    font-weight: 700;
    transition: 0.2s;
}

.delete-btn:hover {
    text-decoration: underline;
    color: #5e0d1d;
}

@media(max-width:1200px){
    .stats-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:768px){
    .stats-grid{
        grid-template-columns:1fr;
    }
    .hero-section{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }
    .btn-tambah, .search-input, .filter-select, .btn-filter, .btn-reset{
        width: 100%;
        min-width: unset;
    }
}

</style>

<div class="page-header">
    <h2>Kelola Pelatih</h2>
    <p class="page-desc">Kelola dan pantau seluruh data pelatih SSB HBS.</p>
</div>

<div class="hero-section">
    <div>
        <strong>{{ $totalPelatih }} Pelatih Aktif</strong>
        <div class="hero-subtitle">
            Kelola data pelatih, lisensi, dan jadwal latihan.
        </div>
    </div>
    <a href="{{ route('admin.pelatih.create') }}" class="btn-tambah">
        Tambah Pelatih
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $totalPelatih }}</h3>
        <p>Total Pelatih</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalNasionalC }}</h3>
        <p>Nasional C</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalNasionalD }}</h3>
        <p>Nasional D</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalNasionalB }}</h3>
        <p>Nasional B</p>
    </div>
</div>

<div class="table-card">

    <div class="filter-area">
        <form method="GET" action="{{ route('admin.pelatih.index') }}" class="filter-form">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama pelatih..."
                class="search-input">

            <select name="lisensi" class="filter-select">
                <option value="">Semua Lisensi</option>
                @foreach($daftarLisensi as $lisensi)
                    <option value="{{ $lisensi }}" {{ request('lisensi') == $lisensi ? 'selected' : '' }}>
                        {{ $lisensi }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter">
                Terapkan Filter
            </button>

            <a href="{{ route('admin.pelatih.index') }}" class="btn-reset">
                Reset
            </a>
        </form>
    </div>

    @if($pelatih->count() > 0)
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Lisensi</th>
                    <th>No HP</th>
                    <th>Jadwal Ditangani</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelatih as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600;">{{ $item->nama }}</td>
                    <td>
                        <span class="badge-lisensi">
                            {{ $item->lisensi }}
                        </span>
                    </td>
                    <td>{{ $item->no_hp }}</td>
                    <td><strong>{{ $item->jadwal_latihans_count }}</strong> Jadwal</td>
                    <td>
                        <div class="action-links">
                            <a href="{{ route('admin.pelatih.edit', $item->id) }}" class="edit-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.pelatih.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pelatih ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 50px 20px; color: #888;">
        <div style="font-size:16px; font-weight:600; color:#444;">
            Belum ada data pelatih
        </div>
        <div style="font-size: 13px; margin-top: 5px;">Data pelatih tidak ditemukan atau belum ditambahkan ke sistem.</div>
    </div>
    @endif

</div>

@endsection