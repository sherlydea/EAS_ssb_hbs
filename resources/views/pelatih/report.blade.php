@extends('pelatih.layouts.pelatih')

@section('title', 'Report Pelatih')

@push('styles')
<style>
    .stat-card { transition: transform .15s, box-shadow .15s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(122,16,37,.08); }
    .chart-box { position: relative; }
    .export-btn { transition: background .15s, transform .1s; }
    .export-btn:active { transform: scale(.97); }
</style>
@endpush

@section('content')

{{-- ════════════════ HEADER ════════════════ --}}
<section class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <p class="text-[#7a1025] font-bold text-xs uppercase tracking-widest mb-1">Portal Pelatih</p>
        <h1 class="text-2xl font-black text-[#1a0b0f] mb-1">Performance Report & Attendance Analytics</h1>
        <p class="text-[#4b3a36] text-sm">
            Analisis kehadiran, performa siswa, dan rekap kegiatan —
            <span class="font-semibold text-[#7a1025]">{{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}</span>
        </p>
    </div>

    {{-- Export buttons --}}
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('pelatih.report.export', ['type'=>'siswa','bulan'=>$bulan,'tahun'=>$tahun,'kategori'=>$kategori]) }}"
            class="export-btn flex items-center gap-1.5 bg-white border border-[#e8d9c0] hover:bg-[#fdf6ec] text-[#4b3a36] rounded-xl px-3 py-2 text-xs font-bold cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Data Siswa
        </a>
        <a href="{{ route('pelatih.report.export', ['type'=>'absensi','bulan'=>$bulan,'tahun'=>$tahun,'kategori'=>$kategori]) }}"
            class="export-btn flex items-center gap-1.5 bg-white border border-[#e8d9c0] hover:bg-[#fdf6ec] text-[#4b3a36] rounded-xl px-3 py-2 text-xs font-bold cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Absensi
        </a>
        <a href="{{ route('pelatih.report.export', ['type'=>'turnamen','bulan'=>$bulan,'tahun'=>$tahun]) }}"
            class="export-btn flex items-center gap-1.5 bg-[#7a1025] hover:bg-[#600018] text-white rounded-xl px-3 py-2 text-xs font-bold cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export Turnamen
        </a>
    </div>
</section>

{{-- ════════════════ FILTER ════════════════ --}}
<section class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm px-6 py-4 mb-6">
    <form method="GET" action="{{ route('pelatih.report.index') }}">
        <div class="grid grid-cols-4 gap-3 items-end">

            <div class="flex flex-col gap-1">
                <label class="text-[.7rem] font-semibold text-[#6f5a55]">Bulan</label>
                <div class="relative">
                    <select name="bulan" class="w-full border border-[#e8d9c0] rounded-xl py-[.55rem] pl-[.875rem] pr-8 text-[.82rem] bg-white text-[#1a0b0f] appearance-none cursor-pointer">
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
                            <option value="{{ $i + 1 }}" {{ $bulan == $i + 1 ? 'selected' : '' }}>{{ $namaBulan }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3 h-3 pointer-events-none" fill="none" stroke="#6f5a55" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[.7rem] font-semibold text-[#6f5a55]">Tahun</label>
                <div class="relative">
                    <select name="tahun" class="w-full border border-[#e8d9c0] rounded-xl py-[.55rem] pl-[.875rem] pr-8 text-[.82rem] bg-white text-[#1a0b0f] appearance-none cursor-pointer">
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3 h-3 pointer-events-none" fill="none" stroke="#6f5a55" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[.7rem] font-semibold text-[#6f5a55]">Kategori Latihan</label>
                <div class="relative">
                    <select name="kategori" class="w-full border border-[#e8d9c0] rounded-xl py-[.55rem] pl-[.875rem] pr-8 text-[.82rem] bg-white text-[#1a0b0f] appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ $kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3 h-3 pointer-events-none" fill="none" stroke="#6f5a55" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#7a1025] hover:bg-[#600018] text-white rounded-xl py-[.6rem] px-3 text-[.82rem] font-bold cursor-pointer transition-colors">
                    Terapkan
                </button>
                <a href="{{ route('pelatih.report.index') }}" class="flex-1 text-center border border-[#e8d9c0] hover:bg-[#fdf6ec] rounded-xl py-[.6rem] px-3 text-[.82rem] font-semibold text-[#4b3a36] transition-colors leading-[1.6]">
                    Reset
                </a>
            </div>
        </div>
    </form>
</section>

@php
    $total  = $totalHadir + $totalIzin + $totalAlpa;
    $pHadir = $total > 0 ? round(($totalHadir / $total) * 100) : 0;
    $pIzin  = $total > 0 ? round(($totalIzin  / $total) * 100) : 0;
    $pAlpa  = $total > 0 ? round(($totalAlpa  / $total) * 100) : 0;
@endphp

{{-- ════════════════ SUMMARY CARDS ════════════════ --}}
<section class="grid grid-cols-6 gap-3 mb-6">

    <div class="stat-card bg-white border border-[#e8d9c0] rounded-2xl px-4 py-4 shadow-sm">
        <div class="bg-[#fff0d6] rounded-lg p-2 inline-flex mb-2">
            <svg class="w-4 h-4" fill="none" stroke="#7a1025" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <p class="text-2xl font-black text-[#1a0b0f] leading-none">{{ $totalSiswa }}</p>
        <p class="text-[.68rem] text-[#6f5a55] mt-1">Total Siswa</p>
    </div>

    <div class="stat-card bg-white border border-[#e8d9c0] rounded-2xl px-4 py-4 shadow-sm">
        <div class="bg-green-50 rounded-lg p-2 inline-flex mb-2">
            <svg class="w-4 h-4" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <p class="text-2xl font-black text-green-600 leading-none">{{ $totalHadir }}</p>
        <p class="text-[.68rem] text-[#6f5a55] mt-1">Total Hadir</p>
    </div>

    <div class="stat-card bg-white border border-[#e8d9c0] rounded-2xl px-4 py-4 shadow-sm">
        <div class="bg-yellow-50 rounded-lg p-2 inline-flex mb-2">
            <svg class="w-4 h-4" fill="none" stroke="#ca8a04" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <p class="text-2xl font-black text-yellow-600 leading-none">{{ $totalIzin }}</p>
        <p class="text-[.68rem] text-[#6f5a55] mt-1">Total Izin</p>
    </div>

    <div class="stat-card bg-white border border-[#e8d9c0] rounded-2xl px-4 py-4 shadow-sm">
        <div class="bg-red-50 rounded-lg p-2 inline-flex mb-2">
            <svg class="w-4 h-4" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
        <p class="text-2xl font-black text-red-600 leading-none">{{ $totalAlpa }}</p>
        <p class="text-[.68rem] text-[#6f5a55] mt-1">Total Alpa</p>
    </div>

    <div class="stat-card bg-white border border-[#e8d9c0] rounded-2xl px-4 py-4 shadow-sm">
        <div class="bg-blue-50 rounded-lg p-2 inline-flex mb-2">
            <svg class="w-4 h-4" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
        </div>
        <p class="text-2xl font-black text-blue-700 leading-none">{{ $rataKehadiran }}%</p>
        <p class="text-[.68rem] text-[#6f5a55] mt-1">Rata-rata Hadir</p>
    </div>

    <div class="stat-card bg-white border border-[#e8d9c0] rounded-2xl px-4 py-4 shadow-sm">
        <div class="bg-[#fdf6ec] rounded-lg p-2 inline-flex mb-2">
            <svg class="w-4 h-4" fill="none" stroke="#7a1025" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <p class="text-2xl font-black text-[#1a0b0f] leading-none">{{ $jumlahSesi }}</p>
        <p class="text-[.68rem] text-[#6f5a55] mt-1">Sesi Latihan</p>
    </div>

</section>

{{-- ════════════════ CHARTS ════════════════ --}}
<section class="grid grid-cols-3 gap-6 mb-6">

    {{-- Pie Chart --}}
    <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm p-5">
        <h3 class="font-black text-[.85rem] text-[#1a0b0f] mb-3">Distribusi Status Kehadiran</h3>
        <div class="chart-box h-[220px]">
            <canvas id="pieChart"></canvas>
        </div>
        <div class="flex justify-center gap-4 mt-3 text-[.68rem] font-semibold">
            <span class="flex items-center gap-1.5 text-green-700"><span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span>Hadir {{ $pHadir }}%</span>
            <span class="flex items-center gap-1.5 text-yellow-700"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400 inline-block"></span>Izin {{ $pIzin }}%</span>
            <span class="flex items-center gap-1.5 text-red-600"><span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>Alpa {{ $pAlpa }}%</span>
        </div>
    </div>

    {{-- Bar Chart Ranking --}}
    <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm p-5">
        <h3 class="font-black text-[.85rem] text-[#1a0b0f] mb-3">Ranking Kehadiran Siswa</h3>
        <div class="chart-box h-[220px]">
            <canvas id="barChart"></canvas>
        </div>
        <p class="text-[.65rem] text-[#9b8a84] mt-2">Top 8 siswa berdasarkan persentase kehadiran.</p>
    </div>

    {{-- Line Chart Trend --}}
    <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm p-5">
        <h3 class="font-black text-[.85rem] text-[#1a0b0f] mb-3">Trend Kehadiran per Minggu</h3>
        <div class="chart-box h-[220px]">
            <canvas id="lineChart"></canvas>
        </div>
        <p class="text-[.65rem] text-[#9b8a84] mt-2">Persentase hadir tiap minggu dalam bulan ini.</p>
    </div>

</section>

{{-- ════════════════ TABLE DETAIL ABSENSI ════════════════ --}}
<section class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e6d3]">
        <div>
            <h3 class="font-black text-[.95rem] text-[#1a0b0f]">Rekap Absensi per Siswa</h3>
            <p class="text-[#9b8a84] text-[.72rem] mt-[2px]">
                Diurutkan berdasarkan persentase kehadiran tertinggi
            </p>
        </div>
        <span class="bg-[#fff0d6] text-[#7a1025] text-[.72rem] font-bold px-3 py-1 rounded-full">
            {{ $siswasRanked->count() }} siswa
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-[.8rem] border-collapse">
            <thead>
                <tr class="bg-[#fdf6ec]">
                    <th class="px-4 py-[.65rem] text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">No</th>
                    <th class="px-4 py-[.65rem] text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Nama Siswa</th>
                    <th class="px-4 py-[.65rem] text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Kategori</th>
                    <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Total</th>
                    <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Hadir</th>
                    <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Izin</th>
                    <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Alpa</th>
                    <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">% Hadir</th>
                    <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswasRanked as $i => $s)
                @php
                    $fotoUrl = $s->foto_siswa ? asset('storage/'.$s->foto_siswa) : null;
                    $statusKehadiran = $s->pct >= 75 ? ['label' => 'Disiplin', 'class' => 'bg-green-100 text-green-700']
                        : ($s->pct >= 50 ? ['label' => 'Cukup', 'class' => 'bg-yellow-50 text-yellow-700']
                        : ['label' => 'Kurang', 'class' => 'bg-red-100 text-red-700']);
                @endphp
                <tr class="border-t border-[#f5ede0] hover:bg-[#fffaf3] transition-colors">
                    <td class="px-4 py-[.7rem] text-[#9b8a84] text-[.75rem]">{{ $i + 1 }}</td>
                    <td class="px-4 py-[.7rem]">
                        <div class="flex items-center gap-[.625rem]">
                            @if($fotoUrl)
                                <img src="{{ $fotoUrl }}" class="w-[34px] h-[34px] rounded-full object-cover border-2 border-[#e8d9c0] shrink-0" alt="">
                            @else
                                <div class="w-[34px] h-[34px] rounded-full bg-[#f3ebe0] flex items-center justify-center text-[.75rem] font-black text-[#7a1025] shrink-0">
                                    {{ strtoupper(substr($s->nama, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-[#1a0b0f] leading-snug">{{ $s->nama }}</p>
                                <p class="text-[.7rem] text-[#9b8a84]">{{ $s->nama_orang_tua ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-[.7rem]">
                        <span class="bg-[#fff0d6] text-[#7a1025] text-[.7rem] font-bold px-2 py-[2px] rounded-full">{{ $s->kategori_latihan }}</span>
                    </td>
                    <td class="px-4 py-[.7rem] text-center font-semibold text-[#1a0b0f]">{{ $s->total }}</td>
                    <td class="px-4 py-[.7rem] text-center font-bold text-green-600">{{ $s->hadir }}</td>
                    <td class="px-4 py-[.7rem] text-center font-bold text-yellow-600">{{ $s->izin }}</td>
                    <td class="px-4 py-[.7rem] text-center font-bold text-red-600">{{ $s->alpa }}</td>
                    <td class="px-4 py-[.7rem] text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full {{ $s->pct >= 75 ? 'bg-green-500' : ($s->pct >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $s->pct }}%"></div>
                            </div>
                            <span class="font-bold text-[.75rem] {{ $s->pct >= 75 ? 'text-green-600' : ($s->pct >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $s->pct }}%
                            </span>
                        </div>
                    </td>
                    <td class="px-4 py-[.7rem] text-center">
                        <span class="{{ $statusKehadiran['class'] }} text-[.7rem] font-bold px-[10px] py-[3px] rounded-full">
                            {{ $statusKehadiran['label'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-10 text-center">
                        <p class="text-[#9b8a84] text-[.85rem]">Belum ada data absensi untuk periode ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- ════════════════ JADWAL + TURNAMEN ════════════════ --}}
<section class="grid grid-cols-2 gap-6 mb-6">

    {{-- Jadwal Latihan --}}
    <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-[#f0e6d3]">
            <h3 class="font-black text-[.95rem] text-[#1a0b0f]">Jadwal Latihan Aktif</h3>
        </div>
        <div class="p-4 grid grid-cols-1 gap-2">
            @forelse($jadwals as $jadwal)
            <div class="flex items-center justify-between bg-[#fdf6ec] rounded-xl px-4 py-3">
                <div>
                    <p class="font-bold text-[#1a0b0f] text-sm">{{ $jadwal->hari }}</p>
                    <p class="text-[.72rem] text-[#6f5a55]">{{ substr($jadwal->jam_mulai,0,5) }} – {{ substr($jadwal->jam_selesai,0,5) }} · {{ $jadwal->nama_pelatih ?? '-' }}</p>
                </div>
                <span class="bg-[#fff0d6] text-[#7a1025] text-[.7rem] font-bold px-2 py-1 rounded-full">{{ $jadwal->kategori_latihan }}</span>
            </div>
            @empty
            <p class="text-center text-[#9b8a84] text-sm py-8">Belum ada jadwal latihan.</p>
            @endforelse
        </div>
    </div>

    {{-- Rekap Turnamen --}}
    <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-[#f0e6d3]">
            <h3 class="font-black text-[.95rem] text-[#1a0b0f]">Rekap Turnamen</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[.8rem] border-collapse">
                <thead>
                    <tr class="bg-[#fdf6ec]">
                        <th class="px-4 py-[.65rem] text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Turnamen</th>
                        <th class="px-4 py-[.65rem] text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Tanggal</th>
                        <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Peserta</th>
                        <th class="px-4 py-[.65rem] text-center text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($turnamens as $t)
                    @php
                        $statusColor = match(strtolower($t->status ?? '')) {
                            'terdaftar' => 'bg-blue-50 text-blue-700',
                            'berlangsung' => 'bg-green-50 text-green-700',
                            'selesai' => 'bg-gray-100 text-gray-500',
                            default => 'bg-blue-50 text-blue-700',
                        };
                    @endphp
                    <tr class="border-t border-[#f5ede0] hover:bg-[#fffaf3] transition-colors">
                        <td class="px-4 py-[.7rem]">
                            <p class="font-semibold text-[#1a0b0f] leading-snug">{{ $t->nama_turnamen }}</p>
                            <p class="text-[.7rem] text-[#9b8a84]">{{ $t->lokasi }}</p>
                        </td>
                        <td class="px-4 py-[.7rem] text-[#4b3a36] whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-4 py-[.7rem] text-center font-bold text-[#7a1025]">{{ $t->jumlah_peserta }} siswa</td>
                        <td class="px-4 py-[.7rem] text-center">
                            <span class="{{ $statusColor }} text-[.7rem] font-bold px-[10px] py-[3px] rounded-full">
                                {{ $t->status ?? 'Terdaftar' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-[#9b8a84] text-sm">Belum ada data turnamen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

{{-- ════════════════ INFO LAPORAN ════════════════ --}}
<section class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm p-6">
    <h3 class="font-black text-[.95rem] text-[#1a0b0f] mb-4">Informasi Laporan</h3>
    <div class="grid grid-cols-3 gap-3">
        <div class="flex items-center gap-3 bg-[#fdf6ec] rounded-xl px-4 py-3">
            <svg class="w-4 h-4 shrink-0 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <div>
                <p class="text-[.68rem] text-[#6f5a55]">Periode Laporan</p>
                <p class="text-[.82rem] font-bold text-[#1a0b0f]">{{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 bg-[#fdf6ec] rounded-xl px-4 py-3">
            <svg class="w-4 h-4 shrink-0 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <div>
                <p class="text-[.68rem] text-[#6f5a55]">Filter Kategori</p>
                <p class="text-[.82rem] font-bold text-[#1a0b0f]">{{ $kategori ?: 'Semua Kategori' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
            <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
            <div>
                <p class="text-[.68rem] text-green-700">Status Data</p>
                <p class="text-[.82rem] font-bold text-green-700">Up-to-date · {{ now()->translatedFormat('d M Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// ── PIE CHART: Hadir vs Izin vs Alpa ──
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Izin', 'Alpa'],
        datasets: [{
            data: [{{ $totalHadir }}, {{ $totalIzin }}, {{ $totalAlpa }}],
            backgroundColor: ['#16a34a', '#facc15', '#dc2626'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '65%'
    }
});

// ── BAR CHART: Ranking Kehadiran (Top 8) ──
var rankNames = @json($siswasRanked->take(8)->pluck('nama'));
var rankPct   = @json($siswasRanked->take(8)->pluck('pct'));

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: rankNames,
        datasets: [{
            label: '% Hadir',
            data: rankPct,
            backgroundColor: rankPct.map(p => p >= 75 ? '#16a34a' : (p >= 50 ? '#facc15' : '#dc2626')),
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { max: 100, ticks: { callback: v => v + '%' }, grid: { color: '#f5ede0' } },
            y: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});

// ── LINE CHART: Trend Mingguan ──
var trendLabels = @json($trendMingguan->pluck('label'));
var trendData   = @json($trendMingguan->pluck('pct'));

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: trendLabels.length ? trendLabels : ['Belum ada data'],
        datasets: [{
            label: '% Hadir',
            data: trendData.length ? trendData : [0],
            borderColor: '#7a1025',
            backgroundColor: 'rgba(122,16,37,.08)',
            fill: true,
            tension: 0.35,
            pointBackgroundColor: '#7a1025',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { min: 0, max: 100, ticks: { callback: v => v + '%' }, grid: { color: '#f5ede0' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush