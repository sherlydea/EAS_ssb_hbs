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
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#1A2238;
}

.form-control{
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

textarea.form-control{
    height:120px;
    padding:15px;
    resize:none;
}

.full-width{
    grid-column:1 / -1;
}

.button-group{
    margin-top:30px;
    display:flex;
    gap:15px;
}

.btn-simpan{
    background:#650018;
    color:white;
    border:none;
    padding:14px 28px;
    border-radius:999px;
    font-weight:600;
    cursor:pointer;
    font-size:14px;
    transition: .2s;
}

.btn-simpan:hover{
    background:#4d0012;
}

.btn-kembali{
    background:#999;
    color:white;
    text-decoration:none;
    padding:14px 28px;
    border-radius:999px;
    font-weight:600;
    font-size:14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
}

.btn-kembali:hover{
    background:#777;
}

.alert-danger{
    background:#ffe5e5;
    color:#b10000;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
    .btn-simpan, .btn-kembali {
        width: 100%;
        text-align: center;
    }
}

</style>


<div class="page-header">
    <h2>Edit Jadwal Latihan</h2>
    <p class="page-desc">
        Perbarui informasi jadwal latihan siswa SSB HBS.
    </p>
</div>

<div class="form-card">

    @if ($errors->any())
        <div class="alert-danger">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jadwal-latihan.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">

            {{-- Hari --}}
            <div class="form-group">
                <label>Hari Latihan</label>
                <select name="hari" class="form-control form-select" required>

                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                        <option value="{{ $hari }}"
                            {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                            {{ $hari }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Kategori --}}
            <div class="form-group">
                <label>Kategori Latihan</label>
                <select name="kategori_latihan" class="form-control form-select" required>

                    @foreach(['U-10','U-13','U-15','U-18'] as $kategori)
                        <option value="{{ $kategori }}"
                            {{ old('kategori_latihan', $jadwal->kategori_latihan) == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Jam Mulai --}}
            <div class="form-group">
                <label>Jam Mulai</label>
                <input
                    type="time"
                    name="jam_mulai"
                    class="form-control"
                    value="{{ old('jam_mulai', substr($jadwal->jam_mulai,0,5)) }}"
                    required>
            </div>

            {{-- Jam Selesai --}}
            <div class="form-group">
                <label>Jam Selesai</label>
                <input
                    type="time"
                    name="jam_selesai"
                    class="form-control"
                    value="{{ old('jam_selesai', substr($jadwal->jam_selesai,0,5)) }}"
                    required>
            </div>

            {{-- Pelatih --}}
            <div class="form-group">
                <label>Pelatih</label>
                <select name="pelatih_id" class="form-control form-select" required>

                    @foreach($pelatih as $item)
                        <option value="{{ $item->id }}"
                            {{ old('pelatih_id', $jadwal->pelatih_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Lokasi --}}
            <div class="form-group">
                <label>Lokasi Latihan</label>
                <select name="lokasi" class="form-control form-select" required>

                    @foreach(['Lapangan Utama','Lapangan Tengah','Lapangan Mini'] as $lokasi)
                        <option value="{{ $lokasi }}"
                            {{ old('lokasi', $jadwal->lokasi) == $lokasi ? 'selected' : '' }}>
                            {{ $lokasi }}
                        </option>
                    @endforeach

                </select>
            </div>

        </div>

        <div class="button-group">

            <button type="submit" class="btn-simpan">
                Update Jadwal
            </button>

            <a href="{{ route('admin.jadwal-latihan.index') }}"
               class="btn-kembali">
                Kembali
            </a>

        </div>

    </form>

</div>

@endsection