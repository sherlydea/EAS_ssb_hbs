<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Turnamen Saya - SSB HBS</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    <?php echo $__env->make('siswa.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="pt-28 px-6 py-10 min-h-screen">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Turnamen Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Informasi Turnamen Aktif
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Lihat turnamen yang kamu ikuti, status pembayaran, dan upload bukti pembayaran.
                </p>
            </section>

            <section class="grid grid-cols-1 gap-6">

                <?php $__empty_1 = true; $__currentLoopData = $turnamens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turnamen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                            <div>
                                <p class="text-[#d4af37] text-sm font-bold tracking-widest uppercase mb-2">
                                    <?php echo e($turnamen->nama_turnamen); ?>

                                </p>
                                <h3 class="font-bold text-xl"><?php echo e($turnamen->nama_turnamen); ?></h3>
                                <p class="text-white/55 text-sm mt-1">
                                    Tanggal: <?php echo e(\Carbon\Carbon::parse($turnamen->tanggal)->format('d F Y')); ?>

                                </p>
                                <p class="text-white/55 text-sm mt-1">
                                    Biaya: Rp<?php echo e(number_format($turnamen->biaya,0,',','.')); ?>

                                </p>
                                <p class="text-white/55 text-sm mt-1">
                                    Status: 
                                    <?php if($turnamen->status_pembayaran == 'Menunggu'): ?>
                                        <span class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-full font-bold">Menunggu Konfirmasi</span>
                                    <?php elseif($turnamen->status_pembayaran == 'Lunas'): ?>
                                        <span class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full font-bold">Terdaftar</span>
                                    <?php else: ?>
                                        <span class="bg-gray-500/20 text-gray-300 px-3 py-1 rounded-full font-bold">Belum Bayar</span>
                                    <?php endif; ?>
                                </p>
                            </div>

                            <div class="flex flex-col gap-2 mt-4 md:mt-0">
                                <?php if($turnamen->status_pembayaran == 'Belum Bayar' || $turnamen->status_pembayaran == 'Menunggu'): ?>
                                    <form action="<?php echo e(route('siswa.turnamen.upload', $turnamen->id)); ?>" method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <input type="file" name="bukti_pembayaran" class="text-sm mb-2 text-black" required>
                                        <button type="submit" class="bg-[#d4af37] text-[#120608] px-5 py-2 rounded-xl font-bold hover:bg-[#e6c04a] transition">
                                            Upload Bukti
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="<?php echo e(asset('uploads/bukti_turnamen/'.$turnamen->bukti_pembayaran)); ?>" target="_blank"
                                       class="bg-[#1a0608] border border-[#d4af37] px-5 py-2 rounded-xl font-bold hover:bg-[#d4af37] hover:text-[#120608] transition text-center">
                                        Lihat Bukti
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl text-center">
                        <p class="text-white/60">
                            Belum ada turnamen yang terdaftar. Silakan hubungi pelatih untuk informasi lebih lanjut.
                        </p>
                    </div>
                <?php endif; ?>

            </section>

            <!-- Riwayat Turnamen -->
            <section class="mt-12">
                <h2 class="text-[#d4af37] text-2xl font-bold mb-4">Riwayat Turnamen</h2>
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <table class="w-full border border-white/10">
                        <thead class="bg-[#1a0608]">
                            <tr>
                                <th class="border p-3 text-left text-white/75">Turnamen</th>
                                <th class="border p-3 text-left text-white/75">Tanggal</th>
                                <th class="border p-3 text-left text-white/75">Biaya</th>
                                <th class="border p-3 text-left text-white/75">Status</th>
                                <th class="border p-3 text-left text-white/75">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="border p-3"><?php echo e($item->nama_turnamen); ?></td>
                                    <td class="border p-3"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d F Y')); ?></td>
                                    <td class="border p-3">Rp<?php echo e(number_format($item->biaya,0,',','.')); ?></td>
                                    <td class="border p-3"><?php echo e($item->status_pembayaran); ?></td>
                                    <td class="border p-3">
                                        <?php if($item->bukti_pembayaran): ?>
                                            <a href="<?php echo e(asset('uploads/bukti_turnamen/'.$item->bukti_pembayaran)); ?>" target="_blank" class="text-yellow-300 font-bold hover:underline">
                                                Lihat
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="border p-3 text-center text-white/60">
                                        Belum ada riwayat turnamen.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>
</body>
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/siswa/jadwal-turnamen.blade.php ENDPATH**/ ?>