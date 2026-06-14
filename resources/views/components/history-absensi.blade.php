@props(['absensis'])

<section class="bg-white border rounded-2xl p-5">

    <h3 class="font-bold mb-3">Riwayat Absensi</h3>

    <table class="w-full text-sm">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($absensis as $a)
            <tr>
                <td>{{ $a->siswa->nama }}</td>
                <td>{{ $a->status }}</td>
                <td>{{ $a->tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</section>