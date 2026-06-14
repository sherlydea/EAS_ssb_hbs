<header class="fixed top-0 left-0 w-full z-50 bg-[#1a0b0f]/95 backdrop-blur-xl border-b border-[#7a1025]/30 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('pelatih.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/loho-hbs.png') }}" alt="Logo HBS" class="w-12 h-14">
            <div>
                <h1 class="text-xl font-black text-white">SSB <span class="text-[#d4af37]">HBS</span></h1>
                <p class="text-xs text-white/45 mt-1">Portal Pelatih</p>
            </div>
        </a>
        <button type="button" onclick="togglePelatihMenu()"
            class="w-12 h-12 rounded-2xl bg-[#7a1025] border border-[#d4af37]/30 flex flex-col items-center justify-center gap-1.5 hover:bg-[#600018] hover:border-[#d4af37]/70 transition shadow-md">
            <span class="w-5 h-0.5 bg-[#d4af37] rounded-full"></span>
            <span class="w-5 h-0.5 bg-[#d4af37] rounded-full"></span>
            <span class="w-5 h-0.5 bg-[#d4af37] rounded-full"></span>
        </button>
    </div>
</header>

<div id="pelatihOverlay" onclick="togglePelatihMenu()" class="hidden fixed inset-0 bg-[#1a0b0f]/70 backdrop-blur-sm z-40"></div>

<aside id="pelatihMenu"
       class="fixed top-0 right-0 h-screen w-[340px] max-w-[95%] bg-[#fff8e7] border-l border-[#7a1025]/25 z-50 translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
    <div class="p-6 border-b border-[#7a1025]/20 flex items-center justify-between bg-[#1a0b0f] flex-shrink-0">
        <div>
            <h2 class="text-2xl font-black text-[#fff8e7]">Menu Pelatih</h2>
            <p class="text-[#fff8e7]/55 text-sm mt-1">Akses fitur portal pelatih</p>
        </div>
        <button type="button" onclick="togglePelatihMenu()" class="text-[#d4af37] text-3xl leading-none hover:text-[#fff8e7] transition">&times;</button>
    </div>

    <nav class="p-5 space-y-3 flex-1 overflow-y-auto blueprint-scroll">
        <a href="{{ route('pelatih.dashboard') }}" class="menu-pelatih-link">Dashboard</a>
        <a href="{{ route('pelatih.siswa.index') }}" class="menu-pelatih-link">Seleksi Turnamen</a>
        <a href="{{ route('pelatih.absensi.index') }}" class="menu-pelatih-link">Absensi</a>
        <a href="{{ route('pelatih.report.index') }}" class="menu-pelatih-link">Report</a>
    </nav>

    <div class="p-5 border-t border-[#7a1025]/20 bg-[#fff8e7] flex-shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-[#7a1025] text-white py-4 rounded-2xl font-bold hover:bg-[#600018] transition shadow-md">Logout</button>
        </form>
    </div>
</aside>

<script>
function togglePelatihMenu() {
    const menu = document.getElementById('pelatihMenu');
    const overlay = document.getElementById('pelatihOverlay');
    menu.classList.toggle('translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>

<style>
.menu-pelatih-link {
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
.menu-pelatih-link:hover {
    background: #7a1025;
    border-color: #600018;
    color: #fff8e7;
    transform: translateX(-4px);
}
.blueprint-scroll::-webkit-scrollbar {
    width: 4px;
}
.blueprint-scroll::-webkit-scrollbar-track { background: transparent; }
.blueprint-scroll::-webkit-scrollbar-thumb { background: rgba(122,16,37,0.15); border-radius: 10px; }
</style>