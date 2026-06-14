@extends('pelatih.layouts.pelatih')

@section('title', 'Dashboard Pelatih')

@section('content')

{{-- SIDEBAR DIPANGGIL DI SINI --}}
@include('pelatih.partials.sidebar')

{{-- Tambahkan padding-top agar konten tidak tertutup header yang fixed --}}
<div class="pt-24">

    {{-- ══════════════ HEADER ══════════════ --}}
    <section class="mb-8">
        <p class="text-[#7a1025] font-bold text-xs uppercase tracking-widest mb-1">Portal Pelatih</p>
        <h1 class="text-3xl font-black text-[#1a0b0f] mb-1">Selamat datang, Pelatih!</h1>
        <p class="text-[#4b3a36] text-sm">Berikut ringkasan informasi terbaru.</p>
    </section>

    {{-- ══════════════ STAT CARDS ══════════════ --}}
    <section class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-[#e8d9c0] rounded-2xl px-[1.375rem] py-[1.125rem] shadow-sm flex items-center gap-[.875rem]">
            <div class="bg-[#fff0d6] rounded-xl p-[.55rem] shrink-0">
                <svg class="w-6 h-6 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[#6f5a55] text-[.7rem] mb-[1px]">Total Siswa</p>
                <p class="text-[1.75rem] font-black leading-none mb-[1px] text-[#1a0b0f]">{{ $totalSiswa }}</p>
            </div>
        </div>

        <div class="bg-white border border-[#e8d9c0] rounded-2xl px-[1.375rem] py-[1.125rem] shadow-sm flex items-center gap-[.875rem]">
            <div class="bg-[#fff0d6] rounded-xl p-[.55rem] shrink-0">
                <svg class="w-6 h-6 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="text-[#6f5a55] text-[.7rem] mb-[1px]">Total Jadwal</p>
                <p class="text-[1.75rem] font-black leading-none mb-[1px] text-[#7a1025]">{{ $totalLatihan }}</p>
            </div>
        </div>

        <div class="bg-white border border-[#e8d9c0] rounded-2xl px-[1.375rem] py-[1.125rem] shadow-sm flex items-center gap-[.875rem]">
            <div class="bg-[#fff0d6] rounded-xl p-[.55rem] shrink-0">
                <svg class="w-6 h-6 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <p class="text-[#6f5a55] text-[.7rem] mb-[1px]">Total Absensi</p>
                <p class="text-[1.75rem] font-black leading-none mb-[1px] text-[#7a1025]">{{ $totalAbsensi }}</p>
            </div>
        </div>

        <div class="bg-white border border-[#e8d9c0] rounded-2xl px-[1.375rem] py-[1.125rem] shadow-sm flex items-center gap-[.875rem]">
            <div class="bg-green-50 rounded-xl p-[.55rem] shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[#6f5a55] text-[.7rem] mb-[1px]">Kehadiran</p>
                <p class="text-[1.75rem] font-black leading-none mb-[1px] text-green-600">{{ $persentaseHadir }}%</p>
            </div>
        </div>
    </section>

    {{-- ══════════════ JADWAL + TURNAMEN ══════════════ --}}
    <section class="grid grid-cols-2 gap-6 mb-6">
        {{-- Jadwal Latihan --}}
        <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e6d3]">
                <h2 class="font-black text-[#1a0b0f] text-[.95rem]">Jadwal Latihan</h2>
                <a href="{{ route('pelatih.jadwal.index') }}" class="text-[#7a1025] text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            {{-- Tabel Jadwal di sini --}}
        </div>

        {{-- Turnamen Terdekat --}}
        <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e6d3]">
                <h2 class="font-black text-[#1a0b0f] text-[.95rem]">Turnamen Terdekat</h2>
                <a href="{{ route('pelatih.turnamen.index') }}" class="text-[#7a1025] text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            {{-- Tabel Turnamen di sini --}}
        </div>
    </section>

    {{-- ══════════════ AKSI CEPAT ══════════════ --}}
    <section class="grid grid-cols-2 gap-6 mb-10">
        <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm p-6">
            <h2 class="font-black text-[#1a0b0f] text-[.95rem] mb-5">Aksi Cepat</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('pelatih.absensi.index') }}" class="flex items-center justify-center bg-[#7a1025] text-white rounded-xl py-4 font-bold text-sm hover:bg-[#600018]">Input Absensi</a>
                <a href="{{ route('pelatih.turnamen.pilihSiswa') }}" class="flex items-center justify-center bg-[#7a1025] text-white rounded-xl py-4 font-bold text-sm hover:bg-[#600018]">Pilih Siswa</a>
                <a href="{{ route('pelatih.siswa.index') }}" class="flex items-center justify-center bg-[#7a1025] text-white rounded-xl py-4 font-bold text-sm hover:bg-[#600018]">Kelola Siswa</a>
                <a href="{{ route('pelatih.report.index') }}" class="flex items-center justify-center bg-[#7a1025] text-white rounded-xl py-4 font-bold text-sm hover:bg-[#600018]">Export Report</a>
            </div>
        </div>
        
        <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm p-6">
            <canvas id="attendanceChart" class="h-40"></canvas>
        </div>
    </section>

</div> {{-- Tutup div pt-24 --}}

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',
        data: { labels: @json($chartLabels), datasets: [{ data: @json($chartData), backgroundColor: '#22c55e', borderRadius: 6 }] },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush