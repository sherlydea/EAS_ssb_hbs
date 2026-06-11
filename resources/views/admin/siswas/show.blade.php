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
    color:#666;
    margin-bottom:35px;
}

.alert-success{
    background:#D4EDDA;
    color:#155724;
    padding:14px 18px;
    border-radius:12px;
    margin-bottom:25px;
    font-weight:600;
}

.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.detail-card{
    background:white;
    border-radius:24px;
    padding:30px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.card-title{
    font-size:20px;
    font-weight:700;
    margin-bottom:20px;
    color:#1A2238;
}

.info-row{
    display:flex;
    margin-bottom:14px;
}

.info-label{
    width:180px;
    font-weight:600;
    color:#666;
}

.info-value{
    color:#1A2238;
}

.badge{
    display:inline-block;
    background:#F5EFE7;
    color:#650018;
    padding:6px 14px;
    border-radius:999px;
    font-weight:600;
}

.status-diterima{
    background:#D4EDDA;
    color:#155724;
}

.status-menunggu{
    background:#FFF3CD;
    color:#856404;
}

.status-ditolak{
    background:#F8D7DA;
    color:#721C24;
}

.action-area{
    margin-top:30px;
    display:flex;
    gap:12px;
}

.back-btn{
    background:#650018;
    color:white;
    text-decoration:none;
    padding:12px 24px;
    border-radius:12px;
    font-weight:600;
}

.edit-btn{
    background:#D4AF37;
    color:#1A2238;
    text-decoration:none;
    padding:12px 24px;
    border-radius:12px;
    font-weight:600;
}

.delete-btn{
    background:#DC3545;
    color:white;
    border:none;
    padding:12px 24px;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
}

.delete-btn:hover{
    opacity:.9;
}

.edit-btn:hover{
    opacity:.9;
}

.document-btn{
    display:inline-block;
    padding:8px 14px;
    background:#8B0020;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
}

.document-btn:hover{
    background:#650018;
}

.student-photo{
    width:140px;
    height:180px;
    object-fit:cover;
    border-radius:12px;
    border:2px solid #E5E7EB;
    display:block;
}

@media(max-width:900px){
    .detail-grid{
        grid-template-columns:1fr;
    }
}

</style>

<div class="page-label">DATA SISWA</div>

<h1 class="page-title">Detail Siswa</h1>

<p class="page-desc">
    Informasi lengkap siswa yang telah terdaftar pada SSB HBS.
</p>

@if(session('success'))
<div class="alert-success">
    ✓ {{ session('success') }}
</div>
@endif

<div class="detail-grid">

    {{-- DATA PRIBADI --}}
    <div class="detail-card">

        <div class="card-title">
            Data Pribadi
        </div>

        <div class="info-row">
            <div class="info-label">Nama Siswa</div>
            <div class="info-value">{{ $siswa->nama }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tempat Lahir</div>
            <div class="info-value">{{ $siswa->tempat_lahir ?? '-' }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tanggal Lahir</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Jenis Kelamin</div>
            <div class="info-value">{{ $siswa->jenis_kelamin ?? '-' }}</div>
        </div>

    </div>

    {{-- DATA AKADEMI --}}
    <div class="detail-card">

        <div class="card-title">
            Data Akademi
        </div>

        <div class="info-row">
            <div class="info-label">Kategori</div>
            <div class="info-value">
                <span class="badge">
                    {{ $siswa->kategori_latihan }}
                </span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Tanggal Bergabung</div>
            <div class="info-value">
                {{ $siswa->tanggal_daftar ? \Carbon\Carbon::parse($siswa->tanggal_daftar)->translatedFormat('d F Y') : '-' }}
            </div>
        </div>
    </div>

    {{-- DATA ORANG TUA --}}
    <div class="detail-card">

        <div class="card-title">
            Data Orang Tua
        </div>

        <div class="info-row">
            <div class="info-label">Nama Orang Tua</div>
            <div class="info-value">
                {{ $siswa->nama_orang_tua ?? '-' }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Nomor HP</div>
            <div class="info-value">
                {{ $siswa->no_hp ?? '-' }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Alamat</div>
            <div class="info-value">
                {{ $siswa->alamat ?? '-' }}
            </div>
        </div>

    </div>

    {{-- DOKUMEN --}}
    <div class="detail-card">

        <div class="card-title">
            Dokumen
        </div>

        <div class="info-row">
        <div class="info-label">Foto Siswa</div>

        <div class="info-value">

            @if($pendaftaran && $pendaftaran->foto_siswa)

                <img
                    src="{{ asset('storage/'.$pendaftaran->foto_siswa) }}"
                    class="student-photo"
                    alt="Foto Siswa">

                <br><br>

                <a href="{{ asset('storage/'.$pendaftaran->foto_siswa) }}"
                class="document-btn"
                target="_blank">
                    Lihat Foto
                </a>

            @else

                -

            @endif

        </div>
    </div>

        <div class="info-row">
            <div class="info-label">Surat Izin</div>
            <div class="info-value">
                @if($pendaftaran && $pendaftaran->surat_izin_ortu)
            <a href="{{ asset('storage/'.$pendaftaran->surat_izin_ortu) }}"            class="document-btn"
            target="_blank">
                Lihat Surat
            </a>
            @else
            -
            @endif
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Dokumen Pendukung</div>
            <div class="info-value">
                @if($pendaftaran && $pendaftaran->kartu_pelajar)
            <a href="{{ asset('storage/'.$pendaftaran->kartu_pelajar) }}"
            class="document-btn"
            target="_blank">
                Lihat Dokumen
            </a>                
            @else
                -
            @endif
            </div>
        </div>

    </div>

</div>

<div class="action-area">

    <a href="{{ route('admin.siswas.index') }}"
       class="back-btn">
        ← Kembali
    </a>

    <a href="{{ route('admin.siswas.edit', $siswa->id) }}"
       class="edit-btn">
        Edit Data
    </a>

    <form action="{{ route('admin.siswas.destroy', $siswa->id) }}"
          method="POST"
          onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">

        @csrf
        @method('DELETE')

        <button type="submit" class="delete-btn">
            Hapus
        </button>

    </form>

</div>

@endsection