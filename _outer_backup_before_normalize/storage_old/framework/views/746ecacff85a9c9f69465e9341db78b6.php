<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - SSB HBS</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-[#080203] text-white min-h-screen overflow-x-hidden">

    <?php echo $__env->make('siswa.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="pt-28 min-h-screen px-6 py-10">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <section class="mb-10">
                <p class="text-[#d4af37] font-bold tracking-widest uppercase mb-3">
                    Profil Saya
                </p>

                <h1 class="text-4xl md:text-5xl font-black leading-tight">
                    Data Siswa
                </h1>

                <p class="text-white/60 mt-3 max-w-2xl">
                    Informasi data diri siswa yang tersimpan pada sistem SSB HBS.
                </p>
            </section>

            <!-- Profil Card -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Avatar & Nama -->
                <div class="bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <div class="w-36 h-36 mx-auto rounded-3xl bg-[#0f0304] border border-[#4e1218] flex items-center justify-center mb-6">
                        <span class="text-[#d4af37] text-4xl font-black">
                            <?php echo e(strtoupper(substr($siswa->nama ?? auth()->user()->name ?? 'S', 0, 1))); ?>

                        </span>
                    </div>

                    <h2 class="text-2xl font-black text-center">
                        <?php echo e($siswa->nama ?? auth()->user()->name ?? '-'); ?>

                    </h2>

                    <p class="text-[#d4af37] text-center font-bold mt-2">
                        <?php echo e($siswa->kategori_latihan ?? '-'); ?>

                    </p>

                    <div class="mt-6 bg-[#0f0304] border border-white/10 rounded-2xl p-5 text-center">
                        <p class="text-white/50 text-sm">Status Siswa</p>
                        <p class="text-green-400 font-bold mt-1">Aktif</p>
                    </div>
                </div>

                <!-- Informasi Pribadi -->
                <div class="lg:col-span-2 bg-[#140506] border border-[#4e1218] rounded-3xl p-7 shadow-2xl">
                    <p class="text-[#d4af37] font-bold tracking-widest uppercase text-sm mb-6">
                        Informasi Pribadi
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <?php
                        $fields = [
                            ['label'=>'Nama Lengkap', 'value'=>$siswa->nama ?? auth()->user()->name ?? '-'],
                            ['label'=>'Email', 'value'=>auth()->user()->email ?? '-'],
                            ['label'=>'Tempat Lahir', 'value'=>$siswa->tempat_lahir ?? '-'],
                            ['label'=>'Tanggal Lahir', 'value'=>$siswa->tanggal_lahir ?? '-'],
                            ['label'=>'Jenis Kelamin', 'value'=>$siswa->jenis_kelamin ?? '-'],
                            ['label'=>'Kategori Latihan', 'value'=>$siswa->kategori_latihan ?? '-', 'highlight'=>true],
                            ['label'=>'Nomor HP / WhatsApp', 'value'=>$siswa->no_hp ?? '-'],
                            ['label'=>'Nama Orang Tua / Wali', 'value'=>$siswa->nama_orang_tua ?? '-'],
                            ['label'=>'Alamat', 'value'=>$siswa->alamat ?? '-', 'colspan'=>2],
                        ];
                        ?>

                        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="<?php echo e($field['colspan'] ?? '' ? 'md:col-span-2' : ''); ?> bg-[#0f0304] border border-white/10 rounded-2xl p-5">
                            <p class="text-white/45 text-sm mb-1"><?php echo e($field['label']); ?></p>
                            <p class="font-bold <?php echo e($field['highlight'] ?? false ? 'text-[#d4af37]' : ''); ?> leading-relaxed">
                                <?php echo e($field['value']); ?>

                            </p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/siswa/profil.blade.php ENDPATH**/ ?>