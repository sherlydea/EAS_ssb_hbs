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
.hero-jadwal {
    background: #650018;
    color: white;
    border-radius: 28px;
    padding: 28px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.hero-jadwal strong {
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

/* Filter Area & Penyeragaman Tinggi Elemen Form */
.filter-area {
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-form {
    display: flex;
    gap: 12px;
    flex-grow: 1;
    flex-wrap: wrap;
}

.search-input,
.filter-select,
.btn-filter,
.btn-reset {
    height: 54px;
    box-sizing: border-box;
}

.search-input {
    min-width: 320px;
    border: none;
    background: #F5F1E8;
    border-radius: 999px;
    padding: 0 20px;
    outline: none;
    font-size: 14px;
}

/* Perubahan Struktur .filter-select Dengan Custom SVG Arrow */
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

.btn-filter {
    border: none;
    background: #1A2238;
    color: white;
    padding: 0 25px;
    border-radius: 999px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: .2s;
}

.btn-filter:hover {
    background: #2d3b61;
}

/* Button Reset Filter */
.btn-reset{
    background:#999;
    color:white;
    text-decoration:none;
    padding:0 25px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:999px;
    font-weight: 600;
    font-size: 14px;
    transition: .2s;
}

.btn-reset:hover{
    background:#777;
}

/* Table Area */
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

/* Hover Tabel Lebih Jelas & Kontras */
tbody tr {
    transition: .2s;
}

tbody tr:hover {
    background: #f3eee0;
}

/* Badge Kategori */
.badge-kategori {
    background: #FFE7A8;
    color: #7A5200;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

/* Kolom Aksi */
.action-links {
    display: flex;
    gap: 16px;
    align-items: center;
}

.edit-link {
    color: #8a6500;
    font-weight: 700;
    text-decoration: none;
    font-size: 14px;
}

.edit-link:hover {
    text-decoration: underline;
}

.delete-action-btn {
    color: #d21919;
    font-weight: 700;
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
    font-size: 14px;
}

.delete-action-btn:hover {
    text-decoration: underline;
}

@media(max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 768px) {
    .hero-jadwal {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .filter-area {
        flex-direction: column;
        align-items: stretch;
    }
    .search-input, .filter-select, .btn-filter, .btn-reset {
        width: 100%;
        min-width: unset;
    }
}

</style>

<div class="page-header">
    <h2>Jadwal Latihan</h2>
    <p class="page-desc">Kelola dan pantau seluruh jadwal latihan berkala siswa SSB HBS.</p>
</div>

<div class="hero-jadwal">
    <div>
        <strong>{{ $jadwalLatihan->count() }} Jadwal Latihan Aktif</strong>
        <div class="hero-subtitle">
            Kelola jadwal latihan mingguan untuk seluruh kategori usia SSB HBS.
        </div>
    </div>
    <a href="{{ route('admin.jadwal-latihan.create') }}" class="btn-tambah">
        Tambah Jadwal
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $jadwalLatihan->count() }}</h3>
        <p>Total Jadwal</p>
    </div>

    <div class="stat-card">
        <h3>
            {{ $jadwalLatihan->where('hari', now()->locale('id')->isoFormat('dddd'))->count() }}
        </h3>
        <p>Jadwal Hari Ini</p>
    </div>

    <div class="stat-card">
        <h3>{{ $jadwalLatihan->pluck('kategori_latihan')->unique()->count() }}</h3>
        <p>Kategori Aktif</p>
    </div>

    <div class="stat-card">
        <h3>{{ $jadwalLatihan->pluck('pelatih_id')->unique()->count() }}</h3>
        <p>Total Pelatih</p>
    </div>
</div>

<div class="table-card">

    <div class="filter-area">
        <form method="GET" action="{{ route('admin.jadwal-latihan.index') }}" class="filter-form">
            
            <input type="text" name="search" placeholder="Cari nama pelatih..." value="{{ request('search') }}" class="search-input">

            <select name="hari" class="filter-select">
                <option value="">Semua Hari</option>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                    <option value="{{ $hari }}" {{ request('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                @endforeach
            </select>

            <select name="kategori_latihan" class="filter-select">
                <option value="">Semua Kategori</option>
                @foreach($kategoriDaftar as $kat)
                    <option value="{{ $kat }}" {{ request('kategori_latihan') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter">
                Terapkan Filter
            </button>
            
            <a href="{{ route('admin.jadwal-latihan.index') }}" class="btn-reset">
                Reset
            </a>
        </form>
    </div>

    @if($jadwalLatihan->count() > 0)
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Kategori</th>
                    <th>Pelatih</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwalLatihan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600;">{{ $item->hari }}</td>
                    <td>{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }} WIB</td>
                    <td>
                        <span class="badge-kategori">
                            {{ $item->kategori_latihan }}
                        </span>
                    </td>
                    <td>{{ $item->pelatih->nama ?? '-' }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>
                        <div class="action-links">
                            <a href="{{ route('admin.jadwal-latihan.edit', $item->id) }}" class="edit-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.jadwal-latihan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-action-btn">
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
            Belum ada jadwal latihan
        </div>
        <div style="font-size: 13px; margin-top: 5px;">Data jadwal latihan tidak ditemukan atau belum ditambahkan.</div>
    </div>
    @endif

</div>

@endsection