<!-- TOPBAR SISWA -->
<header class="fixed top-0 left-0 w-full z-50 bg-[#1a0b0f]/95 backdrop-blur-xl border-b border-[#7a1025]/30 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO HBS -->
       <a href="{{ url('/siswa/dashboard') }}" class="flex items-center gap-3">
    <img src="{{ asset('images/loho-hbs.png') }}" alt="Logo HBS" class="w-12 h-14 ">
    <div>
        <h1 class="text-xl font-black leading-none text-white">
            SSB <span class="text-[#d4af37]">HBS</span>
        </h1>
        <p class="text-xs text-white/45 mt-1">Portal Siswa</p>
    </div>
</a>

        <!-- BUTTON MENU KANAN -->
        <button
            type="button"
            onclick="toggleSiswaMenu()"
            class="w-12 h-12 rounded-2xl bg-[#7a1025] border border-[#d4af37]/30 flex flex-col items-center justify-center gap-1.5 hover:bg-[#600018] hover:border-[#d4af37]/70 transition shadow-md"
        >
            <span class="w-5 h-0.5 bg-[#d4af37] rounded-full"></span>
            <span class="w-5 h-0.5 bg-[#d4af37] rounded-full"></span>
            <span class="w-5 h-0.5 bg-[#d4af37] rounded-full"></span>
        </button>
    </div>
</header>

<!-- OVERLAY -->
<div
    id="siswaOverlay"
    onclick="toggleSiswaMenu()"
    class="hidden fixed inset-0 bg-[#1a0b0f]/70 backdrop-blur-sm z-40"
></div>

<!-- MENU SLIDE DARI KANAN -->
<aside
    id="siswaMenu"
    class="fixed top-0 right-0 h-screen w-[340px] max-w-[90%] bg-[#fff8e7] border-l border-[#7a1025]/25 z-50 translate-x-full transition-transform duration-300 shadow-2xl"
>
    <div class="p-6 border-b border-[#7a1025]/20 flex items-center justify-between bg-[#1a0b0f]">
        <div>
            <h2 class="text-2xl font-black text-[#fff8e7]">Menu Siswa</h2>
            <p class="text-[#fff8e7]/55 text-sm mt-1">Akses fitur portal siswa</p>
        </div>

        <button
            type="button"
            onclick="toggleSiswaMenu()"
            class="text-[#d4af37] text-3xl leading-none hover:text-[#fff8e7] transition"
        >
            &times;
        </button>
    </div>

    <nav class="p-5 space-y-3 pb-28">
        <a href="{{ url('/siswa/dashboard') }}" class="menu-siswa-link">Dashboard</a>
        <a href="{{ url('/siswa/profil') }}" class="menu-siswa-link">Profil Saya</a>
        <a href="{{ url('/siswa/jadwal-latihan') }}" class="menu-siswa-link">Latihan Saya</a>
        <a href="{{ url('/siswa/jadwal-turnamen') }}" class="menu-siswa-link">Turnamen Saya</a>
        <a href="{{ url('/siswa/pembayaran') }}" class="menu-siswa-link">SPP Saya</a>
        <a href="{{ url('/siswa/jersey') }}" class="menu-siswa-link">Jersey Saya</a>
        <a href="{{ url('/siswa/riwayat-absensi') }}" class="menu-siswa-link">Absensi Saya</a>
    </nav>

    <div class="absolute bottom-0 left-0 w-full p-5 border-t border-[#7a1025]/20 bg-[#fff8e7]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="w-full bg-[#7a1025] text-white py-4 rounded-2xl font-bold hover:bg-[#600018] transition shadow-md"
            >
                Logout
            </button>
        </form>
    </div>
</aside>

<style>
    .menu-siswa-link {
        display: block;
        background: #fffaf0;
        border: 1px solid rgba(122, 16, 37, .22);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        color: #1a0b0f;
        font-weight: 700;
        transition: .25s;
        box-shadow: 0 8px 18px rgba(26, 11, 15, .06);
    }

    .menu-siswa-link:hover {
        background: #7a1025;
        border-color: #600018;
        color: #fff8e7;
        transform: translateX(-4px);
    }
</style>

<script>
    function toggleSiswaMenu() {
        const menu = document.getElementById('siswaMenu');
        const overlay = document.getElementById('siswaOverlay');

        menu.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>