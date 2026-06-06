<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jersey Saya - SSB HBS</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

<?php echo $__env->make('siswa.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main class="pt-28 min-h-screen px-6 py-10">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <section class="mb-10">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                Jersey Saya
            </p>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">
                Pemesanan Jersey
            </h1>
            <p class="text-white/60 mt-3 max-w-2xl">
                Pilih tipe jersey, ukuran, nama punggung, dan nomor punggung sesuai kebutuhan siswa.
            </p>
            <?php if(session('error')): ?>
                <div class="bg-red-500/15 text-red-300 border border-red-500/30 p-4 rounded-2xl mt-3">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
        </section>

        <!-- Daftar Jersey & Informasi Transfer -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Daftar Jersey -->
            <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                    Pilihan Jersey SSB HBS
                </p>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[500px] text-left">
                        <thead>
                            <tr class="border-b border-white/10 text-white/60">
                                <th class="py-3 px-4">Tipe Jersey</th>
                                <th class="py-3 px-4">Harga</th>
                                <th class="py-3 px-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            <?php $__currentLoopData = $jerseys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jersey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-[#1a0608] transition">
                                <td class="py-3 px-4 font-bold text-[#d4af37]"><?php echo e($jersey->tipe_jersey); ?></td>
                                <td class="py-3 px-4 text-white/70">Rp<?php echo e(number_format($jersey->harga,0,',','.')); ?></td>
                                <td class="py-3 px-4 text-white/70"><?php echo e($jersey->keterangan); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Transfer -->
            <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                    Informasi Transfer
                </p>
                <div class="space-y-4">
                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                        <p class="font-bold mb-1">Bank</p>
                        <p class="text-white/60">BCA</p>
                    </div>
                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                        <p class="font-bold mb-1">Nomor Rekening</p>
                        <p class="text-white/60">1234567890</p>
                    </div>
                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                        <p class="font-bold mb-1">Atas Nama</p>
                        <p class="text-white/60">SSB HBS</p>
                    </div>
                    <div class="bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                        <p class="font-bold mb-1">Keterangan Transfer</p>
                        <p class="text-white/60">Tulis keterangan: Jersey - Nama Siswa agar admin mudah mengecek pembayaran.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form Pesan Jersey -->
        <section class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl mb-10">
            <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-2">
                Form Pesan Jersey
            </p>
            <h2 class="text-2xl font-black mb-5">Lengkapi Data Pemesanan</h2>

            <form action="<?php echo e(route('siswa.jersey.pesan')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-white/70 font-semibold mb-2">Tipe Jersey</label>
                        <select name="tipe_jersey" required class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white">
                            <option value="">-- Pilih Tipe Jersey --</option>
                            <?php $__currentLoopData = $jerseys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jersey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($jersey->tipe_jersey); ?>"><?php echo e($jersey->tipe_jersey); ?> - Rp<?php echo e(number_format($jersey->harga,0,',','.')); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-white/70 font-semibold mb-2">Ukuran</label>
                        <select name="ukuran" required class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white">
                            <option value="">-- Pilih Ukuran --</option>
                            <?php $__currentLoopData = ['S','M','L','XL','XXL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($size); ?>"><?php echo e($size); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-white/70 font-semibold mb-2">Nama Punggung</label>
                        <input type="text" name="nama_punggung" placeholder="Contoh: SHERLY" class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white">
                    </div>
                    <div>
                        <label class="block text-white/70 font-semibold mb-2">Nomor Punggung</label>
                        <input type="number" name="nomor_punggung" placeholder="Contoh: 10" min="1" max="99" class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white">
                    </div>
                </div>
                <div class="mt-7">
                    <button type="submit" class="bg-[#d4af37] text-[#120608] px-8 py-3 rounded-xl font-bold hover:bg-[#e6c04a]">
                        Pesan Jersey
                    </button>
                </div>
            </form>
        </section>

        <!-- Riwayat Pesanan Jersey -->
        <section>
            <h2 class="text-2xl font-black mb-5 text-[#d4af37]">Riwayat Pesanan Jersey</h2>

            <div class="space-y-5">
                <?php $__empty_1 = true; $__currentLoopData = $pesananJerseys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-5 shadow-2xl">
                        <p><span class="font-bold">Tipe Jersey:</span> <?php echo e($pesanan->tipe_jersey); ?></p>
                        <p><span class="font-bold">Ukuran:</span> <?php echo e($pesanan->ukuran); ?></p>
                        <p><span class="font-bold">Nama & Nomor:</span> <?php echo e($pesanan->nama_punggung ?? '-'); ?> <?php echo e($pesanan->nomor_punggung ?? ''); ?></p>
                        <p><span class="font-bold">Harga:</span> Rp<?php echo e(number_format($pesanan->harga,0,',','.')); ?></p>
                        <p><span class="font-bold">Status:</span> <?php echo e($pesanan->status); ?></p>

                        <?php if($pesanan->status === 'Dikonfirmasi Admin'): ?>
                            <form action="<?php echo e(route('siswa.jersey.upload', $pesanan->id)); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                                <?php echo csrf_field(); ?>
                                <label class="block text-white/70 font-semibold mb-2">Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" required class="text-white/70">
                                <button type="submit" class="mt-2 bg-[#d4af37] text-[#120608] px-5 py-2 rounded-xl font-bold hover:bg-[#e6c04a]">
                                    Upload
                                </button>
                            </form>
                        <?php else: ?>
                            <p class="mt-2 text-yellow-400 text-sm">Menunggu konfirmasi admin sebelum upload bukti.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-white/60">Belum ada pesanan jersey.</p>
                <?php endif; ?>
            </div>
        </section>

    </div>
</main>

</body>
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/siswa/jersey.blade.php ENDPATH**/ ?>