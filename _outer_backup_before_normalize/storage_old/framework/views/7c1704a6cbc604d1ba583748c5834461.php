<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPP Saya - SSB HBS</title>

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

        function badgeSppClass($status) {
            return match ($status) {
                'Lunas' => 'bg-green-500/15 text-green-400',
                'Menunggu Verifikasi' => 'bg-yellow-500/15 text-yellow-300',
                'Ditolak' => 'bg-red-500/15 text-red-400',
                default => 'bg-white/10 text-white/60',
            };
        }
    ?>

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-6xl mx-auto">

            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    SPP Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Tagihan & Riwayat SPP
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Lihat tagihan SPP aktif, upload bukti pembayaran, dan pantau riwayat pembayaran SPP.
                </p>
            </section>

            <?php if(session('success')): ?>
                <div class="bg-green-500/15 border border-green-500/30 text-green-300 p-4 rounded-2xl mb-6">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="bg-red-500/15 border border-red-500/30 text-red-300 p-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-5 mb-7">
                        <div>
                            <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                                Tagihan Aktif
                            </p>

                            <h2 class="text-3xl font-black">
                                SPP Bulanan
                            </h2>

                            <p class="text-white/55 mt-2">
                                Tagihan terbaru yang perlu dibayar atau diverifikasi.
                            </p>
                        </div>

                        <?php if($tagihanAktif): ?>
                            <span class="w-fit <?php echo e(badgeSppClass($tagihanAktif->status)); ?> px-4 py-2 rounded-full text-sm font-bold">
                                <?php echo e($tagihanAktif->status); ?>

                            </span>
                        <?php else: ?>
                            <span class="w-fit bg-green-500/15 text-green-400 px-4 py-2 rounded-full text-sm font-bold">
                                Tidak Ada Tagihan
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($tagihanAktif): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                                <p class="text-white/45 text-sm mb-1">Nama Siswa</p>
                                <p class="font-bold"><?php echo e($namaSiswa); ?></p>
                            </div>

                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                                <p class="text-white/45 text-sm mb-1">Kategori</p>
                                <p class="font-bold text-[#d4af37]"><?php echo e($kategori); ?></p>
                            </div>

                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                                <p class="text-white/45 text-sm mb-1">Periode</p>
                                <p class="font-bold">
                                    <?php echo e($tagihanAktif->bulan); ?> <?php echo e($tagihanAktif->tahun); ?>

                                </p>
                            </div>

                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                                <p class="text-white/45 text-sm mb-1">Nominal Tagihan</p>
                                <p class="text-3xl font-black">
                                    Rp<?php echo e(number_format($tagihanAktif->nominal, 0, ',', '.')); ?>

                                </p>
                            </div>

                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                                <p class="text-white/45 text-sm mb-1">Tanggal Bayar / Upload</p>
                                <p class="font-bold">
                                    <?php echo e($tagihanAktif->tanggal_bayar ? \Carbon\Carbon::parse($tagihanAktif->tanggal_bayar)->format('d M Y H:i') : '-'); ?>

                                </p>
                            </div>

                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                                <p class="text-white/45 text-sm mb-1">Bukti Pembayaran</p>

                                <?php if($tagihanAktif->bukti_pembayaran): ?>
                                    <a
                                        href="<?php echo e(asset('uploads/bukti_pembayaran/' . $tagihanAktif->bukti_pembayaran)); ?>"
                                        target="_blank"
                                        class="text-[#d4af37] font-bold hover:underline"
                                    >
                                        Lihat Bukti
                                    </a>
                                <?php else: ?>
                                    <p class="font-bold">Belum upload</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if(in_array($tagihanAktif->status, ['Belum Bayar', 'Ditolak'])): ?>
                            <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5 mb-6">
                                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                                    Upload Bukti Pembayaran
                                </p>

                                <form action="<?php echo e(route('siswa.pembayaran.upload')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" name="tagihan_spp_id" value="<?php echo e($tagihanAktif->id); ?>">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                        <div class="md:col-span-2">
                                            <label class="block text-white/60 text-sm mb-2">
                                                Pilih file bukti transfer
                                            </label>

                                            <input
                                                type="file"
                                                name="bukti_pembayaran"
                                                class="w-full bg-[#140506] border border-[#4e1218] rounded-xl p-3 text-white file:bg-[#d4af37] file:text-[#120608] file:border-0 file:px-4 file:py-2 file:rounded-lg file:font-bold"
                                                required
                                            >
                                        </div>

                                        <button
                                            type="submit"
                                            class="w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition"
                                        >
                                            Upload Bukti
                                        </button>
                                    </div>
                                </form>

                                <p class="text-white/45 text-sm mt-4 leading-relaxed">
                                    Setelah bukti pembayaran dikirim, status akan menjadi
                                    <span class="text-yellow-300 font-bold">Menunggu Verifikasi</span>
                                    sampai admin melakukan pengecekan.
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-2xl p-5 mb-6">
                                <p class="text-yellow-300 font-bold mb-2">
                                    Informasi Status
                                </p>

                                <p class="text-white/60 text-sm leading-relaxed">
                                    Tagihan ini sedang menunggu verifikasi admin atau sudah dinyatakan lunas.
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-2xl p-5">
                            <p class="text-yellow-300 font-bold mb-2">
                                Catatan SPP
                            </p>

                            <p class="text-white/60 text-sm leading-relaxed">
                                Tagihan SPP dibuat oleh admin setiap bulan. Siswa hanya perlu upload bukti pembayaran dan menunggu verifikasi admin.
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-6">
                            <p class="text-white/70 font-bold mb-2">
                                Belum ada tagihan aktif.
                            </p>

                            <p class="text-white/45 text-sm leading-relaxed">
                                Tagihan SPP akan muncul setelah admin membuat tagihan untuk akun siswa ini.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-3">
                        Ringkasan
                    </p>

                    <h2 class="text-2xl font-black mb-5">
                        Status SPP
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Nama Siswa</p>
                            <p class="font-bold"><?php echo e($namaSiswa); ?></p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Kategori</p>
                            <p class="font-bold text-[#d4af37]"><?php echo e($kategori); ?></p>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Tagihan Aktif</p>

                            <?php if($tagihanAktif): ?>
                                <p class="font-bold">
                                    <?php echo e($tagihanAktif->bulan); ?> <?php echo e($tagihanAktif->tahun); ?>

                                </p>
                            <?php else: ?>
                                <p class="font-bold">Tidak ada</p>
                            <?php endif; ?>
                        </div>

                        <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1">Status</p>

                            <?php if($tagihanAktif): ?>
                                <p class="font-bold <?php echo e($tagihanAktif->status === 'Lunas' ? 'text-green-400' : ($tagihanAktif->status === 'Ditolak' ? 'text-red-400' : 'text-yellow-300')); ?>">
                                    <?php echo e($tagihanAktif->status); ?>

                                </p>
                            <?php else: ?>
                                <p class="text-green-400 font-bold">Aman</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </section>

            <section class="mt-6 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                            Riwayat SPP
                        </p>

                        <h2 class="text-2xl font-black">
                            Riwayat Tagihan dan Pembayaran
                        </h2>
                    </div>

                    <span class="w-fit bg-[#d4af37]/15 text-[#d4af37] px-4 py-2 rounded-full text-sm font-bold">
                        <?php echo e($riwayatSpp->count()); ?> Data
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left">
                        <thead>
                            <tr class="border-b border-white/10 text-white/60">
                                <th class="py-4 px-4">Periode</th>
                                <th class="py-4 px-4">Nominal</th>
                                <th class="py-4 px-4">Tanggal Bayar</th>
                                <th class="py-4 px-4">Bukti</th>
                                <th class="py-4 px-4">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            <?php $__empty_1 = true; $__currentLoopData = $riwayatSpp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-[#1a0608] transition">
                                    <td class="py-4 px-4 font-bold">
                                        <?php echo e($item->bulan); ?> <?php echo e($item->tahun); ?>

                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        Rp<?php echo e(number_format($item->nominal, 0, ',', '.')); ?>

                                    </td>

                                    <td class="py-4 px-4 text-white/70">
                                        <?php echo e($item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y H:i') : '-'); ?>

                                    </td>

                                    <td class="py-4 px-4">
                                        <?php if($item->bukti_pembayaran): ?>
                                            <a
                                                href="<?php echo e(asset('uploads/bukti_pembayaran/' . $item->bukti_pembayaran)); ?>"
                                                target="_blank"
                                                class="text-[#d4af37] font-bold hover:underline"
                                            >
                                                Lihat Bukti
                                            </a>
                                        <?php else: ?>
                                            <span class="text-white/45">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="py-4 px-4">
                                        <span class="<?php echo e(badgeSppClass($item->status)); ?> px-3 py-1.5 rounded-full text-xs font-bold">
                                            <?php echo e($item->status); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="py-8 px-4 text-center text-white/50">
                                        Belum ada riwayat SPP.
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
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/siswa/pembayaran.blade.php ENDPATH**/ ?>