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

tbody tr {
    transition: .2s;
}

tbody tr:hover {
    background: #f3eee0;
}

/* Desain Badge Status yang Berwarna Dinamis */
.badge-status {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}
.status-terdaftar { background: #E8EAF6; color: #3F51B5; }
.status-menunggu { background: #FFF3CD; color: #856404; }
.status-selesai { background: #E2E3E5; color: #383D41; }

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

/* 4. Penambahan Style Custom untuk Tombol Hapus */
.delete-action-btn{
    color:#d21919;
    font-weight:700;
    border:none;
    background:none;
    cursor:pointer;
    padding:0;
    font-size:14px;
    transition: .2s;
}

.delete-action-btn:hover{
    text-decoration:underline;
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
    <h2>Turnamen</h2>
    <p class="page-desc">
        Kelola seluruh data turnamen yang diikuti siswa SSB HBS.
    </p>
</div>

<div class="hero-jadwal">
    <div>
        <strong>{{ $turnamens->count() }} Turnamen</strong>
        <div class="hero-subtitle">
            Kelola jadwal dan informasi turnamen siswa.
        </div>
    </div>
    <a href="{{ route('admin.turnamen.create') }}" class="btn-tambah">
        Tambah Turnamen
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $turnamens->count() }}</h3>
        <p>Total Turnamen</p>
    </div>
    <div class="stat-card">
        <h3>{{ $turnamens->where('status','Terdaftar')->count() }}</h3>
        <p>Terdaftar</p>
    </div>
    <div class="stat-card">
        <h3>{{ $turnamens->where('status','Menunggu')->count() }}</h3>
        <p>Menunggu</p>
    </div>
    <div class="stat-card">
        <h3>{{ $turnamens->where('status','Selesai')->count() }}</h3>
        <p>Selesai</p>
    </div>
</div>

<div class="table-card">
    <div class="filter-area">
        <form method="GET" action="{{ route('admin.turnamen.index') }}" class="filter-form">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama turnamen..."
                class="search-input">

            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="Terdaftar" {{ request('status')=='Terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                <option value="Menunggu" {{ request('status')=='Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Selesai" {{ request('status')=='Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit" class="btn-filter">
                Terapkan Filter
            </button>

            <a href="{{ route('admin.turnamen.index') }}" class="btn-reset">
                Reset
            </a>
        </form>
    </div>

    @if($turnamens->count() > 0)
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Turnamen</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($turnamens as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600;">{{ $item->nama_turnamen }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>
                        <span class="badge-status status-{{ Str::lower($item->status) }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <div class="action-links">
                            <a href="{{ route('admin.turnamen.edit', $item->id) }}" class="edit-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.turnamen.destroy', $item->id) }}" method="POST" class="delete-form">
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
    <div style="padding:50px 20px; text-align:center; color:#888;">
        <div style="font-size:16px; font-weight:600; color:#444;">Belum ada data turnamen</div>
        <div style="font-size:13px; margin-top:5px;">Data turnamen tidak ditemukan atau belum ditambahkan ke sistem.</div>
    </div>
    @endif
</div>

@endsection