<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - SSB HBS</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        html, body{
            min-height:100%;
            overflow-y:auto;
        }

        .glass-card{
            background:linear-gradient(
                145deg,
                rgba(26,6,8,.95),
                rgba(12,3,5,.95)
            );
            border:1px solid rgba(212,175,55,.15);
            box-shadow:0 20px 60px rgba(0,0,0,.45);
        }
    </style>
</head>

<body class="bg-[#080203] min-h-screen flex items-center justify-center px-4 relative overflow-hidden">

    <div class="absolute top-20 left-20 w-72 h-72 bg-[#8d001f]/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-20 right-20 w-72 h-72 bg-[#d4af37]/10 blur-3xl rounded-full"></div>

    <div class="relative z-10 w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-5xl font-black text-white">
                SSB <span class="text-[#d4af37]">HBS</span>
            </h1>

            <p class="text-white/50 mt-2">
                Sistem Informasi Sekolah Sepak Bola
            </p>
        </div>

        <div class="glass-card rounded-3xl p-8">

            <h2 class="text-3xl font-bold text-[#d4af37] text-center mb-2">
                Login
            </h2>

            <p class="text-white/50 text-center mb-6">
                Masuk ke akun siswa, pelatih, atau admin
            </p>

            <?php if(session('error')): ?>
                <div class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl mb-4">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-xl mb-4">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login.process')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                  <label class="block mb-2 font-medium text-white/80">
    Username
</label>

<input
    type="text"
    name="username"
    value="<?php echo e(old('username', request()->cookie('remember_username'))); ?>"
    class="w-full bg-[#0f0304] border border-[#4e1218] p-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-[#d4af37]/20 focus:border-[#d4af37]"
    placeholder="Masukkan username"
    required
                        class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white focus:border-[#d4af37] focus:ring-2 focus:ring-[#d4af37]/20 outline-none"
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-white/80 font-medium">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Masukkan password"
                        required
                        class="w-full bg-[#0f0304] border border-[#4e1218] rounded-xl p-3 text-white focus:border-[#d4af37] focus:ring-2 focus:ring-[#d4af37]/20 outline-none"
                    >
                </div>

                <div class="flex items-center justify-between mb-5">
                    <label class="flex items-center text-white/70">
                        <input type="checkbox" name="remember" class="mr-2">
                        Remember Me
                    </label>

                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="text-[#d4af37] text-sm hover:underline"
                    >
                        Lihat Password
                    </button>
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#d4af37] text-[#120608] py-3 rounded-xl font-bold hover:bg-[#e6c04a] transition"
                >
                    Login
                </button>
            </form>

            <p class="text-center mt-6 text-white/60">
                Belum punya akun?
                <a href="<?php echo e(route('pendaftaran.create')); ?>" class="text-[#d4af37] font-semibold hover:underline">
                    Daftar
                </a>
            </p>

            <div class="text-center mt-4">
                <a href="<?php echo e(route('home')); ?>" class="text-white/40 hover:text-[#d4af37] text-sm">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

<script>
function togglePassword(){
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html><?php /**PATH C:\Users\Asus\Documents\EAS_PEMWEB\ssb_hbs\resources\views/auth/login.blade.php ENDPATH**/ ?>