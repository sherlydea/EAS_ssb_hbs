<div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 z-40" onclick="toggleSidebar()"></div>

<aside id="sidebar" class="fixed top-0 right-0 h-full w-72 bg-red-700 text-white shadow-lg z-50 transform translate-x-full transition-transform duration-300">
    <div class="p-6 h-full relative">
        <div class="flex justify-between items-center mb-6 border-b border-red-300 pb-4">
            <h2 class="text-2xl font-bold">Menu Siswa</h2>
            <button onclick="toggleSidebar()" class="text-2xl font-bold">&times;</button>
        </div>

        <nav class="space-y-3">
            <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-3 rounded hover:bg-red-800">Dashboard</a>
            <a href="{{ route('siswa.profil') }}" class="block px-4 py-3 rounded hover:bg-red-800">Profil Siswa</a>
            <a href="{{ route('siswa.jadwal-latihan') }}" class="block px-4 py-3 rounded hover:bg-red-800">Jadwal Latihan</a>
            <a href="{{ route('siswa.jadwal-turnamen') }}" class="block px-4 py-3 rounded hover:bg-red-800">Turnamen</a>
            <a href="{{ route('siswa.pembayaran') }}" class="block px-4 py-3 rounded hover:bg-red-800">Tagihan SPP</a>
            <a href="{{ route('siswa.jersey') }}" class="block px-4 py-3 rounded hover:bg-red-800">Jersey</a>
            <a href="{{ route('siswa.riwayat-absensi') }}" class="block px-4 py-3 rounded hover:bg-red-800">Riwayat Absensi</a>
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="absolute bottom-6 left-6 right-6">
            @csrf
            <button type="submit" class="w-full bg-white text-red-700 px-4 py-3 rounded font-semibold">
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebar.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>