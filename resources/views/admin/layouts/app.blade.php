<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SSB HBS</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#F5F1E8;
            color:#1f2937;
        }

        .topbar{
            background:#1a0b0f;
            color:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:16px 24px;
            border-bottom:1px solid rgba(122,16,37,.3);
            box-shadow:0 2px 10px rgba(0,0,0,.15);
        }

        .logo-section{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .logo-img{
            width:48px;
            height:56px;
            border-radius:0;
            object-fit:contain;
        }

        .logo-title{
            font-size:20px;
            font-weight:800;
            line-height:1;
            color:#ffffff;
        }

        .logo-title .logo-highlight{
            color:#d4af37;
        }

        .logo-sub{
            font-size:12px;
            color:rgba(255,255,255,.45);
            margin-top:4px;
        }

        .admin-info{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .avatar{
            width:40px;
            height:40px;
            border-radius:50%;
            background:#D4AF37;
        }

        .menu-toggle{
            width:48px;
            height:48px;
            border-radius:18px;
            background:#7a1025;
            border:1px solid rgba(212,175,55,.3);
            display:flex;
            align-items:center;
            justify-content:center;
            gap:6px;
            flex-direction:column;
            cursor:pointer;
            transition:.25s;
        }

        .menu-toggle:hover{
            background:#600018;
            border-color:rgba(212,175,55,.7);
        }

        .menu-toggle span{
            width:20px;
            height:2px;
            background:#d4af37;
            border-radius:999px;
            display:block;
        }

        .container{
            max-width:1400px;
            margin:auto;
            padding:40px;
        }

        /* ==========================
           FLASH MESSAGE STYLES
        ========================== */
        .flash-container {
            margin-bottom: 25px;
        }

        .flash-box {
            padding: 16px 20px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.3s ease;
        }

        .flash-success {
            background: #E8F5E9;
            color: #2E7D32;
            border-left: 5px solid #4CAF50;
        }

        .flash-error {
            background: #FFEBEE;
            color: #C62828;
            border-left: 5px solid #F44336;
        }

        .flash-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            padding-left: 15px;
            line-height: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ==========================
           OVERLAY
        ========================== */
        .overlay{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.4);
            opacity:0;
            visibility:hidden;
            transition:.3s;
            z-index:998;
        }

        .overlay.active{
            opacity:1;
            visibility:visible;
        }

        /* =========================
           SIDEBAR ADMIN
        ========================= */
        .sidebar{
            position:fixed;
            top:0;
            right:-340px;
            width:340px;
            height:100vh;
            background:#fff8e7;
            transition:.3s ease;
            z-index:9999;
            display:flex;
            flex-direction:column;
            box-shadow:-8px 0 20px rgba(0,0,0,.15);
        }

        .sidebar.active{
            right:0;
        }

        /* HEADER SIDEBAR */
        .sidebar-top{
            background:#1a0b0f;
            padding:24px;
        }

        .sidebar-title{
            font-size:22px;
            font-weight:700;
            color:white;
        }

        .sidebar-subtitle{
            margin-top:8px;
            color:rgba(255,255,255,.75);
            font-size:12px;
        }

        .close-btn{
            position:absolute;
            top:25px;
            right:25px;
            font-size:28px;
            color:#d4af37;
            cursor:pointer;
        }

        /* BODY SIDEBAR */
        .sidebar-menu{
            flex:1;
            padding:26px;
            overflow-y:auto;
        }

        .sidebar-menu a{
            display:flex;
            align-items:center;
            height:54px;
            padding:0 16px;
            text-decoration:none;
            color:#1a0b0f;
            background:#fffaf0;
            border:1px solid rgba(122,16,37,.22);
            border-radius:18px;
            font-size:14px;
            font-weight:600;
            margin-bottom:10px;
            transition:.25s;
        }

        /* HOVER */
        .sidebar-menu a:hover{
            background:#7a1025;
            border-color:#600018;
            color:#fff8e7;
            transform:translateX(-4px);
        }

        /* ACTIVE STATE INTERACTION */
        .sidebar-menu a.active{
            background:#7a1025;
            color:#fff8e7;
            border-color:#600018;
        }
        
        .sidebar-menu a.active:hover{
            background:#600018;
            border-color:#1a0b0f;
        }

        /* FOOTER */
        .sidebar-footer{
            padding:24px;
            border-top:1px solid rgba(122,16,37,.2);
            background:#fff8e7;
        }

        .logout-btn{
            width:100%;
            height:54px;
            border:none;
            border-radius:18px;
            background:#9b072a;
            color:white;
            font-size:14px;
            font-weight:700;
            cursor:pointer;
            transition:.25s;
        }

        .logout-btn:hover{
            background:#600018;
        }
    </style>
</head>
<body>

<div id="overlay" class="overlay"></div>

<div class="topbar">
    <div class="logo-section">
        <img src="{{ asset('images/loho-hbs.png') }}" alt="Logo HBS" class="logo-img" />
        <div>
            <div class="logo-title">SSB <span class="logo-highlight">HBS</span></div>
            <div class="logo-sub">PORTAL ADMIN</div>
        </div>
    </div>

    <div class="admin-info">
        <div>
            <div style="font-size:13px; font-weight:600;">Administrator</div>
            <div style="font-size:11px; opacity:0.7;">Super Admin Access</div>
        </div>
        <div class="avatar"></div>
        <button type="button" class="menu-toggle" id="menuToggleBtn">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</div>

<div id="sidebar" class="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-title">Menu Admin</div>
        <div class="sidebar-subtitle">Akses fitur administrasi SSB HBS</div>
        <span class="close-btn" id="menuCloseBtn">×</span>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.pendaftaran') }}" class="{{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
            Pendaftaran
        </a>

        <a href="{{ route('admin.siswas.index') }}" class="{{ request()->routeIs('admin.siswas.*') ? 'active' : '' }}">
            Data Siswa
        </a>

        <a href="{{ route('admin.pelatih.index') }}" class="{{ request()->routeIs('admin.pelatih.*') ? 'active' : '' }}">
            Data Pelatih
        </a>

        <a href="{{ route('admin.jadwal-latihan.index') }}" class="{{ request()->routeIs('admin.jadwal-latihan.*') ? 'active' : '' }}">
            Jadwal Latihan
        </a>

        <a href="{{ route('admin.turnamen.index') }}" class="{{ request()->routeIs('admin.turnamen.*') ? 'active' : '' }}">
            Turnamen
        </a>

        <a href="{{ route('admin.peserta-turnamen.index') }}" class="{{ request()->routeIs('admin.peserta-turnamen.*') ? 'active' : '' }}">
            Peserta Turnamen
        </a>

        <a href="{{ route('admin.pembayaran.index') }}" class="{{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            Pembayaran SPP
        </a>

        <a href="{{ route('admin.jersey.index') }}" class="{{ request()->routeIs('admin.jersey.*') ? 'active' : '' }}">
            Jersey
        </a>

        <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'active' : '' }}">
            Report
        </a>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>
    </div>
</div>

<div class="container">
    <div class="flash-container">
        @if(session('success'))
            <div class="flash-box flash-success">
                <span>{{ session('success') }}</span>
                <button type="button" class="flash-close">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="flash-box flash-error">
                <span>{{ session('error') }}</span>
                <button type="button" class="flash-close">✕</button>
            </div>
        @endif
    </div>

    @yield('content')
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Event Manual: Klik tanda ✕ untuk langsung menghapus flash box
    document.querySelectorAll('.flash-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.parentElement.remove();
        });
    });

    // 2. Event Otomatis: Efek transisi menghilang (fade-out) setelah 3 detik
    setTimeout(function(){
        document.querySelectorAll('.flash-box').forEach(function(box){
            box.style.transition = '0.4s';
            box.style.opacity = '0';
            
            setTimeout(function(){
                box.remove();
            }, 400);
        });
    }, 3000);

    // 3. Sentralisasi Konfirmasi Intersept Hapus (Hapus Massal Atribut Inline HTML)
    document.querySelectorAll('.delete-form').forEach(function(form){
        form.addEventListener('submit', function(e){
            const yakin = confirm('Yakin ingin menghapus data ini?');
            if(!yakin){
                e.preventDefault();
            }
        });
    });

    // 4. Logika Komponen Navigasi Samping (Sidebar Layout)
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('menuToggleBtn');
    const closeBtn = document.getElementById('menuCloseBtn');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
    if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
    if(overlay) overlay.addEventListener('click', toggleSidebar);

});
</script>

</body>
</html>