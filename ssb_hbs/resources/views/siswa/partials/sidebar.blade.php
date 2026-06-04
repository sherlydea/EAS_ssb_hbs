<!-- TOPBAR SISWA -->
<header class="fixed top-0 left-0 w-full z-50 bg-[#080203]/90 backdrop-blur-xl border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <a href="{{ url('/siswa/dashboard') }}" class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl border border-[#d4af37]/60 flex items-center justify-center text-[#d4af37] font-black">
                HBS
            </div>

            <div>
                <h1 class="text-xl font-black leading-none text-white">
                    SSB <span class="text-[#d4af37]">HBS</span>
                </h1>
                <p class="text-xs text-white/45 mt-1">Portal Siswa</p>
            </div>
        </a>

        <!-- GARIS TIGA KANAN ATAS -->
        <button
            type="button"
            onclick="toggleSiswaMenu()"
            class="w-12 h-12 rounded-2xl bg-[#140506] border border-[#4e1218] flex flex-col items-center justify-center gap-1.5 hover:border-[#d4af37]/60 transition"
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
    class="hidden fixed inset-0 bg-black/70 z-40"
></div>

<!-- MENU SLIDE DARI KANAN -->
<aside
    id="siswaMenu"
    class="fixed top-0 right-0 h-screen w-[340px] max-w-[90%] bg-[#0f0304] border-l border-[#4e1218] z-50 translate-x-full transition-transform duration-300"
>
    <div class="p-6 border-b border-white/10 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-white">Menu Siswa</h2>
            <p class="text-white/45 text-sm mt-1">Akses fitur portal siswa</p>
        </div>

        <button
            type="button"
            onclick="toggleSiswaMenu()"
            class="text-[#d4af37] text-3xl leading-none"
        >
            &times;
        </button>
    </div>

    <nav class="p-5 space-y-3 pb-28">
        <a href="{{ url('/siswa/dashboard') }}" class="menu-siswa-link">Dashboard</a>
        <a href="{{ url('/siswa/profil') }}" class="menu-siswa-link">Profil Saya</a>
        <a href="{{ url('/siswa/jadwal-latihan') }}" class="menu-siswa-link">Latihan Saya</a>
        <a href="{{ url('/siswa/jadwal-turnamen') }}" class="menu-siswa-link">Turnamen Saya</a>
        <a href="{{ url('/siswa/pembayaran') }}" class="menu-siswa-link">Pembayaran Saya</a>
        <a href="{{ url('/siswa/jersey') }}" class="menu-siswa-link">Jersey Saya</a>
        <a href="{{ url('/siswa/riwayat-absensi') }}" class="menu-siswa-link">Absensi Saya</a>
    </nav>

    <div class="absolute bottom-0 left-0 w-full p-5 border-t border-white/10 bg-[#0f0304]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="w-full bg-[#d4af37] text-[#120608] py-4 rounded-2xl font-bold hover:bg-[#e6c04a] transition"
            >
                Logout
            </button>
        </form>
    </div>
</aside>

<style>
    .menu-siswa-link {
        display: block;
        background: #140506;
        border: 1px solid #4e1218;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        color: rgba(255,255,255,.75);
        font-weight: 600;
        transition: .25s;
    }

    .menu-siswa-link:hover {
        border-color: rgba(212,175,55,.6);
        color: #d4af37;
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