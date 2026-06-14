@props(['siswas','absenMap','selectedJadwal','today'])

@if($selectedJadwal && $siswas->count() > 0)

<section class="bg-white border-2 border-[#7a1025] rounded-2xl px-6 py-5 mb-6">

    <h3 class="font-bold text-[#7a1025] mb-4">Input Absensi</h3>

    <form method="POST" action="{{ route('pelatih.absensi.simpan') }}">
        @csrf
        <input type="hidden" name="jadwal_latihan_id" value="{{ $selectedJadwal->id }}">

        @foreach($siswas as $siswa)

            @php
                $absen = $absenMap[$siswa->id] ?? null;
            @endphp

            <div class="flex justify-between border p-3 rounded-lg mb-2">
                <div>
                    <p class="font-semibold">{{ $siswa->nama }}</p>
                </div>

                <div class="flex gap-3 text-sm">

                    <label>
                        <input type="radio" name="status[{{ $siswa->id }}]" value="Hadir"
                        {{ ($absen->status ?? '') == 'Hadir' ? 'checked' : '' }}>
                        Hadir
                    </label>

                    <label>
                        <input type="radio" name="status[{{ $siswa->id }}]" value="Izin"
                        {{ ($absen->status ?? '') == 'Izin' ? 'checked' : '' }}>
                        Izin
                    </label>

                    <label>
                        <input type="radio" name="status[{{ $siswa->id }}]" value="Alpa"
                        {{ ($absen->status ?? '') == 'Alpa' ? 'checked' : '' }}>
                        Alpa
                    </label>

                </div>
            </div>

        @endforeach

        <button class="bg-[#7a1025] text-white px-4 py-2 rounded-xl mt-3">
            Simpan
        </button>

    </form>

</section>

@endif