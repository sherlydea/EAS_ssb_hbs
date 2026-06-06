<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya - SSB HBS</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    <?php echo $__env->make('siswa.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php
        $siswa = \DB::table('siswas')
            ->where('user_id', auth()->user()->id)
            ->first();

        $namaSiswa = $siswa->nama ?? auth()->user()->name ?? 'Siswa';
        $kategori = $siswa->kategori_latihan ?? '-';

        $totalLatihan = $riwayatAbsensi->count();
        $totalHadir = $riwayatAbsensi->where('status', 'Hadir')->count();
        $totalIzin = $riwayatAbsensi->where('status', 'Izin')->count();
        $totalAlpa = $riwayatAbsensi->where('status', 'Alpa')->count();

        $persentaseHadir = $totalLatihan > 0
            ? round(($totalHadir / $totalLatihan) * 100)
            : 0;

        function badgeAbsensiClass($status) {
            return match ($status) {
                'Hadir' => 'bg-green-500/15 text-green-400',
                'Izin' => 'bg-yellow-500/15 text-yellow-300',
                'Alpa' => 'bg-red-500/15 text-red-400',
                default => 'bg-white/10 text-white/60',
            };
        }
    ?>

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Absensi Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Riwayat Kehadiran
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Riwayat absensi latihan siswa. Data absensi dicatat oleh pelatih atau admin.
                </p>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-6">
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Nama Siswa</p>
                    <h2 class="text-xl font-black"><?php echo e($namaSiswa); ?></h2>
                    <p class="text-[#d4af37] font-bold mt-2"><?php echo e($kategori); ?></p>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Total Latihan</p>
                    <h2 class="text-4xl font-black text-[#d4af37]"><?php echo e($totalLatihan); ?></h2>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Jumlah Hadir</p>
                    <h2 class="text-4xl font-black text-green-400"><?php echo e($totalHadir); ?></h2>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-6 shadow-2xl">
                    <p class="text-white/45 text-sm mb-2">Persentase Hadir</p>
                    <h2 class="text-4xl font-black text-[#d4af37]"><?php echo e($persentaseHadir); ?>%</h2>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="mb-6">
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Daftar Absensi
                        </p>

                        <h2 class="text-2xl font-black">
                            Riwayat Latihan
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[750px] text-left">
                            <thead>
                                <tr class="border-b border-white/10 text-white/60">
                                    <th class="py-4 px-4">Tanggal</th>
                                    <th class="py-4 px-4">Jadwal Latihan</th>
                                    <th class="py-4 px-4">Status</th>
                                    <th class="py-4 px-4">Keterangan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                <?php $__empty_1 = true; $__currentLoopData = $riwayatAbsensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-[#1a0608] transition">
                                        <td class="py-4 px-4 font-bold">
                                            <?php echo e($item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-'); ?>

                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            <?php if(isset($item->jadwal_latihan_id) && $item->jadwal_latihan_id): ?>
                                                Jadwal #<?php echo e($item->jadwal_latihan_id); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <td class="py-4 px-4">
                                            <span class="<?php echo e(badgeAbsensiClass($item->status)); ?> px-3 py-1.5 rounded-full text-xs font-bold">
                                                <?php echo e($item->status); ?>

                                            </span>
                                        </td>

                                        <td class="py-4 px-4 text-white/70">
                                            <?php echo e($item->keterangan ?? '-'); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-8 px-4 text-center text-white/50">
                                            Belum ada data absensi.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Ringkasan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Status Kehadiran
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Hadir</p>
                            <p class="text-green-400 text-2xl font-black"><?php echo e($totalHadir); ?>x</p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Izin</p>
                            <p class="text-yellow-300 text-2xl font-black"><?php echo e($totalIzin); ?>x</p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Alpa</p>
                            <p class="text-red-400 text-2xl font-black"><?php echo e($totalAlpa); ?>x</p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="font-bold mb-1">Catatan</p>
                            <p class="text-white/55 text-sm leading-relaxed">
                                Siswa hanya dapat melihat riwayat absensi. Pengisian absensi dilakukan oleh pelatih atau admin.
                            </p>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/siswa/riwayat-absensi.blade.php ENDPATH**/ ?>