@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="detail-card">
        <div class="detail-header">
            <div class="detail-title">Buat Tagihan Baru</div>
            <a href="{{ route('admin.pembayaran.index') }}" class="close-btn">×</a>
        </div>
        <form action="{{ route('admin.pembayaran.store') }}" method="POST" class="content-body">
            @csrf
            <div class="info-grid">
                <div>
                    <label class="info-label">Pilih Siswa</label>
                    <select name="siswa_id" required style="width:100%; padding:15px; border-radius:15px; border:1px solid #ddd;">
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->kategori_latihan }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="info-label">Nominal</label>
                    <input type="number" name="nominal" required placeholder="Contoh: 150000" style="width:100%; padding:15px; border-radius:15px; border:1px solid #ddd;">
                </div>
                <div>
                    <label class="info-label">Bulan</label>
                    <select name="bulan" required style="width:100%; padding:15px; border-radius:15px; border:1px solid #ddd;">
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="info-label">Tahun</label>
                    <input type="number" name="tahun" value="{{ date('Y') }}" required style="width:100%; padding:15px; border-radius:15px; border:1px solid #ddd;">
                </div>
            </div>
            <button type="submit" class="accept-btn" style="width:100%; padding:20px;">Simpan Tagihan</button>
        </form>
    </div>
</div>
@endsection