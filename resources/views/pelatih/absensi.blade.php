@extends('pelatih.layouts.pelatih')

@section('title', 'Absensi Siswa')

@push('styles')
<style>
    /* ── Day card ── */
    .day-card { transition: box-shadow .15s, transform .15s; }
    .day-card:hover { box-shadow: 0 4px 18px rgba(122,16,37,.10); transform: translateY(-1px); }
    .day-card.is-today { border-color: #7a1025 !important; }
    .day-card.is-today .day-label { background: #7a1025; color: #fff; }
    .day-card.has-schedule { cursor: default; }
    .day-card.no-schedule { opacity: .55; }

    /* ── Status pill toggle ── */
    .pill { transition: background .1s, color .1s, border-color .1s; cursor: pointer; user-select: none; }
    .pill.active-hadir  { background:#dcfce7; color:#15803d; border-color:#16a34a; font-weight:700; }
    .pill.active-izin   { background:#fef9c3; color:#854d0e; border-color:#ca8a04; font-weight:700; }
    .pill.active-alpa   { background:#fee2e2; color:#b91c1c; border-color:#dc2626; font-weight:700; }
    .pill.default       { background:#fff; color:#6f5a55; border-color:#e8d9c0; }

    /* ── tambahkan setelah baris .pill.default { ... } ── */

    /* Pastikan pill default punya border visible */
    .pill.default {
        background: #fff;
        color: #6f5a55;
        border-color: #e8d9c0;
    }

    var baseClass = 'pill border-2 rounded-lg px-2.5 py-1 text-[.65rem] font-semibold min-w-[52px] transition-all';
if (st === status) {
    var activeClass = st === 'Hadir' ? 'active-hadir' : (st === 'Izin' ? 'active-izin' : 'active-alpa');
    pill.className = baseClass + ' ' + activeClass;
    // Force style langsung sebagai fallback
    var colors = {
        'Hadir': { bg:'#dcfce7', color:'#15803d', border:'#16a34a', shadow:'#bbf7d0' },
        'Izin':  { bg:'#fef9c3', color:'#854d0e', border:'#ca8a04', shadow:'#fef08a' },
        'Alpa':  { bg:'#fee2e2', color:'#b91c1c', border:'#dc2626', shadow:'#fecaca' },
    };
    pill.style.background  = colors[st].bg;
    pill.style.color       = colors[st].color;
    pill.style.borderColor = colors[st].border;
    pill.style.boxShadow   = '0 0 0 2px ' + colors[st].shadow;
    pill.style.fontWeight  = '700';
} else {
    pill.className = baseClass + ' default';
    pill.style.background  = '#fff';
    pill.style.color       = '#6f5a55';
    pill.style.borderColor = '#e8d9c0';
    pill.style.boxShadow   = 'none';
    pill.style.fontWeight  = '600';
}

    /* ── Siswa row ── */
    .siswa-row { transition: background .1s; }
    .siswa-row:hover { background: #fffaf3; }
    .siswa-row.done-hadir { background: #f0fdf4; }
    .siswa-row.done-izin  { background: #fefce8; }
    .siswa-row.done-alpa  { background: #fff5f5; }

    /* ── Progress bar ── */
    #progressBar { transition: width .3s ease; }

    /* ── Modal slide-up ── */
    #attendanceModal .modal-panel {
        transform: translateY(40px);
        opacity: 0;
        transition: transform .22s cubic-bezier(.4,0,.2,1), opacity .22s;
    }
    #attendanceModal.open .modal-panel {
        transform: translateY(0);
        opacity: 1;
    }

    /* ── History mini-table ── */
    .history-row { border-top: 1px solid #f5ede0; }
    .history-row:hover { background: #fffaf3; }
</style>
@endpush

@section('content')

{{-- ════════════════════════════ HEADER ════════════════════════════ --}}
<section class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <p class="text-[#7a1025] font-bold text-xs uppercase tracking-widest mb-1">Portal Pelatih</p>
        <h1 class="text-2xl font-black text-[#1a0b0f] mb-1">Absensi Latihan</h1>
        <p class="text-[#4b3a36] text-sm">
            Pilih jadwal latihan lalu mulai absensi — <span class="font-semibold text-[#7a1025]">{{ $today }}</span>
        </p>
    </div>
   
</section>

{{-- ════════════════════════════ FLASH ════════════════════════════ --}}
@if(session('success'))
<div id="flashMsg" class="bg-green-50 border border-green-300 rounded-xl px-4 py-3 mb-5 flex items-center gap-2.5">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
    </svg>
    <span class="text-green-700 text-sm font-semibold">{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-700 text-lg leading-none bg-transparent border-none cursor-pointer">×</button>
</div>
@endif

@if(session('error'))
<div id="flashErr" class="bg-red-50 border border-red-300 rounded-xl px-4 py-3 mb-5 flex items-center gap-2.5">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <span class="text-red-600 text-sm font-semibold">{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-700 text-lg leading-none bg-transparent border-none cursor-pointer">×</button>
</div>
@endif

{{-- ════════════════════════════ WEEKLY SCHEDULE GRID ════════════════════════════ --}}
<section class="mb-6">
    <h2 class="text-xs font-bold text-[#6f5a55] uppercase tracking-widest mb-3">Jadwal Mingguan</h2>

    <div class="grid grid-cols-7 gap-2">
        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
        @php
            $jadwalsHari = $jadwalPerHari[$hari] ?? collect();
            $isToday     = $todayHari === $hari;
        @endphp
        <div class="flex flex-col gap-2">
            {{-- Day label --}}
            @php
    $hariIndex = ['Senin'=>0,'Selasa'=>1,'Rabu'=>2,'Kamis'=>3,'Jumat'=>4,'Sabtu'=>5,'Minggu'=>6];
    $startOfWeek = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);
    $tglHari = $startOfWeek->copy()->addDays($hariIndex[$hari]);
@endphp
<div class="day-label rounded-lg py-1.5 px-2 text-center text-[.68rem] font-black uppercase tracking-wide
    {{ $isToday ? 'bg-[#7a1025] text-white' : 'bg-[#f5ede0] text-[#6f5a55]' }}">
    {{ substr($hari, 0, 3) }}
    <span class="block text-[.6rem] font-semibold tracking-normal normal-case mt-0.5
        {{ $isToday ? 'opacity-80' : 'opacity-70' }}">
        {{ $tglHari->format('d M') }}
    </span>
</div>

            @if($jadwalsHari->isEmpty())
            {{-- No schedule --}}
            <div class="day-card no-schedule bg-white border border-[#ede3d5] rounded-xl px-3 py-4 text-center min-h-[80px] flex flex-col items-center justify-center gap-1">
                <svg class="w-4 h-4 opacity-30" fill="none" stroke="#7a1025" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span class="text-[.65rem] text-[#c4b4a8]">Tidak ada</span>
            </div>
            @else
            {{-- Schedule cards for this day --}}
            @foreach($jadwalsHari as $jadwal)
            @php
                $doneCount  = $absensiCountPerJadwal[$jadwal->id] ?? 0;
                $totalSiswa = $siswaCountPerKategori[$jadwal->kategori_latihan] ?? 0;
                $pct        = $totalSiswa > 0 ? round(($doneCount/$totalSiswa)*100) : 0;
                $isDone     = $doneCount >= $totalSiswa && $totalSiswa > 0;
            @endphp
            <div class="day-card has-schedule bg-white border-2 {{ $isToday ? 'is-today border-[#7a1025]' : 'border-[#e8d9c0]' }} rounded-xl px-3 py-3 flex flex-col gap-2">
                <div>
                    <p class="text-[.72rem] font-black text-[#1a0b0f] leading-snug">
                        {{ substr($jadwal->jam_mulai,0,5) }} – {{ substr($jadwal->jam_selesai,0,5) }}
                    </p>
                    <span class="inline-block bg-[#fff0d6] text-[#7a1025] text-[.6rem] font-bold px-1.5 py-0.5 rounded mt-0.5">
                        {{ $jadwal->kategori_latihan }}
                    </span>
                    @if($jadwal->lokasi)
                    <p class="text-[.62rem] text-[#9b8a84] mt-0.5 truncate">{{ $jadwal->lokasi }}</p>
                    @endif
                </div>

                {{-- Mini progress --}}
                @if($totalSiswa > 0)
                <div>
                    <div class="flex justify-between text-[.6rem] text-[#9b8a84] mb-1">
                        <span>{{ $doneCount }}/{{ $totalSiswa }}</span>
                        <span>{{ $pct }}%</span>
                    </div>
                    <div class="h-1 bg-[#f5ede0] rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $isDone ? 'bg-green-500' : 'bg-[#7a1025]' }}"
                            style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                @endif

                <button type="button"
                    onclick="openModal({{ $jadwal->id }}, '{{ addslashes($hari) }}', '{{ substr($jadwal->jam_mulai,0,5) }}–{{ substr($jadwal->jam_selesai,0,5) }}', '{{ addslashes($jadwal->kategori_latihan) }}')"
                    class="w-full rounded-lg py-1.5 text-[.7rem] font-bold text-center transition-colors cursor-pointer
                        {{ $isDone
                            ? 'bg-green-100 text-green-700 border border-green-300 hover:bg-green-200'
                            : ($isToday
                                ? 'bg-[#7a1025] text-white hover:bg-[#600018]'
                                : 'bg-[#fff0d6] text-[#7a1025] border border-[#f0d9a8] hover:bg-[#fde9b5]')
                        }}">
                    {{ $isDone ? '✓ Selesai' : 'Mulai Absensi' }}
                </button>
            </div>
            @endforeach
            @endif
        </div>
        @endforeach
    </div>
</section>

{{-- ════════════════════════════ RIWAYAT SINGKAT ════════════════════════════ --}}
<section class="bg-white border border-[#e8d9c0] rounded-2xl shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-[#f0e6d3]">
        <div class="flex items-center gap-3">
            <h3 class="font-black text-sm text-[#1a0b0f]">Riwayat Absensi</h3>
            <span class="bg-[#fdf6ec] text-[#9b8a84] text-[.68rem] font-semibold px-2 py-0.5 rounded-full border border-[#e8d9c0]">
                {{ $absensis->total() }} catatan
            </span>
        </div>
        {{-- Search --}}
        <form method="GET" action="{{ route('pelatih.absensi.index') }}" class="flex items-center gap-2">
            <div class="relative">
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3 h-3" fill="none" stroke="#9b8a84" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama…"
                    class="border border-[#e8d9c0] rounded-xl py-1.5 pl-7 pr-3 text-xs w-40 text-[#1a0b0f] bg-white focus:outline-none focus:border-[#7a1025]">
            </div>
            <button type="submit" class="bg-[#7a1025] hover:bg-[#600018] text-white rounded-xl px-3 py-1.5 text-xs font-semibold cursor-pointer transition-colors">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs border-collapse">
            <thead>
                <tr class="bg-[#fdf6ec]">
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-[.65rem] uppercase tracking-wider font-semibold">Siswa</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-[.65rem] uppercase tracking-wider font-semibold">Jadwal</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-[.65rem] uppercase tracking-wider font-semibold">Tanggal</th>
                    <th class="px-4 py-2.5 text-center text-[#6f5a55] text-[.65rem] uppercase tracking-wider font-semibold">Status</th>
                    <th class="px-4 py-2.5 text-left text-[#6f5a55] text-[.65rem] uppercase tracking-wider font-semibold">Keterangan</th>
                    <th class="px-4 py-2.5 text-center text-[#6f5a55] text-[.65rem] uppercase tracking-wider font-semibold">Ubah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $idx => $absen)
                @php
                    $fotoUrl = ($absen->siswa && $absen->siswa->foto_siswa)
                        ? asset('storage/'.$absen->siswa->foto_siswa)
                        : null;
                @endphp
                <tr class="history-row hover:bg-[#fffaf3] transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-2">
                            @if($fotoUrl)
                                <img src="{{ $fotoUrl }}" class="w-7 h-7 rounded-full object-cover border border-[#e8d9c0] shrink-0" alt="">
                            @else
                                <div class="w-7 h-7 rounded-full bg-[#f3ebe0] flex items-center justify-center text-[.68rem] font-black text-[#7a1025] shrink-0">
                                    {{ strtoupper(substr($absen->siswa->nama ?? '-', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-[#1a0b0f] text-xs leading-snug">{{ $absen->siswa->nama ?? '-' }}</p>
                                <p class="text-[.65rem] text-[#9b8a84]">{{ $absen->siswa->kategori_latihan ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-semibold text-[#1a0b0f] text-xs">{{ $absen->jadwal->hari ?? '-' }}</p>
                        <p class="text-[.65rem] text-[#9b8a84]">
                            {{ $absen->jadwal ? substr($absen->jadwal->jam_mulai,0,5).'–'.substr($absen->jadwal->jam_selesai,0,5) : '-' }}
                        </p>
                    </td>
                    <td class="px-4 py-2.5 text-xs text-[#4b3a36]">
                        {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        @if($absen->status === 'Hadir')
                            <span class="bg-green-100 text-green-700 text-[.65rem] font-bold px-2 py-0.5 rounded-full">Hadir</span>
                        @elseif($absen->status === 'Izin')
                            <span class="bg-yellow-50 text-yellow-800 text-[.65rem] font-bold px-2 py-0.5 rounded-full border border-yellow-200">Izin</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-[.65rem] font-bold px-2 py-0.5 rounded-full">Alpa</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5 text-xs text-[#6f5a55]">{{ $absen->keterangan ?: '—' }}</td>
                    <td class="px-4 py-2.5 text-center">
                        <button type="button"
                            onclick="openEditModal({{ $absen->id }}, '{{ addslashes($absen->siswa->nama ?? '') }}', '{{ $absen->status }}', '{{ addslashes($absen->keterangan ?? '') }}')"
                            class="inline-flex items-center gap-1 border border-[#e8d9c0] hover:bg-[#fff0d6] rounded-lg px-2.5 py-1 text-[.68rem] font-semibold text-[#4b3a36] bg-white cursor-pointer transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Ubah
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center">
                        <p class="text-[#9b8a84] text-sm">Belum ada riwayat absensi.</p>
                        <p class="text-[#c4b4a8] text-xs mt-1">Mulai absensi dari jadwal di atas.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($absensis->total() > 0)
    <div class="px-5 py-3 border-t border-[#f0e6d3] flex items-center justify-between flex-wrap gap-2">
        <p class="text-[#9b8a84] text-xs">
            {{ $absensis->firstItem() }}–{{ $absensis->lastItem() }} dari {{ $absensis->total() }} data
        </p>
        <div class="text-xs">{{ $absensis->appends(request()->query())->links() }}</div>
    </div>
    @endif
</section>

{{-- ════════════════════════════ ATTENDANCE MODAL ════════════════════════════ --}}
<div id="attendanceModal"
    class="fixed inset-0 bg-black/50 z-50 hidden items-end sm:items-center justify-center p-0 sm:p-4"
    role="dialog" aria-modal="true">

    <div class="modal-panel bg-white w-full sm:max-w-lg sm:rounded-2xl rounded-t-2xl shadow-2xl overflow-hidden flex flex-col max-h-[92dvh]">

        {{-- Modal Header --}}
        <div class="flex items-start justify-between px-5 py-4 border-b border-[#f0e6d3] shrink-0">
            <div>
                <h3 class="font-black text-base text-[#1a0b0f]" id="modalTitle">Mulai Absensi</h3>
                <p class="text-xs text-[#6f5a55] mt-0.5" id="modalSubtitle"></p>
            </div>
            <button type="button" onclick="closeModal()"
                class="text-[#9b8a84] hover:text-[#1a0b0f] bg-[#f5ede0] hover:bg-[#e8d9c0] border-none cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-lg transition-colors shrink-0 mt-0.5">
                ✕
            </button>
        </div>

        {{-- Live Summary Bar --}}
        <div class="px-5 pt-3 pb-2 bg-[#fdf6ec] border-b border-[#f0e6d3] shrink-0">
            <div class="flex items-center gap-4 text-xs mb-2">
                <span class="flex items-center gap-1.5 font-bold text-green-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span>
                    <span id="cntHadir">0</span> Hadir
                </span>
                <span class="flex items-center gap-1.5 font-bold text-yellow-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 inline-block"></span>
                    <span id="cntIzin">0</span> Izin
                </span>
                <span class="flex items-center gap-1.5 font-bold text-red-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                    <span id="cntAlpa">0</span> Alpa
                </span>
                <span class="ml-auto text-[#9b8a84]"><span id="cntDone">0</span>/<span id="cntTotal">0</span></span>
            </div>
            <div class="h-1.5 bg-[#e8d9c0] rounded-full overflow-hidden">
                <div id="progressBar" class="h-full bg-[#7a1025] rounded-full" style="width:0%"></div>
            </div>
        </div>

        {{-- Siswa List --}}
        <div class="overflow-y-auto flex-1" id="siswaListContainer">
            <table class="w-full text-xs border-collapse" id="siswaTable">
                <tbody id="siswaBody">
                    {{-- injected by JS --}}
                </tbody>
            </table>
        </div>

        {{-- Actions --}}
        <div class="px-5 py-3.5 border-t border-[#f0e6d3] flex gap-2.5 shrink-0 bg-white">
            <button type="button" onclick="markAll('Hadir')"
                class="flex-1 bg-green-100 hover:bg-green-200 text-green-700 rounded-xl py-2 text-xs font-bold cursor-pointer transition-colors border border-green-200">
                Semua Hadir
            </button>
            <button type="button" id="saveBtn" onclick="saveAttendance()"
                class="flex-1 bg-[#7a1025] hover:bg-[#600018] text-white rounded-xl py-2 text-xs font-bold cursor-pointer transition-colors">
                Simpan Absensi
            </button>
        </div>
    </div>
</div>

{{-- ════════════════════════════ EDIT SINGLE ABSENSI MODAL ════════════════════════════ --}}
<div id="editModal"
    class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4"
    role="dialog">
    <div class="bg-white rounded-2xl max-w-[380px] w-full shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-[#f0e6d3]">
            <h3 class="font-black text-sm text-[#1a0b0f]">Ubah Absensi</h3>
            <button type="button" onclick="closeEditModal()"
                class="text-[#9b8a84] hover:text-[#1a0b0f] w-7 h-7 flex items-center justify-center rounded-full bg-[#f5ede0] border-none cursor-pointer text-lg">×</button>
        </div>
        <div class="px-5 py-4">
            <p id="editSiswaName" class="text-xs text-[#6f5a55] font-semibold mb-4 pb-3 border-b border-[#f0e6d3]"></p>
            <form method="POST" id="formEdit">
                @csrf @method('PUT')
                <input type="hidden" name="absensi_id" id="editAbsensiId">
                <div class="mb-4">
                    <label class="text-[.7rem] font-bold text-[#6f5a55] block mb-2">Status</label>
                    <div class="flex gap-2">
                        @foreach(['Hadir','Izin','Alpa'] as $st)
                        <label class="flex-1 text-center cursor-pointer">
                            <input type="radio" name="status" value="{{ $st }}" id="edit_{{ $st }}"
                                class="hidden" onchange="updateEditStyle()">
                            <span id="editSpan{{ $st }}"
                                class="block border-2 border-[#e8d9c0] rounded-xl py-2 text-xs font-bold text-[#6f5a55] transition-all select-none">
                                {{ $st }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="mb-4">
                    <label class="text-[.7rem] font-bold text-[#6f5a55] block mb-2">Keterangan</label>
                    <input type="text" name="keterangan" id="editKeterangan" placeholder="Opsional…"
                        class="w-full border border-[#e8d9c0] rounded-xl py-2 px-3 text-xs text-[#1a0b0f] focus:outline-none focus:border-[#7a1025]">
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 border border-[#e8d9c0] hover:bg-[#fdf6ec] rounded-xl py-2 text-xs font-semibold text-[#4b3a36] bg-white cursor-pointer transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-[#7a1025] hover:bg-[#600018] text-white rounded-xl py-2 text-xs font-bold cursor-pointer transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ─── DATA FROM BLADE ─────────────────────────────────────────────────────────
var _siswaData   = @json($siswaPerJadwal);   // { jadwal_id: [{id, nama, foto, status_hari_ini, keterangan}] }
var _statusMap   = {};    // siswa_id -> status yang akan disimpan
var _activeJadwalId = null;

// ─── OPEN ATTENDANCE MODAL ───────────────────────────────────────────────────
function openModal(jadwalId, hari, jam, kategori) {
    _activeJadwalId = jadwalId;
    _statusMap = {};

    document.getElementById('modalTitle').textContent   = hari + ' · ' + jam;
    document.getElementById('modalSubtitle').textContent = kategori;

    var siswas = _siswaData[jadwalId] || [];
    // Pre-fill existing absensi hari ini
    siswas.forEach(function(s) {
        if (s.status_hari_ini) _statusMap[s.id] = s.status_hari_ini;
    });

    renderSiswaList(siswas);
    updateProgress(siswas.length);

    var modal = document.getElementById('attendanceModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(function() { modal.classList.add('open'); }, 10);
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    var modal = document.getElementById('attendanceModal');
    modal.classList.remove('open');
    setTimeout(function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }, 230);
}

// ─── RENDER SISWA LIST ────────────────────────────────────────────────────────
function renderSiswaList(siswas) {
    var tbody = document.getElementById('siswaBody');
    tbody.innerHTML = '';

    if (siswas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2" class="px-4 py-8 text-center text-[#9b8a84] text-xs">Tidak ada siswa untuk jadwal ini.</td></tr>';
        return;
    }

    siswas.forEach(function(s) {
        var currentStatus = _statusMap[s.id] || null;
        var rowClass = currentStatus === 'Hadir' ? 'done-hadir' : (currentStatus === 'Izin' ? 'done-izin' : (currentStatus === 'Alpa' ? 'done-alpa' : ''));
        var initial  = s.nama.charAt(0).toUpperCase();
        var foto     = s.foto
            ? '<img src="' + s.foto + '" class="w-9 h-9 rounded-full object-cover border-2 border-[#e8d9c0] shrink-0" alt="">'
            : '<div class="w-9 h-9 rounded-full bg-[#f3ebe0] flex items-center justify-center text-sm font-black text-[#7a1025] shrink-0">' + initial + '</div>';

        var pills = ['Hadir','Izin','Alpa'].map(function(st) {
        var active = currentStatus === st;
        var cls = active
            ? (st === 'Hadir' ? 'active-hadir' : st === 'Izin' ? 'active-izin' : 'active-alpa')
            : 'default';
        return '<button type="button" data-status="' + st + '" onclick="setStatus(' + s.id + ',\'' + st + '\')"'
            + ' class="pill ' + cls + ' border-2 rounded-lg px-2.5 py-1 text-[.65rem] font-semibold min-w-[52px] transition-all">'
            + st + '</button>';
          }).join('');

        var tr = document.createElement('tr');
        tr.id  = 'siswa-row-' + s.id;
        tr.className = 'siswa-row ' + rowClass + ' border-t border-[#f5ede0]';
        tr.innerHTML =
            '<td class="px-4 py-2.5">'
                + '<div class="flex items-center gap-2.5">' + foto
                + '<div>'
                    + '<p class="font-bold text-[#1a0b0f] text-xs leading-snug">' + s.nama + '</p>'
                    + (s.nama_ortu ? '<p class="text-[.6rem] text-[#9b8a84]">' + s.nama_ortu + '</p>' : '')
                + '</div></div>'
            + '</td>'
            + '<td class="px-4 py-2.5">'
                + '<div class="flex items-center gap-1.5 justify-end">' + pills + '</div>'
            + '</td>';
        tbody.appendChild(tr);
    });
}

// ─── SET STATUS ───────────────────────────────────────────────────────────────
function setStatus(siswaId, status) {
    _statusMap[siswaId] = status;

    var siswas = _siswaData[_activeJadwalId] || [];
    var total  = siswas.length;

    var rowEl = document.getElementById('siswa-row-' + siswaId);
    if (rowEl) {
        var pills = rowEl.querySelectorAll('.pill');
        pills.forEach(function(pill) {
            var st = pill.getAttribute('data-status');
            var baseClass = 'pill border-2 rounded-lg px-2.5 py-1 text-[.65rem] font-semibold min-w-[52px] transition-all';
if (st === status) {
    var activeClass = st === 'Hadir' ? 'active-hadir' : (st === 'Izin' ? 'active-izin' : 'active-alpa');
    pill.className = baseClass + ' ' + activeClass;
    // Force style langsung sebagai fallback
    var colors = {
        'Hadir': { bg:'#dcfce7', color:'#15803d', border:'#16a34a', shadow:'#bbf7d0' },
        'Izin':  { bg:'#fef9c3', color:'#854d0e', border:'#ca8a04', shadow:'#fef08a' },
        'Alpa':  { bg:'#fee2e2', color:'#b91c1c', border:'#dc2626', shadow:'#fecaca' },
    };
    pill.style.background  = colors[st].bg;
    pill.style.color       = colors[st].color;
    pill.style.borderColor = colors[st].border;
    pill.style.boxShadow   = '0 0 0 2px ' + colors[st].shadow;
    pill.style.fontWeight  = '700';
} else {
    pill.className = baseClass + ' default';
    pill.style.background  = '#fff';
    pill.style.color       = '#6f5a55';
    pill.style.borderColor = '#e8d9c0';
    pill.style.boxShadow   = 'none';
    pill.style.fontWeight  = '600';
}
        });

        rowEl.classList.remove('done-hadir','done-izin','done-alpa');
        rowEl.classList.add(status === 'Hadir' ? 'done-hadir' : status === 'Izin' ? 'done-izin' : 'done-alpa');
    }

    updateProgress(total);
}

// ─── MARK ALL ────────────────────────────────────────────────────────────────
function markAll(status) {
    var siswas = _siswaData[_activeJadwalId] || [];
    siswas.forEach(function(s) { setStatus(s.id, status); });
}

// ─── PROGRESS ─────────────────────────────────────────────────────────────────
function updateProgress(total) {
    var hadir = 0, izin = 0, alpa = 0, done = 0;
    Object.values(_statusMap).forEach(function(st) {
        if (st === 'Hadir') hadir++;
        else if (st === 'Izin') izin++;
        else if (st === 'Alpa') alpa++;
        done++;
    });
    document.getElementById('cntHadir').textContent = hadir;
    document.getElementById('cntIzin').textContent  = izin;
    document.getElementById('cntAlpa').textContent  = alpa;
    document.getElementById('cntDone').textContent  = done;
    document.getElementById('cntTotal').textContent = total;
    var pct = total > 0 ? Math.round((done / total) * 100) : 0;
    document.getElementById('progressBar').style.width = pct + '%';
    document.getElementById('progressBar').style.background = pct === 100 ? '#16a34a' : '#7a1025';
}

// ─── SAVE ATTENDANCE ──────────────────────────────────────────────────────────
function saveAttendance() {
    var entries = Object.entries(_statusMap);
    if (entries.length === 0) {
        alert('Belum ada status yang dipilih.');
        return;
    }

    var btn = document.getElementById('saveBtn');
    btn.textContent = 'Menyimpan…';
    btn.disabled = true;

    // Submit each as a fetch POST
    var promises = entries.map(function(entry) {
        var siswaId = entry[0], status = entry[1];
        var fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        fd.append('siswa_id', siswaId);
        fd.append('jadwal_latihan_id', _activeJadwalId);
        fd.append('status', status);
        return fetch('{{ route('pelatih.absensi.simpan') }}', { method: 'POST', body: fd });
    });

    Promise.all(promises).then(function() {
        closeModal();
        // Reload to reflect updated state
        window.location.reload();
    }).catch(function() {
        btn.textContent = 'Simpan Absensi';
        btn.disabled = false;
        alert('Terjadi kesalahan. Coba lagi.');
    });
}

// ─── EDIT SINGLE MODAL ───────────────────────────────────────────────────────
var _editColors = {
    Hadir: { border:'#16a34a', bg:'#f0fdf4', color:'#15803d' },
    Izin : { border:'#ca8a04', bg:'#fefce8', color:'#854d0e' },
    Alpa : { border:'#dc2626', bg:'#fee2e2', color:'#b91c1c' },
};

function openEditModal(id, nama, status, keterangan) {
    document.getElementById('editAbsensiId').value   = id;
    document.getElementById('editSiswaName').textContent = 'Siswa: ' + nama;
    document.getElementById('editKeterangan').value  = keterangan || '';
    document.getElementById('formEdit').action = '/pelatih/absensi/' + id;

    var r = document.getElementById('edit_' + status);
    if (r) r.checked = true;
    updateEditStyle();

    var modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
    document.body.style.overflow = '';
}

function updateEditStyle() {
    ['Hadir','Izin','Alpa'].forEach(function(s) {
        var r = document.getElementById('edit_' + s);
        var sp = document.getElementById('editSpan' + s);
        if (!r || !sp) return;
        if (r.checked) {
            sp.style.borderColor = _editColors[s].border;
            sp.style.background  = _editColors[s].bg;
            sp.style.color       = _editColors[s].color;
        } else {
            sp.style.borderColor = '#e8d9c0';
            sp.style.background  = '#fff';
            sp.style.color       = '#6f5a55';
        }
    });
}

// ─── BACKDROP / ESC ──────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    ['attendanceModal','editModal'].forEach(function(id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('click', function(e) {
            if (e.target === this) {
                id === 'attendanceModal' ? closeModal() : closeEditModal();
            }
        });
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeModal(); closeEditModal(); }
    });
});
</script>
@endpush