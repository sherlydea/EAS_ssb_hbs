<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Saya - SSB HBS</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    <?php echo $__env->make('siswa.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php
        $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
        $kategori = $siswa->kategori_latihan ?? '-';
        $totalJadwal = $riwayatLatihan->count();
    ?>

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Latihan Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Jadwal Latihan
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Jadwal latihan yang ditampilkan sesuai kategori latihan siswa.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Nama Siswa</p>
                    <h2 class="text-xl font-black"><?php echo e($namaSiswa); ?></h2>
                    <p class="text-[#d4af37] font-bold mt-2"><?php echo e($kategori); ?></p>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Total Jadwal</p>
                    <h2 class="text-4xl font-black text-[#d4af37]"><?php echo e($totalJadwal); ?></h2>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Status</p>
                    <h2 class="text-2xl font-black text-green-400">Aktif</h2>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="mb-6">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Daftar Jadwal
                        </p>

                        <h2 class="text-2xl font-black">
                            Jadwal Latihan Kategori <?php echo e($kategori); ?>

                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[750px] text-left">
                            <thead>
                                <tr class="border-b border-white/10 text-white/60">
                                    <th class="py-4 px-4">Hari</th>
                                    <th class="py-4 px-4">Jam</th>
                                    <th class="py-4 px-4">Kategori</th>
                                    <th class="py-4 px-4">Lokasi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                <?php $__empty_1 = true; $__currentLoopData = $riwayatLatihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-[#1a0608] transition">
                                        <td class="py-4 px-4 font-bold text-[#d4af37]">
                                            <?php echo e($item->hari ?? '-'); ?>

                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            <?php echo e($item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-'); ?>

                                            -
                                            <?php echo e($item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-'); ?>

                                            WIB
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            <?php echo e($item->kategori_latihan ?? '-'); ?>

                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            <?php echo e($item->lokasi ?? '-'); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-8 px-4 text-center text-white/50">
                                            Belum ada jadwal latihan untuk kategori ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Informasi
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Catatan Latihan
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Sesuai Kategori</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Jadwal ditampilkan berdasarkan kategori latihan siswa yang sedang login.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Absensi</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Kehadiran latihan dicatat oleh pelatih atau admin melalui menu absensi.
                            </p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Perubahan Jadwal</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Jika ada perubahan jadwal, siswa akan mengikuti jadwal terbaru dari pelatih/admin.
                            </p>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/siswa/jadwal-latihan.blade.php ENDPATH**/ ?>