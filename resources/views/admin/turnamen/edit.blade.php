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

.form-card{
    background:white;
    border-radius:28px;
    padding:35px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#1A2238;
}

.form-input{
    height:54px;
    border:none;
    background:#F5F1E8;
    border-radius:14px;
    padding:0 18px;
    font-size:14px;
    outline:none;
    box-sizing: border-box;
}

/* Kustomisasi Dropdown Agar Panah Tidak Terlalu Mepet */
.form-select{
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;

    padding-right:50px;

    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%231A2238' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6 6 6-6' stroke='%231A2238' stroke-width='2' fill='none'/%3E%3C/svg%3E");

    background-repeat:no-repeat;
    background-position:right 18px center;
    cursor: pointer;
}

.form-actions{
    margin-top:35px;
    display:flex;
    gap:15px;
}

.btn-save{
    background:#650018;
    color:white;
    text-decoration:none;
    border:none;
    padding:14px 30px;
    border-radius:999px;
    font-weight:700;
    cursor:pointer;
    font-size:14px;
    transition: .2s;
}

.btn-save:hover{
    background:#7d0020;
}

.btn-back{
    background:#999;
    color:white;
    text-decoration:none;
    padding:14px 30px;
    border-radius:999px;
    font-weight:700;
    font-size:14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
}

.btn-back:hover{
    background:#777;
}

.alert-danger{
    background:#ffe5e5;
    color:#c00;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
    .btn-save, .btn-back {
        width: 100%;
        text-align: center;
    }
}
</style>

<div class="page-header">
    <h2>Edit Turnamen</h2>
    <p class="page-desc">
        Perbarui data turnamen SSB HBS.
    </p>
</div>

@if ($errors->any())
    <div class="alert-danger">
        <ul style="margin:0;padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">

    <form action="{{ route('admin.turnamen.update', $turnamen->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label>Nama Turnamen</label>
                <input
                    type="text"
                    name="nama_turnamen"
                    id="nama_turnamen"
                    class="form-input"
                    value="{{ old('nama_turnamen', $turnamen->nama_turnamen) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Tanggal Turnamen</label>
                <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    class="form-input"
                    value="{{ old('tanggal', $turnamen->tanggal) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input
                    type="text"
                    name="lokasi"
                    id="lokasi"
                    class="form-input"
                    value="{{ old('lokasi', $turnamen->lokasi) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-input form-select" required>
                    <option value="Menunggu" {{ old('status', $turnamen->status) == 'Menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="Terdaftar" {{ old('status', $turnamen->status) == 'Terdaftar' ? 'selected' : '' }}>
                        Terdaftar
                    </option>
                    <option value="Selesai" {{ old('status', $turnamen->status) == 'Selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                Update Turnamen
            </button>

            <a href="{{ route('admin.turnamen.index') }}" class="btn-back">
                Kembali
            </a>
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    
    if (form) {
        form.addEventListener('submit', function (e) {
            let nama = document.getElementById('nama_turnamen').value.trim();
            let lokasi = document.getElementById('lokasi').value.trim();
            let tanggal = document.getElementById('tanggal').value;

            if (nama === '') {
                alert('Nama turnamen wajib diisi');
                e.preventDefault();
                return;
            }

            if (tanggal === '') {
                alert('Tanggal turnamen wajib diisi');
                e.preventDefault();
                return;
            }

            if (lokasi === '') {
                alert('Lokasi turnamen wajib diisi');
                e.preventDefault();
                return;
            }
        });
    }
});
</script>

@endsection