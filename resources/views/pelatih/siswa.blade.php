@extends('pelatih.layouts.pelatih')

@section('title', 'Seleksi Siswa – Turnamen')

@section('content')

{{-- ══════════════ PAGE HEADER ══════════════ --}}
<section class="mb-6">
    <p class="text-[#7a1025] font-bold text-xs uppercase tracking-widest mb-1">Portal Pelatih</p>
    <h1 class="text-2xl font-black text-[#1a0b0f] mb-1">Seleksi Siswa Turnamen</h1>
    <p class="text-[#6f5a55] text-sm"> </p>
</section>



{{-- ══════════════ SUCCESS / ERROR FLASH ══════════════ --}}
@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 rounded-xl px-5 py-3 flex items-center gap-3">
    <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif
@if(session('error'))
<div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-5 py-3 flex items-center gap-3">
    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
</div>
@endif

{{-- ══════════════ STEP 1: PILIH TURNAMEN (dropdown) ══════════════ --}}
<div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm mb-5 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e6d3]">
        <h2 class="font-black text-[#1a0b0f] text-[.95rem] flex items-center gap-2">
            <svg class="w-4 h-4 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9H4.5a2.5 2.5 0 010-5H6m12 0h1.5a2.5 2.5 0 010 5H18M4 22h16M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22m4-7.34V17c0 .55.47.98.97 1.21C13.15 18.75 14 20.24 14 22M18 2H6v7a6 6 0 0012 0V2z"/>
            </svg>
            Turnamen
        </h2>
        <span class="text-[#9b8a84] text-xs">Data dari admin</span>
    </div>

    <div class="px-6 py-5">
        @if($turnamens->isEmpty())
            <p class="text-[#9b8a84] text-sm text-center py-4">Belum ada turnamen yang dibuat admin.</p>
        @else
            {{-- Dropdown select turnamen --}}
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <select id="sel-turnamen"
                        onchange="window.location.href='{{ route('pelatih.siswa.index') }}?turnamen_id='+this.value"
                        class="w-full appearance-none border-2 rounded-xl px-4 py-3 pr-10 text-sm font-semibold text-[#1a0b0f] bg-white focus:outline-none focus:border-[#7a1025] transition-colors
                            {{ $turnamenAktif ? 'border-[#7a1025]' : 'border-[#e8d9c0]' }}">
                        <option value="">— Pilih turnamen —</option>
                        @foreach($turnamens as $t)
                            <option value="{{ $t->id }}" {{ $turnamenId == $t->id ? 'selected' : '' }}>
                                {{ $t->nama_turnamen }}
                                @if($t->tanggal) · {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }} @endif
                                @if($t->lokasi) · {{ $t->lokasi }} @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="w-4 h-4 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Status badge --}}
                @if($turnamenAktif)
                @php
                    $stColor = match(strtolower($turnamenAktif->status ?? 'pendaftaran')) {
                        'berlangsung' => 'bg-green-50 text-green-700 border-green-200',
                        'selesai'     => 'bg-gray-100 text-gray-500 border-gray-200',
                        default       => 'bg-blue-50 text-blue-700 border-blue-200',
                    };
                @endphp
                <span class="text-xs font-bold px-3 py-2 rounded-xl border whitespace-nowrap {{ $stColor }}">
                    {{ $turnamenAktif->status ?? 'Pendaftaran' }}
                </span>
                @endif
            </div>

            {{-- Info detail turnamen aktif --}}
            @if($turnamenAktif)
            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1.5 px-4 py-3 bg-[#fdf6ec] border border-[#e8d9c0] rounded-xl text-xs text-[#6f5a55]">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span class="font-medium text-[#1a0b0f]">{{ $turnamenAktif->tanggal ? \Carbon\Carbon::parse($turnamenAktif->tanggal)->translatedFormat('d F Y') : '—' }}</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                    <span class="font-medium text-[#1a0b0f]">{{ $turnamenAktif->lokasi ?? '—' }}</span>
                </span>
                @if(isset($turnamenAktif->kategori))
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span class="font-medium text-[#1a0b0f]">{{ $turnamenAktif->kategori }}</span>
                </span>
                @endif
            </div>
            @endif
        @endif
    </div>
</div>

{{-- ══════════════ STEP 2: SISWA ══════════════ --}}
@if($turnamenAktif)

{{-- STAT CARDS --}}
<div class="grid grid-cols-4 gap-3 mb-5">
    <div class="bg-white border border-[#e8d9c0] rounded-xl px-4 py-3 text-center">
        <p class="text-[1.6rem] font-black leading-none text-[#1a0b0f] mb-0.5">{{ $totalSiswa }}</p>
        <p class="text-[#9b8a84] text-[.68rem] uppercase tracking-wide">Total Siswa</p>
    </div>
    <div class="bg-white border border-[#e8d9c0] rounded-xl px-4 py-3 text-center">
        <p class="text-[1.6rem] font-black leading-none text-[#7a1025] mb-0.5">{{ $memenuhiKriteria }}</p>
        <p class="text-[#9b8a84] text-[.68rem] uppercase tracking-wide">Memenuhi Filter</p>
    </div>
    <div class="bg-white border border-[#e8d9c0] rounded-xl px-4 py-3 text-center">
        <p class="text-[1.6rem] font-black leading-none text-[#7a1025] mb-0.5" id="stat-dipilih">{{ $sudahDipilih }}</p>
        <p class="text-[#9b8a84] text-[.68rem] uppercase tracking-wide">Dipilih</p>
    </div>
    <div class="bg-white border border-[#e8d9c0] rounded-xl px-4 py-3 text-center">
        <p class="text-[1.6rem] font-black leading-none text-green-600 mb-0.5">{{ $rataRataKehadiran }}%</p>
        <p class="text-[#9b8a84] text-[.68rem] uppercase tracking-wide">Rata-rata Hadir</p>
    </div>
</div>

{{-- TABLE CARD --}}
<form method="GET" action="{{ route('pelatih.siswa.index') }}" id="filter-form">
    <input type="hidden" name="turnamen_id" value="{{ $turnamenId }}">

    <div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden mb-5">

        {{-- Card header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e6d3]">
            <h2 class="font-black text-[#1a0b0f] text-[.95rem] flex items-center gap-2">
                <svg class="w-4 h-4 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Daftar Siswa Eligible
            </h2>
            <p class="text-[#9b8a84] text-xs">Klik baris untuk pilih / batal pilih</p>
        </div>

        {{-- SELECTED TAGS PANEL (di dalam card, di atas tabel) --}}
        <div id="selected-panel" class="{{ count($selectedSiswaIds) > 0 ? '' : 'hidden' }}
            border-b border-[#f0e6d3] px-5 py-3 bg-[#fdf6ec]">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-[#1a0b0f]">
                    <span id="selected-count">{{ count($selectedSiswaIds) }}</span> siswa dipilih
                </p>
                <button type="button" onclick="batalSemua()"
                    class="text-[#7a1025] text-xs font-semibold hover:underline">
                    Batal semua
                </button>
            </div>
            <div class="flex flex-wrap gap-2" id="selected-tags">
                @foreach($siswas->where('is_selected', true) as $s)
                <div class="flex items-center gap-1.5 bg-white border border-[#e8d9c0] rounded-full px-3 py-1 text-xs text-[#1a0b0f]"
                     id="tag-{{ $s->id }}">
                    {{ $s->nama }}
                    <button type="button" onclick="removeTag({{ $s->id }})"
                        class="text-[#9b8a84] hover:text-[#7a1025] leading-none font-bold"
                        aria-label="Hapus {{ $s->nama }}">×</button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Filter bar --}}
        <div class="flex flex-wrap gap-2 px-6 py-3 border-b border-[#f0e6d3] bg-[#fdf9f3]">
            <div class="relative flex-1 min-w-[180px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[#9b8a84]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama siswa, HP, atau orang tua…"
                    class="w-full pl-8 pr-3 py-2 text-sm border border-[#e8d9c0] rounded-lg bg-white text-[#1a0b0f] focus:outline-none focus:border-[#7a1025]">
            </div>
            <select name="kategori" onchange="this.form.submit()"
                class="border border-[#e8d9c0] rounded-lg px-3 py-2 text-sm text-[#4b3a36] bg-white focus:outline-none focus:border-[#7a1025]">
                <option value="semua" {{ request('kategori','semua') === 'semua' ? 'selected' : '' }}>Semua kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <select name="kehadiran" onchange="this.form.submit()"
                class="border border-[#e8d9c0] rounded-lg px-3 py-2 text-sm text-[#4b3a36] bg-white focus:outline-none focus:border-[#7a1025]">
                <option value="semua" {{ request('kehadiran','semua') === 'semua' ? 'selected' : '' }}>Semua kehadiran</option>
                <option value="70" {{ request('kehadiran') === '70' ? 'selected' : '' }}>≥ 70%</option>
                <option value="50" {{ request('kehadiran') === '50' ? 'selected' : '' }}>≥ 50%</option>
            </select>
            <select name="sort" onchange="this.form.submit()"
                class="border border-[#e8d9c0] rounded-lg px-3 py-2 text-sm text-[#4b3a36] bg-white focus:outline-none focus:border-[#7a1025]">
                <option value="nama_asc"       {{ request('sort','nama_asc') === 'nama_asc'       ? 'selected' : '' }}>Nama A–Z</option>
                <option value="nama_desc"      {{ request('sort') === 'nama_desc'                 ? 'selected' : '' }}>Nama Z–A</option>
                <option value="kehadiran_desc" {{ request('sort') === 'kehadiran_desc'            ? 'selected' : '' }}>Kehadiran tertinggi</option>
                <option value="umur_asc"       {{ request('sort') === 'umur_asc'                  ? 'selected' : '' }}>Umur termuda</option>
                <option value="umur_desc"      {{ request('sort') === 'umur_desc'                 ? 'selected' : '' }}>Umur tertua</option>
            </select>
            <button type="submit"
                class="bg-[#7a1025] hover:bg-[#600018] text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                Terapkan
            </button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-[.8rem] border-collapse" id="tabel-siswa">
                <thead>
                    <tr class="bg-[#fdf6ec]">
                        <th class="w-12 px-4 py-3">
                            <input type="checkbox" id="check-all"
                                class="w-4 h-4 accent-[#7a1025] cursor-pointer rounded"
                                title="Pilih semua">
                        </th>
                        <th class="px-4 py-3 text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Nama Siswa</th>
                        <th class="px-4 py-3 text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Kategori</th>
                        <th class="px-4 py-3 text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">Kehadiran</th>
                        <th class="px-4 py-3 text-left text-[#6f5a55] text-[.68rem] uppercase tracking-[.05em] font-semibold">No. HP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $siswa)
                    @php
                        $h          = $siswa->persentase_kehadiran;
                        $hadirClass = $h >= 70
                            ? 'bg-green-50 text-green-700 border border-green-200'
                            : ($h >= 40
                                ? 'bg-yellow-50 text-yellow-700 border border-yellow-200'
                                : 'bg-red-50 text-red-700 border border-red-200');
                        $isSelected = $siswa->is_selected;
                        $initials   = collect(explode(' ', $siswa->nama))
                                        ->take(2)
                                        ->map(fn($w) => strtoupper($w[0]))
                                        ->join('');
                        $jk         = $siswa->jenis_kelamin ?? ($siswa->kelamin ?? '—');
                    @endphp
                    <tr class="border-t border-[#f5ede0] cursor-pointer transition-colors siswa-row
                               {{ $isSelected ? 'bg-[#fef9f0] border-l-4 border-l-[#7a1025]' : 'hover:bg-[#fffaf3]' }}"
                        onclick="toggleRow(this)"
                        data-id="{{ $siswa->id }}"
                        data-nama="{{ $siswa->nama }}"
                        data-selected="{{ $isSelected ? '1' : '0' }}">

                        <td class="px-4 py-3" onclick="event.stopPropagation()">
                            <input type="checkbox"
                                name="siswa_ids_check[]"
                                value="{{ $siswa->id }}"
                                class="siswa-checkbox w-4 h-4 accent-[#7a1025] cursor-pointer rounded"
                                {{ $isSelected ? 'checked' : '' }}
                                onchange="syncRow(this)">
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#fff0d6] flex items-center justify-center
                                            text-[#7a1025] text-[.68rem] font-bold shrink-0">
                                    {{ $initials }}
                                </div>
                                <p class="font-semibold text-[#1a0b0f]">{{ $siswa->nama }}</p>
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            <span class="bg-[#fff0d6] text-[#7a4f00] text-[.72rem] font-bold px-2 py-[2px] rounded-full border border-[#e8d9c0]">
                                {{ $siswa->kategori_latihan ?? '—' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-[#4b3a36]">{{ $jk }}</td>

                        <td class="px-4 py-3">
                            <span class="text-[.72rem] font-bold px-2 py-[2px] rounded-full {{ $hadirClass }}">
                                {{ $h }}%
                            </span>
                        </td>

                        <td class="px-4 py-3 text-[#4b3a36]">{{ $siswa->no_hp ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <svg class="w-10 h-10 mx-auto mb-2 text-[#e8d9c0]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-[#9b8a84] text-sm">Tidak ada siswa yang memenuhi kriteria.</p>
                            <p class="text-[#9b8a84] text-xs mt-1">Coba ubah filter atau periksa kategori latihan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>{{-- /card --}}
</form>

{{-- RIWAYAT PESERTA TURNAMEN --}}
{{-- Kita filter koleksinya di sini agar hanya menampilkan turnamen yang aktif --}}
@php
    $riwayatTurnamenIni = $riwayat->where('turnamen_id', (int)$turnamenId);
@endphp

@if($riwayatTurnamenIni->count() > 0)
<div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden mb-24">
    <div class="px-6 py-4 border-b border-[#f0e6d3]">
        <h2 class="font-black text-[#1a0b0f]">Riwayat Peserta: {{ $turnamenAktif->nama_turnamen ?? 'Turnamen' }}</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#fdf6ec]">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Pembayaran</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatTurnamenIni as $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $item->nama_siswa }}</td>
                    <td class="px-4 py-3">{{ $item->kategori_latihan }}</td>
                    <td class="px-4 py-3">{{ $item->status_pembayaran }}</td>
                    <td class="px-4 py-3">{{ $item->status_turnamen }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ══════════════ STICKY BOTTOM BAR ══════════════ --}}
<div class="fixed bottom-0 left-0 right-0 z-20 bg-white border-t border-[#e8d9c0] shadow-lg
            px-8 py-3 flex items-center justify-between gap-4">
    <p class="text-sm text-[#6f5a55]">
        <strong class="text-[#1a0b0f]" id="bar-count">{{ $sudahDipilih }}</strong> siswa dipilih untuk
        <span class="text-[#7a1025] font-semibold">{{ $turnamenAktif->nama_turnamen }}</span>
    </p>
    <div class="flex gap-2">
        <button type="button" id="btn-preview"
            onclick="bukaPreview()"
            {{ $sudahDipilih === 0 ? 'disabled' : '' }}
            class="flex items-center gap-1.5 border border-[#7a1025] text-[#7a1025] bg-white
                   hover:bg-[#f5e8ec] text-sm font-semibold px-4 py-2 rounded-lg transition-colors
                   disabled:opacity-40 disabled:cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Preview laporan
        </button>

        <form method="POST" action="{{ route('pelatih.siswa.simpanPeserta') }}" id="form-simpan">
            @csrf
            <input type="hidden" name="turnamen_id" value="{{ $turnamenId }}">
            <div id="hidden-siswa-ids"></div>
            <button type="submit" id="btn-simpan"
                {{ $sudahDipilih === 0 ? 'disabled' : '' }}
                class="flex items-center gap-1.5 bg-[#7a1025] hover:bg-[#600018] text-white
                       text-sm font-semibold px-5 py-2 rounded-lg transition-colors
                       disabled:opacity-40 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan peserta turnamen
            </button>
        </form>
    </div>
</div>

{{-- ══════════════ PREVIEW MODAL ══════════════ --}}
<div id="modal-preview" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] flex flex-col border border-[#e8d9c0]">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0e6d3]">
            <h3 class="font-black text-[#1a0b0f] text-base flex items-center gap-2">
                <svg class="w-4 h-4 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Preview laporan seleksi
            </h3>
            <button onclick="tutupPreview()" class="text-[#9b8a84] hover:text-[#1a0b0f] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 px-6 py-5">
            {{-- Info turnamen --}}
            <div class="bg-[#fdf6ec] border border-[#e8d9c0] rounded-xl px-5 py-3 mb-5">
                <p class="font-bold text-[#1a0b0f] text-sm mb-1">{{ $turnamenAktif->nama_turnamen }}</p>
                <div class="flex flex-wrap gap-4 text-xs text-[#6f5a55]">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $turnamenAktif->tanggal ? \Carbon\Carbon::parse($turnamenAktif->tanggal)->translatedFormat('d F Y') : '—' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-[#7a1025]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                        {{ $turnamenAktif->lokasi ?? '—' }}
                    </span>
                </div>
            </div>
            <div id="preview-table-wrap">
                <p class="text-[#9b8a84] text-sm text-center py-6">Pilih siswa terlebih dahulu.</p>
            </div>
        </div>

        <div class="flex justify-between items-center px-6 py-4 border-t border-[#f0e6d3]">
            <p class="text-xs text-[#9b8a84]" id="preview-meta"></p>
            <div class="flex gap-2">
                <button onclick="window.print()"
                    class="flex items-center gap-1.5 border border-[#e8d9c0] text-[#4b3a36] bg-white
                           hover:bg-[#fdf6ec] text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak
                </button>
                <button onclick="tutupPreview()"
                    class="bg-[#7a1025] hover:bg-[#600018] text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>


@else
{{-- Belum pilih turnamen --}}
<div class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm px-6 py-12 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-[#e8d9c0]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    <p class="font-bold text-[#1a0b0f] mb-1">Pilih turnamen terlebih dahulu</p>
    <p class="text-[#9b8a84] text-sm">Gunakan dropdown di atas untuk memilih turnamen, lalu daftar siswa akan muncul di sini.</p>
</div>
@endif

@endsection

@push('scripts')
<script>
// ── DATA dari server (sudah diprepare di controller) ──────────────
const serverSelectedIds = @json($selectedSiswaIds);
const siswaDataJs       = @json($siswaDataJs);

// ── STATE ─────────────────────────────────────────────────────────
let dipilih = new Set(serverSelectedIds.map(Number));

// ── TOGGLE via klik baris ─────────────────────────────────────────
function toggleRow(row) {
    const cb = row.querySelector('.siswa-checkbox');
    cb.checked = !cb.checked;
    syncRow(cb);
}

// ── SYNC checkbox → state ─────────────────────────────────────────
function syncRow(checkbox) {
    const row  = checkbox.closest('tr');
    const id   = parseInt(row.dataset.id);
    const nama = row.dataset.nama;

    if (checkbox.checked) {
        dipilih.add(id);
        row.classList.add('bg-[#fef9f0]', 'border-l-4', 'border-l-[#7a1025]');
        row.classList.remove('hover:bg-[#fffaf3]');
        addTag(id, nama);
    } else {
        dipilih.delete(id);
        row.classList.remove('bg-[#fef9f0]', 'border-l-4', 'border-l-[#7a1025]');
        row.classList.add('hover:bg-[#fffaf3]');
        removeTagElement(id);
    }
    updateAll();
}

// ── SELECT ALL ────────────────────────────────────────────────────
document.getElementById('check-all')?.addEventListener('change', function () {
    document.querySelectorAll('.siswa-checkbox').forEach(cb => {
        cb.checked = this.checked;
        syncRow(cb);
    });
});

// ── TAG helpers ───────────────────────────────────────────────────
function addTag(id, nama) {
    if (document.getElementById('tag-' + id)) return;
    const tags = document.getElementById('selected-tags');
    const div  = document.createElement('div');
    div.id        = 'tag-' + id;
    div.className = 'flex items-center gap-1.5 bg-white border border-[#e8d9c0] rounded-full px-3 py-1 text-xs text-[#1a0b0f]';
    div.innerHTML = `${nama} <button type="button" onclick="removeTag(${id})"
        class="text-[#9b8a84] hover:text-[#7a1025] font-bold leading-none">×</button>`;
    tags.appendChild(div);
}

function removeTagElement(id) {
    document.getElementById('tag-' + id)?.remove();
}

// dipanggil dari tombol × di tag
function removeTag(id) {
    dipilih.delete(id);
    removeTagElement(id);
    // uncheck row
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (row) {
        const cb = row.querySelector('.siswa-checkbox');
        if (cb) cb.checked = false;
        row.classList.remove('bg-[#fef9f0]', 'border-l-4', 'border-l-[#7a1025]');
        row.classList.add('hover:bg-[#fffaf3]');
    }
    updateAll();
}

function batalSemua() {
    dipilih.clear();
    document.querySelectorAll('.siswa-checkbox').forEach(cb => { cb.checked = false; });
    document.querySelectorAll('.siswa-row').forEach(row => {
        row.classList.remove('bg-[#fef9f0]', 'border-l-4', 'border-l-[#7a1025]');
        row.classList.add('hover:bg-[#fffaf3]');
    });
    document.getElementById('selected-tags').innerHTML = '';
    updateAll();
}

// ── UPDATE UI ─────────────────────────────────────────────────────
function updateAll() {
    const n = dipilih.size;

    // Stats
    const statEl = document.getElementById('stat-dipilih');
    if (statEl) statEl.textContent = n;

    // Bar
    const barEl = document.getElementById('bar-count');
    if (barEl) barEl.textContent = n;

    // Panel selected
    const panel = document.getElementById('selected-panel');
    if (panel) {
        panel.classList.toggle('hidden', n === 0);
        const countEl = document.getElementById('selected-count');
        if (countEl) countEl.textContent = n;
    }

    // Buttons
    const btnPreview = document.getElementById('btn-preview');
    const btnSimpan  = document.getElementById('btn-simpan');
    if (btnPreview) btnPreview.disabled = n === 0;
    if (btnSimpan)  btnSimpan.disabled  = n === 0;

    // Hidden inputs for POST form
    const wrap = document.getElementById('hidden-siswa-ids');
    if (wrap) {
        wrap.innerHTML = '';
        dipilih.forEach(id => {
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'siswa_ids[]';
            inp.value = id;
            wrap.appendChild(inp);
        });
    }

    // Step indicator (JS fallback)
    const s2num   = document.querySelector('.step2-num');
    const s2label = document.querySelector('.step2-label');
    const s3num   = document.querySelector('.step3-num');
    const s3label = document.querySelector('.step3-label');
    if (s2num) {
        if (n > 0) {
            s2num.innerHTML   = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
            s2num.className   = s2num.className.replace(/border-\S+|bg-\S+|text-\S+/g, '').trim()
                + ' border-2 border-green-500 bg-green-500 text-white';
            s2label.className = s2label.className.replace(/text-\S+/g, '').trim() + ' text-green-600';
            s3num.className   = s3num.className.replace(/border-\S+|bg-\S+|text-\S+/g, '').trim()
                + ' border-2 border-[#7a1025] bg-[#7a1025] text-white';
            s3label.className = s3label.className.replace(/text-\S+/g, '').trim() + ' text-[#7a1025]';
        } else {
            s2num.innerHTML   = '2';
            s2num.className   = s2num.className.replace(/border-\S+|bg-\S+|text-\S+/g, '').trim()
                + ' border-2 border-[#7a1025] bg-[#7a1025] text-white';
            s2label.className = s2label.className.replace(/text-\S+/g, '').trim() + ' text-[#7a1025]';
            s3num.className   = s3num.className.replace(/border-\S+|bg-\S+|text-\S+/g, '').trim()
                + ' border-2 border-[#e8d9c0] bg-white text-[#9b8a84]';
            s3label.className = s3label.className.replace(/text-\S+/g, '').trim() + ' text-[#9b8a84]';
        }
    }
}

// ── PREVIEW MODAL ─────────────────────────────────────────────────
function bukaPreview() {
    const modal = document.getElementById('modal-preview');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const chosen = siswaDataJs.filter(s => dipilih.has(s.id));
    const wrap   = document.getElementById('preview-table-wrap');
    const meta   = document.getElementById('preview-meta');

    if (!chosen.length) {
        wrap.innerHTML = '<p class="text-[#9b8a84] text-sm text-center py-6">Tidak ada siswa dipilih.</p>';
        return;
    }

    const hadirClass = h => h >= 70
        ? 'bg-green-50 text-green-700'
        : (h >= 40 ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700');

    const rows = chosen.map((s, i) => `
        <tr class="border-t border-[#f5ede0]">
            <td class="px-4 py-2.5 text-[#9b8a84] text-xs">${i + 1}</td>
            <td class="px-4 py-2.5 font-semibold text-[#1a0b0f] text-sm">${s.nama}</td>
            <td class="px-4 py-2.5">
                <span class="bg-[#fff0d6] text-[#7a4f00] text-xs font-bold px-2 py-0.5 rounded-full">${s.kat}</span>
            </td>
            <td class="px-4 py-2.5 text-[#4b3a36] text-sm">${s.jk ?? '—'}</td>
            <td class="px-4 py-2.5">
                <span class="text-xs font-bold px-2 py-0.5 rounded-full ${hadirClass(s.hadir)}">${s.hadir}%</span>
            </td>
            <td class="px-4 py-2.5 text-[#4b3a36] text-sm">${s.hp}</td>
            <td class="px-4 py-2.5">
                <span class="bg-green-50 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full">Terpilih</span>
            </td>
        </tr>`).join('');

    wrap.innerHTML = `
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-[#fdf6ec]">
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">#</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">Nama Siswa</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">Kategori</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">Jenis Kelamin</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">Kehadiran</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">No. HP</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-xs uppercase tracking-wide font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>`;

    const now = new Date().toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' });
    meta.textContent = `Dicetak: ${now} · Total ${chosen.length} peserta`;
}

function tutupPreview() {
    const modal = document.getElementById('modal-preview');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('modal-preview')?.addEventListener('click', function (e) {
    if (e.target === this) tutupPreview();
});

// ── INIT ──────────────────────────────────────────────────────────
updateAll();

@if(session('clear_selection'))
dipilih.clear();

document.querySelectorAll('.siswa-checkbox').forEach(cb => {
    cb.checked = false;
});

const hiddenWrap = document.getElementById('hidden-siswa-ids');
if(hiddenWrap){
    hiddenWrap.innerHTML = '';
}

document.getElementById('selected-tags').innerHTML = '';

updateAll();
@endif

</script>
@endpush