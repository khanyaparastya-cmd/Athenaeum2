<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','Dashboard') | Luxury Library</title>

<!-- FONT & ICON -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --navy-dark: #0f172a;
    --navy-light: rgba(15, 23, 42, 0.85);
    --cream: #f8f5f0;
    --gold: #c9a96e;
    --gold-glow: rgba(201, 169, 110, 0.4);
    --gold-transparent: rgba(201, 169, 110, 0.15);
    --gray-soft: #e5e7eb;
    --gray-text: #6b7280;
    --white: #ffffff;
    --danger: #ef4444;
    
    --sidebar-w: 270px;
    --sidebar-collapsed: 85px;
    --topbar-h: 70px;
}

* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
body { background: var(--cream); overflow-x: hidden; color: var(--navy-dark); font-weight: 400; }

/* OVERLAY */
.overlay {
    position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px); display: none; z-index: 19; transition: 0.3s ease;
}
.overlay.show { display: block; }

/* LAYOUT */
.wrapper { display: flex; min-height: 100vh; }

/* ================= SIDEBAR ================= */
.sidebar {
    width: var(--sidebar-w); min-width: var(--sidebar-w);
    background: var(--navy-light);
    backdrop-filter: blur(12px);
    border-right: 1px solid rgba(255,255,255,0.05);
    padding: 0; color: var(--gray-soft);
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    z-index: 20; display: flex; flex-direction: column;
    position: fixed; top: 0; left: 0; height: 100vh;
    overflow-y: auto; overflow-x: hidden;
}
.sidebar.collapsed { width: var(--sidebar-collapsed); min-width: var(--sidebar-collapsed); }

/* LOGO */
.logo {
    display: flex; align-items: center; justify-content: flex-start; gap: 8px;
    font-size: 22px; font-weight: 700; padding: 12px 20px;
    color: var(--white); border-bottom: 1px solid rgba(255,255,255,0.05);
    margin-bottom: 12px; white-space: nowrap; letter-spacing: 0.5px;
}
.logo img { 
    height: 75px; width: 75px; object-fit: cover; object-position: center;
}
.sidebar.collapsed .logo span { display: none; }
.sidebar.collapsed .logo { justify-content: center; padding: 12px 0; }

/* MENU LABEL */
.menu-label {
    font-size: 10px; text-transform: uppercase; letter-spacing: 2px;
    color: rgba(229, 231, 235, 0.5); padding: 18px 26px 8px; font-weight: 600;
}
.sidebar.collapsed .menu-label { display: none; }

/* MENU */
.menu { list-style: none; padding: 0 16px; margin-bottom: 10px; }
.menu li { margin-bottom: 4px; transition: 0.3s ease; position: relative; border-radius: 12px; }

.menu li a {
    display: flex; align-items: center; gap: 16px;
    padding: 12px 18px; text-decoration: none; color: var(--gray-soft);
    width: 100%; border-radius: 12px; font-size: 14.5px; font-weight: 400;
    transition: all 0.3s ease; white-space: nowrap;
}

.menu li i { font-size: 22px; min-width: 22px; text-align: center; }

/* SIDEBAR HOVER & ACTIVE ANIMATIONS */
.menu li a:hover {
    background: var(--gold-transparent); color: var(--gold);
    transform: translateX(6px);
}
.menu li.active a {
    background: linear-gradient(90deg, var(--gold-transparent), transparent);
    color: var(--gold); font-weight: 500;
}
.menu li.active::before {
    content: ''; position: absolute; left: 0; top: 15%; height: 70%;
    width: 4px; background: var(--gold); border-radius: 4px;
    box-shadow: 0 0 10px var(--gold-glow);
}

.sidebar.collapsed .text { display: none; }
.sidebar.collapsed .menu li a { justify-content: center; padding: 14px 0; }
.sidebar.collapsed .menu li a:hover { transform: translateY(-3px); }
.sidebar.collapsed .menu { padding: 0 12px; }

/* SIDEBAR FOOTER */
.sidebar-footer {
    margin-top: auto; padding: 20px 16px;
    border-top: 1px solid rgba(255,255,255,0.05);
}
.sidebar-footer a {
    display: flex; align-items: center; gap: 16px; padding: 12px 18px;
    text-decoration: none; color: var(--gray-soft); border-radius: 12px;
    font-size: 14.5px; transition: 0.3s ease;
}
.sidebar-footer a:hover {
    background: rgba(239, 68, 68, 0.1); color: var(--danger);
    transform: translateX(6px);
}
.sidebar.collapsed .sidebar-footer .text { display: none; }
.sidebar.collapsed .sidebar-footer a { justify-content: center; }
.sidebar.collapsed .sidebar-footer a:hover { transform: translateY(-3px); }

/* ================= MAIN ================= */
.main {
    flex: 1; display: flex; flex-direction: column;
    margin-left: var(--sidebar-w); transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
}
.sidebar.collapsed ~ .main { margin-left: var(--sidebar-collapsed); }

/* ================= TOPBAR ================= */
.topbar {
    background: transparent; height: var(--topbar-h);
    padding: 0 40px; display: flex; justify-content: space-between;
    align-items: center; position: sticky; top: 0; z-index: 10;
    margin-top: 10px;
}
.toggle {
    font-size: 24px; cursor: pointer; color: var(--navy-dark);
    width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;
    border-radius: 12px; transition: 0.3s; background: var(--white);
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.toggle:hover { background: var(--gold); color: var(--white); box-shadow: 0 4px 15px var(--gold-glow); }

/* TOPBAR RIGHT */
.topbar-right { display: flex; align-items: center; gap: 24px; }

/* SEARCH */
.topbar-search {
    display: flex; align-items: center; background: var(--white);
    border-radius: 20px; padding: 0 20px; gap: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02);
    transition: 0.3s ease;
}
.topbar-search:focus-within { box-shadow: 0 4px 20px rgba(201, 169, 110, 0.15); border-color: var(--gold); }
.topbar-search i { color: var(--gold); font-size: 18px; }
.topbar-search input {
    border: none; background: transparent; padding: 12px 0;
    font-size: 14px; outline: none; color: var(--navy-dark); width: 220px;
}
.topbar-search input::placeholder { color: var(--gray-text); font-weight: 300; }

/* USER */
.user {
    display: flex; align-items: center; gap: 14px; cursor: pointer;
    position: relative; padding: 6px 16px 6px 6px; border-radius: 24px;
    background: var(--white); transition: 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02);
}
.user:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
.user img {
    width: 38px; height: 38px; border-radius: 50%;
    object-fit: cover; border: 2px solid var(--cream);
}
.user-info { text-align: left; }
.user-name { font-weight: 600; font-size: 13.5px; color: var(--navy-dark); }
.user-role { font-size: 11px; color: var(--gray-text); letter-spacing: 0.5px; text-transform: uppercase; }

/* DROPDOWN */
.dropdown {
    position: absolute; right: 0; top: 60px; background: var(--white);
    min-width: 220px; border-radius: 16px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
    border: 1px solid rgba(0,0,0,0.04); display: none; overflow: hidden;
    animation: zoomIn 0.2s cubic-bezier(0.16, 1, 0.3, 1); transform-origin: top right;
}
.dropdown.show { display: block; }
.dropdown-header { padding: 18px 20px; border-bottom: 1px solid var(--gray-soft); background: #faf9f7; }
.dropdown-header p { font-size: 12.5px; color: var(--gray-text); margin-top: 2px; }
.dropdown-header strong { font-size: 15px; color: var(--navy-dark); font-weight: 600; }
.dropdown a {
    display: flex; align-items: center; gap: 14px; padding: 14px 20px;
    text-decoration: none; color: var(--navy-dark); font-size: 14px; transition: 0.2s;
}
.dropdown a:hover { background: var(--cream); color: var(--gold); }
.dropdown a.logout { border-top: 1px solid var(--gray-soft); color: var(--danger); }
.dropdown a.logout:hover { background: #fef2f2; color: var(--danger); }

@keyframes zoomIn {
    from { opacity: 0; transform: scale(0.95) translateY(-10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

/* ================= CONTENT ================= */
.content { padding: 30px 40px; }

/* CARDS COMMON */
.luxury-card {
    background: var(--white); border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02);
    transition: 0.3s ease; overflow: hidden;
}
.luxury-card:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(0,0,0,0.06); border-color: rgba(201, 169, 110, 0.3); }

/* BUTTONS */
.btn-gold {
    background: var(--gold); color: var(--white); padding: 10px 20px;
    border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 500;
    transition: 0.3s; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
}
.btn-gold:hover { background: #b89759; box-shadow: 0 6px 20px var(--gold-glow); transform: translateY(-2px); }

/* MODALS */
.luxury-modal-content {
    background: var(--cream); border-radius: 20px; overflow: hidden;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    animation: zoomIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

/* TABLE */
.luxury-table { width: 100%; border-collapse: collapse; }
.luxury-table th { 
    background: rgba(15, 23, 42, 0.03); color: var(--navy-dark); font-size: 13px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 1px; padding: 16px; text-align: left; border-bottom: 2px solid var(--gray-soft);
}
.luxury-table td { padding: 16px; border-bottom: 1px solid var(--gray-soft); font-size: 14px; color: var(--gray-text); }
.luxury-table tr:hover td { background: var(--cream); }

/* ================= RESPONSIVE ================= */
@media (max-width:992px){
    .content, .topbar { padding-left: 24px; padding-right: 24px; }
}
@media (max-width:768px){
    .sidebar { left: -300px; }
    .sidebar.active { left: 0; width: 280px; }
    .main { margin-left: 0 !important; }
    .topbar-search { display: none; }
    .user-info { display: none; }
    .user { padding: 6px; }
}
@media (max-width:576px){
    .content { padding: 20px 16px; }
}
</style>
</head>

<body>

<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="wrapper">

{{-- ================= SIDEBAR ================= --}}
<aside class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Athenaeum Logo">
        <span>Athenaeum</span>
    </div>

    <div class="menu-label">Menu Akademik</div>
    <ul class="menu">
        <li class="{{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class='bx bx-grid-alt'></i>
                <span class="text">Dashboard Utama</span>
            </a>
        </li>
        <li class="{{ request()->is('siswas*') ? 'active' : '' }}">
            <a href="{{ route('siswas.index') }}">
                <i class='bx bx-user-pin'></i>
                <span class="text">Siswa</span>
            </a>
        </li>
        <li class="{{ request()->is('bukus*') ? 'active' : '' }}">
            <a href="{{ route('bukus.index') }}">
                <i class='bx bx-book-bookmark'></i>
                <span class="text">Koleksi Pustaka</span>
            </a>
        </li>
        <li class="{{ request()->is('kategoris*') ? 'active' : '' }}">
            <a href="{{ route('kategoris.index') }}">
                <i class='bx bx-collection'></i>
                <span class="text">Kategori Koleksi</span>
            </a>
        </li>
    </ul>

    <div class="menu-label">Sirkulasi & Layanan</div>
    <ul class="menu">
        <li class="{{ request()->is('peminjamans*') ? 'active' : '' }}">
            <a href="{{ route('peminjamans.index') }}">
                <i class='bx bx-transfer'></i>
                <span class="text">Sirkulasi Peminjaman</span>
            </a>
        </li>
    </ul>



    {{-- Sidebar Footer: Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                <i class='bx bx-log-out-circle'></i>
                <span class="text">Keluar Sistem</span>
            </a>
        </form>
    </div>
</aside>

{{-- ================= MAIN ================= --}}
<main class="main">

<div class="topbar">
    <i class='bx bx-menu toggle' onclick="toggleSidebar()"></i>

    <div class="topbar-right">
        <div class="topbar-search">
            <i class='bx bx-search'></i>
            <input type="text" placeholder="Temukan karya, penulis...">
        </div>

        <div class="user" id="userBtn">
            <img src="https://i.pravatar.cc/150?img=47" alt="Admin Profile">
            <div class="user-info">
                <div class="user-name">
                    @auth {{ Auth::user()->name }} @else Guest User @endauth
                </div>
                <div class="user-role">
                    @auth Pustakawan {{ ucfirst(Auth::user()->role) }} @endauth
                </div>
            </div>
            <i class='bx bx-chevron-down' style="color:var(--gold); margin-right:4px;"></i>

            <div class="dropdown" id="dropdown">
                <div class="dropdown-header">
                    <strong>@auth {{ Auth::user()->name }} @else Guest @endauth</strong>
                    <p>@auth {{ Auth::user()->email }} @endauth</p>
                </div>
                <a href="#"><i class='bx bx-user-circle'></i> Profil Pustakawan</a>
                <a href="#"><i class='bx bx-slider'></i> Preferensi</a>
                <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <i class='bx bx-log-out-circle'></i> Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    @yield('content')
</div>

</main>
</div>

<!-- LUXURY CUSTOM MODAL (REPLACES window.confirm) -->
<div id="luxuryModal" class="luxury-modal-overlay">
    <div class="luxury-modal-card">
        <div class="modal-icon"><i class='bx bx-question-mark'></i></div>
        <h3 class="modal-title">Konfirmasi Tindakan</h3>
        <p class="modal-message" id="modalMessage">Apakah Anda yakin ingin melanjutkan?</p>
        
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeLuxuryModal()">Batal</button>
            <button class="btn-modal-confirm" id="modalConfirmBtn">Lanjutkan</button>
        </div>
    </div>
</div>

<style>
/* MODAL STYLES */
.luxury-modal-overlay {
    position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(8px);
    z-index: 9999; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: all 0.3s ease;
}
.luxury-modal-overlay.active { opacity: 1; visibility: visible; }
.luxury-modal-card {
    background: var(--cream); width: 100%; max-width: 400px; border-radius: 24px;
    padding: 30px; text-align: center; box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    transform: scale(0.9) translateY(20px); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid var(--white);
}
.luxury-modal-overlay.active .luxury-modal-card { transform: scale(1) translateY(0); }

.modal-icon {
    width: 60px; height: 60px; background: rgba(201, 169, 110, 0.15); color: var(--gold);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 32px; margin: 0 auto 20px;
}
.modal-title { color: var(--navy-dark); font-size: 18px; font-weight: 700; margin-bottom: 10px; }
.modal-message { color: var(--gray-text); font-size: 14.5px; line-height: 1.6; margin-bottom: 24px; }

.modal-actions { display: flex; gap: 12px; }
.btn-modal-cancel, .btn-modal-confirm {
    flex: 1; padding: 12px; border-radius: 12px; font-weight: 600; font-size: 14px;
    cursor: pointer; transition: 0.2s; border: none; outline: none;
}
.btn-modal-cancel { background: var(--gray-soft); color: var(--navy-dark); }
.btn-modal-cancel:hover { background: #d1d5db; }
.btn-modal-confirm { background: var(--gold); color: var(--white); }
.btn-modal-confirm:hover { background: #b89759; box-shadow: 0 4px 15px var(--gold-glow); transform: translateY(-2px); }
</style>

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

function toggleSidebar() {
    if(window.innerWidth <= 768) {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('show');
    } else {
        sidebar.classList.toggle('collapsed');
    }
}

function closeSidebar() {
    sidebar.classList.remove('active');
    overlay.classList.remove('show');
}

const userBtn = document.getElementById('userBtn');
const dropdown = document.getElementById('dropdown');

userBtn.addEventListener('click', e => {
    e.stopPropagation();
    dropdown.classList.toggle('show');
});

document.addEventListener('click', () => {
    dropdown.classList.remove('show');
});

// ================= CUSTOM MODAL OVERRIDE =================
let pendingFormToSubmit = null;
const modalEl = document.getElementById('luxuryModal');
const msgEl = document.getElementById('modalMessage');
const confirmBtn = document.getElementById('modalConfirmBtn');

function showLuxuryModal(message, formElement) {
    pendingFormToSubmit = formElement;
    msgEl.innerHTML = message;
    modalEl.classList.add('active');
}

function closeLuxuryModal() {
    modalEl.classList.remove('active');
    pendingFormToSubmit = null;
}

confirmBtn.addEventListener('click', () => {
    if(pendingFormToSubmit) {
        // Hapus custom onsubmit agar tidak loop
        pendingFormToSubmit.onsubmit = null; 
        pendingFormToSubmit.submit();
    }
    closeLuxuryModal();
});

// Override semua alert confirm bawaan di form
document.addEventListener('DOMContentLoaded', () => {
    const formsWithConfirm = document.querySelectorAll('form[onsubmit*="return confirm"]');
    formsWithConfirm.forEach(form => {
        const onsubmitCode = form.getAttribute('onsubmit');
        const match = onsubmitCode.match(/confirm\(['"](.*?)['"]\)/);
        if(match) {
            const pesan = match[1];
            form.setAttribute('onsubmit', 'event.preventDefault(); showLuxuryModal(`' + pesan + '`, this); return false;');
        }
    });
});
</script>

</body>
</html>