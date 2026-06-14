@extends('admin.layouts.app')

@section('content')

<style>

/* Card utama */
.detail-card{
    background:white;
    border-radius:28px;
    padding:40px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

/* Header halaman */
.detail-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.detail-title{
    font-size:42px;
    font-weight:800;
    color:#18253f;
}

/* Badge status */
.status-badge{
    padding:10px 18px;
    border-radius:30px;
    font-size:13px;
    font-weight:700;
}

.status-pending{
    background:#FFF3CD;
    color:#856404;
}

.status-approved{
    background:#D4EDDA;
    color:#155724;
}

.status-rejected{
    background:#F8D7DA;
    color:#721C24;
}

/* Judul setiap section */
.section-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:25px;
    color:#18253f;
}

/* Grid informasi */
.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:25px;
    margin-bottom:40px;
}

.info-item{
    background:#fafafa;
    padding:18px;
    border-radius:16px;
}

.info-label{
    font-size:12px;
    text-transform:uppercase;
    color:#888;
    margin-bottom:8px;
}

.info-value{
    font-size:16px;
    font-weight:600;
}

/* Tombol aksi */
.action-buttons{
    display:flex;
    justify-content:flex-end;
    gap:12px;
}

.btn-reject{
    background:#D93025;
    color:white;
    padding:12px 24px;
    border-radius:30px;
    border:none;
    cursor:pointer;
}

.btn-approve{
    background:#2DBE60;
    color:white;
    padding:12px 24px;
    border-radius:30px;
    border:none;
    cursor:pointer;
}

.btn-back{
    background:#3D000A;
    color:white;
    text-decoration:none;
    padding:12px 24px;
    border-radius:30px;
}

@media(max-width:768px){
    .info-grid{
        grid-template-columns:1fr;
    }

    .detail-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }
}

</style>

<div class="detail-card">

```
{{-- Header Detail --}}
<div class="detail-header">

    <div>
        <div class="detail-title">
            Detail Pendaftaran
        </div>

        <div class="page-subtitle">
            {{ $pendaftaran->nama }}
        </div>
    </div>

    <div>
        @php
            $statusClass = match($pendaftaran->status){
                'diterima' => 'status-approved',
                'ditolak'  => 'status-rejected',
                default    => 'status-pending'
            };
        @endphp

        <span class="status-badge {{ $statusClass }}">
            {{ ucfirst($pendaftaran->status) }}
        </span>
    </div>

</div>

{{-- Data Pribadi --}}
<div class="section-title">Data Pribadi</div>

<div class="info-grid">

    <div class="info-item">
        <div class="info-label">Nama</div>
        <div class="info-value">{{ $pendaftaran->nama }}</div>
    </div>

    <div class="info-item">
        <div class="info-label">Tempat Lahir</div>
        <div class="info-value">{{ $pendaftaran->tempat_lahir }}</div>
    </div>

    <div class="info-item">
        <div class="info-label">Tanggal Lahir</div>
        <div class="info-value">
            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d F Y') }}
            <br>
            <small style="color:#888;">
                {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->age }} Tahun
            </small>
        </div>
    </div>

    <div class="info-item">
        <div class="info-label">Jenis Kelamin</div>
        <div class="info-value">{{ $pendaftaran->jenis_kelamin }}</div>
    </div>

    <div class="info-item">
        <div class="info-label">Kategori Latihan</div>
        <div class="info-value">{{ $pendaftaran->kategori_latihan }}</div>
    </div>

</div>

{{-- Kontak dan Orang Tua --}}
<div class="section-title">Kontak & Orang Tua</div>

<div class="info-grid">

    <div class="info-item">
        <div class="info-label">Email</div>
        <div class="info-value">{{ $pendaftaran->email }}</div>
    </div>

    <div class="info-item">
        <div class="info-label">Nomor HP</div>
        <div class="info-value">{{ $pendaftaran->no_hp }}</div>
    </div>

    <div class="info-item">
        <div class="info-label">Nama Orang Tua</div>
        <div class="info-value">{{ $pendaftaran->nama_orang_tua ?? '-' }}</div>
    </div>

    <div class="info-item">
        <div class="info-label">Alamat</div>
        <div class="info-value">{{ $pendaftaran->alamat }}</div>
    </div>

</div>

{{-- Dokumen yang diupload calon siswa --}}
<div class="section-title">Dokumen Pendaftaran</div>

<div class="info-grid">

    <div class="info-item">
        <div class="info-label">Pas Foto Siswa</div>
        <div class="info-value">
            @if($pendaftaran->foto_siswa)
                <a href="{{ asset('storage/'.$pendaftaran->foto_siswa) }}" target="_blank">
                    Lihat Dokumen
                </a>
            @else
                Belum ada dokumen
            @endif
        </div>
    </div>

    <div class="info-item">
        <div class="info-label">Surat Izin Orang Tua</div>
        <div class="info-value">
            @if($pendaftaran->surat_izin_ortu)
                <a href="{{ asset('storage/'.$pendaftaran->surat_izin_ortu) }}" target="_blank">
                    Lihat Dokumen
                </a>
            @else
                Belum ada dokumen
            @endif
        </div>
    </div>

    <div class="info-item">
        <div class="info-label">Kartu Pelajar</div>
        <div class="info-value">
            @if($pendaftaran->kartu_pelajar)
                <a href="{{ asset('storage/'.$pendaftaran->kartu_pelajar) }}" target="_blank">
                    Lihat Dokumen
                </a>
            @else
                Belum ada dokumen
            @endif
        </div>
    </div>

</div>

{{-- Tombol aksi hanya muncul saat status masih pending --}}
@if($pendaftaran->status == 'pending')

    <div class="action-buttons">

        <form id="tolakForm"
              action="{{ route('admin.pendaftaran.tolak', $pendaftaran->id) }}"
              method="POST">
            @csrf
            <button type="submit" class="btn-reject">
                Tolak
            </button>
        </form>

        <form id="terimaForm"
              action="{{ route('admin.pendaftaran.terima', $pendaftaran->id) }}"
              method="POST">
            @csrf
            <button type="submit" class="btn-approve">
                Terima Siswa
            </button>
        </form>

    </div>

@endif

<br>

<a href="{{ route('admin.pendaftaran') }}" class="btn-back">
    Kembali ke Daftar Pendaftaran
</a>


</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tolakForm = document.getElementById('tolakForm');

    if (tolakForm) {
        tolakForm.addEventListener('submit', function(e){

            if(!confirm('Apakah Anda yakin menolak pendaftaran ini?')){
                e.preventDefault();
            }

        });
    }

    const terimaForm = document.getElementById('terimaForm');

    if (terimaForm) {
        terimaForm.addEventListener('submit', function(e){

            if(!confirm('Apakah Anda yakin menerima siswa ini?')){
                e.preventDefault();
            }

        });
    }

});

</script>

@endsection
