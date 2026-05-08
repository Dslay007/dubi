<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dudukbaca</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #3b82f6;
            --sidebar-hover: #1e293b;
            --bg-main: #f1f5f9;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid #1e293b;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #1e293b;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .brand span { opacity: 0.7; font-weight: 300; font-size: 1.25rem; }

        .nav-menu {
            padding: 1.5rem 1rem;
            flex: 1;
        }

        .nav-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            font-weight: 700;
            margin: 1.5rem 0 0.75rem 0.5rem;
        }
        .nav-category:first-child { margin-top: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .nav-item:hover, .nav-item.active {
            background: var(--sidebar-hover);
            color: white;
        }
        
        .nav-item.active {
            background: #1e293b;
            color: var(--sidebar-active);
            border-left: 3px solid var(--sidebar-active);
        }

        .nav-item i { width: 1.25rem; height: 1.25rem; }

        .user-panel {
            padding: 1rem 1.5rem;
            background: #020617;
            border-top: 1px solid #1e293b;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--sidebar-active);
            border-radius: 99px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        /* Utility Classes for Components */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            transition: 0.2s;
            cursor: pointer;
        }
        .btn:hover { opacity: 0.9; }
        
        /* Form Inputs */
        .input:focus { border-color: var(--sidebar-active); box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1); }

        /* Pagination Fixes (Laravel Tailwind Default) */
        nav[role="navigation"] { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
        nav[role="navigation"] div:first-child { display: none; } /* Hide the 'Showing X to Y' text on small screens if redundant */
        nav[role="navigation"] > div:nth-child(2) { display: flex; width: 100%; justify-content: space-between; align-items: center; }
        
        span[aria-current="page"] > span {
            background: var(--sidebar-active); color: white; border-color: var(--sidebar-active);
        }
        
        /* Target the pagination links/buttons */
        nav[role="navigation"] a, nav[role="navigation"] span {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            background: white;
            color: #475569;
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            min-width: 2rem;
        }
        
        nav[role="navigation"] a:hover {
            background: #f1f5f9;
        }

        /* Fix Arrows in Pagination */
        nav[role="navigation"] svg { 
            width: 1rem; height: 1rem; 
        }

        /* Sidebar Chevron */
        .nav-item::after {
            content: '';
            width: 0.5rem;
            height: 0.5rem;
            border-right: 2px solid #475569;
            border-top: 2px solid #475569;
            transform: rotate(45deg);
            margin-left: auto;
            opacity: 0.3;
            transition: 0.2s;
        }
        .nav-item:hover::after, .nav-item.active::after {
            border-color: white;
            opacity: 1;
        }
        
        /* Hide logout button chevron specially */
        button.nav-item::after { display: none; }
    </style>
</head>
@php
    use App\Http\Controllers\Admin\SystemRoleController;
    $__user = auth()->guard('admin')->user();
    $__groupId = $__user->groups ?? null;
    $__isSuper = ($__groupId == 1);
    $__perms = $__isSuper ? [] : SystemRoleController::loadPermissions($__groupId);
    // Helper: check if user can see a sub-menu
    // Super admin always true; others check the loaded permissions array
    if (!function_exists('__canSee')) {
        function __canSee($key, $isSuper, $perms) {
            return $isSuper || in_array($key, $perms);
        }
    }
    // Check if ANY sub-menu in a group is visible
    if (!function_exists('__anyVisible')) {
        function __anyVisible($keys, $isSuper, $perms) {
            if ($isSuper) return true;
            foreach ($keys as $k) { if (in_array($k, $perms)) return true; }
            return false;
        }
    }
@endphp
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <i data-lucide="library"></i>
                Duduk<span>baca</span>
            </a>
        </div>

        <nav class="nav-menu">
            <div class="nav-category">Main</div>
            @if(__canSee('dashboard', $__isSuper, $__perms))
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
            @endif

            <!-- Circulation Group (Dropdown) -->
            @if(__anyVisible(['sirkulasi.transaksi','sirkulasi.pengembalian_kilat','sirkulasi.aturan_peminjaman','sirkulasi.sejarah_peminjaman','sirkulasi.daftar_keterlambatan','sirkulasi.reservasi'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/circulation*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="repeat"></i> Sirkulasi
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('sirkulasi.transaksi', $__isSuper, $__perms))
                    <a href="{{ route('admin.circulation.index') }}" class="nav-item {{ request()->routeIs('admin.circulation.index') || request()->routeIs('admin.circulation.transaction') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Transaksi
                    </a>
                    @endif
                    @if(__canSee('sirkulasi.pengembalian_kilat', $__isSuper, $__perms))
                    <a href="{{ route('admin.circulation.quick_return') }}" class="nav-item {{ request()->routeIs('admin.circulation.quick_return') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Pengembalian Kilat
                    </a>
                    @endif
                    @if(__canSee('sirkulasi.aturan_peminjaman', $__isSuper, $__perms))
                    <a href="{{ route('admin.circulation.rules') }}" class="nav-item {{ request()->routeIs('admin.circulation.rules') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Aturan Peminjaman
                    </a>
                    @endif
                    @if(__canSee('sirkulasi.sejarah_peminjaman', $__isSuper, $__perms))
                    <a href="{{ route('admin.circulation.history') }}" class="nav-item {{ request()->routeIs('admin.circulation.history') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Sejarah Peminjaman
                    </a>
                    @endif
                    @if(__canSee('sirkulasi.daftar_keterlambatan', $__isSuper, $__perms))
                    <a href="{{ route('admin.circulation.overdue') }}" class="nav-item {{ request()->routeIs('admin.circulation.overdue') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Daftar Keterlambatan
                    </a>
                    @endif
                    @if(__canSee('sirkulasi.reservasi', $__isSuper, $__perms))
                    <a href="{{ route('admin.circulation.reservations') }}" class="nav-item {{ request()->routeIs('admin.circulation.reservations') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Reservasi
                    </a>
                    @endif
                </div>
            </div>
            @endif
            <!-- Membership Group (Dropdown) -->
            @if(__anyVisible(['membership.data_anggota','membership.tipe_keanggotaan','membership.cetak_kartu'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/member*') || request()->is('admin/member_type*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="users"></i> Membership
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('membership.data_anggota', $__isSuper, $__perms))
                    <a href="{{ route('admin.member.index') }}" class="nav-item {{ request()->routeIs('admin.member.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Data Anggota
                    </a>
                    @endif
                    @if(__canSee('membership.tipe_keanggotaan', $__isSuper, $__perms))
                    <a href="{{ route('admin.member_type.index') }}" class="nav-item {{ request()->routeIs('admin.member_type.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Tipe Keanggotaan
                    </a>
                    @endif
                    @if(__canSee('membership.cetak_kartu', $__isSuper, $__perms))
                    <a href="{{ route('admin.member.barcode') }}" class="nav-item {{ request()->routeIs('admin.member.barcode') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Cetak Kartu Anggota
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Bibliography Group (Dropdown) -->
            @if(__anyVisible(['bibliografi.data_buku','bibliografi.eksemplar','bibliografi.eksemplar_keluar','bibliografi.cetak_barcode','bibliografi.marc'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/biblio*') || request()->is('admin/item*') || request()->is('admin/marc*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="book-open"></i> Bibliografi
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('bibliografi.data_buku', $__isSuper, $__perms))
                    <a href="{{ route('admin.biblio.index') }}" class="nav-item {{ request()->routeIs('admin.biblio.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Bibliografi (Data Buku)
                    </a>
                    @endif
                    @if(__canSee('bibliografi.eksemplar', $__isSuper, $__perms))
                    <a href="{{ route('admin.item.index') }}" class="nav-item {{ request()->routeIs('admin.item.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Eksemplar
                    </a>
                    @endif
                    @if(__canSee('bibliografi.eksemplar_keluar', $__isSuper, $__perms))
                    <a href="{{ route('admin.item.out') }}" class="nav-item {{ request()->routeIs('admin.item.out') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Daftar Eksemplar Keluar
                    </a>
                    @endif
                    @if(__canSee('bibliografi.cetak_barcode', $__isSuper, $__perms))
                    <a href="{{ route('admin.item.barcode') }}" class="nav-item {{ request()->routeIs('admin.item.barcode') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Cetak Barcode
                    </a>
                    @endif
                    @if(__canSee('bibliografi.marc', $__isSuper, $__perms))
                    <a href="{{ route('admin.marc.index') }}" class="nav-item {{ request()->routeIs('admin.marc.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        MARC Import/Export
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Master Files Group (Dropdown) -->
            @if(__anyVisible(['master.terkendali','master.referensi','master.peralatan'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/master*') || request()->is('admin/gmd*') || request()->is('admin/author*') || request()->is('admin/publisher*') || request()->is('admin/topic*') || request()->is('admin/place*') || request()->is('admin/item_status*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="database"></i> Daftar Terkendali
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('master.terkendali', $__isSuper, $__perms))
                    <a href="{{ route('admin.gmd.index') }}" class="nav-item {{ request()->is('admin/gmd*') || request()->is('admin/author*') || request()->is('admin/publisher*') || request()->is('admin/topic*') || request()->is('admin/master/terkendali*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Daftar Terkendali
                    </a>
                    @endif
                    @if(__canSee('master.referensi', $__isSuper, $__perms))
                    <a href="{{ route('admin.place.index') }}" class="nav-item {{ request()->is('admin/place*') || request()->is('admin/item_status*') || request()->is('admin/master/referensi*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Daftar Referensi
                    </a>
                    @endif
                    @if(__canSee('master.peralatan', $__isSuper, $__perms))
                    <a href="{{ route('admin.master.peralatan') }}" class="nav-item {{ request()->is('admin/master/peralatan*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Peralatan
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Inventarisasi Group -->
            @if(__anyVisible(['inventarisasi.rekaman','inventarisasi.inisialisasi'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/inventarisasi*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="clipboard-list"></i> Inventarisasi
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('inventarisasi.rekaman', $__isSuper, $__perms))
                    <a href="{{ route('admin.inventarisasi.rekaman') }}" class="nav-item {{ request()->routeIs('admin.inventarisasi.rekaman') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Rekaman Inventaris</a>
                    @endif
                    @if(__canSee('inventarisasi.inisialisasi', $__isSuper, $__perms))
                    <a href="{{ route('admin.inventarisasi.inisialisasi') }}" class="nav-item {{ request()->routeIs('admin.inventarisasi.inisialisasi') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Inisialisasi</a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Acara Group -->
            @if(__anyVisible(['acara.berita_acara','acara.pendaftaran'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/acara*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="calendar-days"></i> Acara
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('acara.berita_acara', $__isSuper, $__perms))
                    <a href="{{ route('admin.acara.berita_acara.index') }}" class="nav-item {{ request()->routeIs('admin.acara.berita_acara.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Berita Acara</a>
                    @endif
                    @if(__canSee('acara.pendaftaran', $__isSuper, $__perms))
                    <a href="{{ route('admin.acara.pendaftaran.index') }}" class="nav-item {{ request()->routeIs('admin.acara.pendaftaran.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Form Pendaftaran Kegiatan</a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Pelaporan Group -->
            @if(__anyVisible(['pelaporan.statistik_koleksi','pelaporan.laporan_peminjaman','pelaporan.laporan_anggota','pelaporan.koleksi_perpustakaan','pelaporan.data_klasifikasi','pelaporan.laporan_pengunjung','pelaporan.laporan_denda'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/pelaporan*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="bar-chart-3"></i> Pelaporan
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('pelaporan.statistik_koleksi', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.statistik_koleksi') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.statistik_koleksi') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Statistik Koleksi</a>
                    @endif
                    @if(__canSee('pelaporan.laporan_peminjaman', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.laporan_peminjaman') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.laporan_peminjaman') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Laporan Peminjaman</a>
                    @endif
                    @if(__canSee('pelaporan.laporan_anggota', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.laporan_anggota') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.laporan_anggota') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Laporan Anggota</a>
                    @endif
                    @if(__canSee('pelaporan.koleksi_perpustakaan', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.koleksi_perpustakaan') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.koleksi_perpustakaan') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Koleksi Perpustakaan</a>
                    @endif
                    @if(__canSee('pelaporan.data_klasifikasi', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.data_klasifikasi') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.data_klasifikasi') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Data Klasifikasi</a>
                    @endif
                    @if(__canSee('pelaporan.laporan_pengunjung', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.laporan_pengunjung') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.laporan_pengunjung') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Laporan Pengunjung</a>
                    @endif
                    @if(__canSee('pelaporan.laporan_denda', $__isSuper, $__perms))
                    <a href="{{ route('admin.pelaporan.laporan_denda') }}" class="nav-item {{ request()->routeIs('admin.pelaporan.laporan_denda') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Laporan Denda</a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Sistem Group -->
            @if(__anyVisible(['sistem.konten','sistem.backup','sistem.role','sistem.staff','sistem.aktifitas','sistem.plugin'], $__isSuper, $__perms))
            <div x-data="{ open: {{ request()->is('admin/sistem*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="settings"></i> Sistem
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    @if(__canSee('sistem.konten', $__isSuper, $__perms))
                    <a href="{{ route('admin.sistem.konten.index') }}" class="nav-item {{ request()->routeIs('admin.sistem.konten.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Konten</a>
                    @endif
                    @if(__canSee('sistem.backup', $__isSuper, $__perms))
                    <a href="{{ route('admin.sistem.backup.index') }}" class="nav-item {{ request()->routeIs('admin.sistem.backup.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Salinan Pangkalan</a>
                    @endif
                    @if(__canSee('sistem.role', $__isSuper, $__perms))
                    <a href="{{ route('admin.sistem.role.index') }}" class="nav-item {{ request()->routeIs('admin.sistem.role.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Role and Permission</a>
                    @endif
                    @if(__canSee('sistem.staff', $__isSuper, $__perms))
                    <a href="{{ route('admin.sistem.staff.index') }}" class="nav-item {{ request()->routeIs('admin.sistem.staff.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Manajemen Staff</a>
                    @endif
                    @if(__canSee('sistem.aktifitas', $__isSuper, $__perms))
                    <a href="{{ route('admin.sistem.aktifitas.index') }}" class="nav-item {{ request()->routeIs('admin.sistem.aktifitas.*') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Aktifitas Staff</a>
                    @endif
                    @if(__canSee('sistem.plugin', $__isSuper, $__perms))
                    <a href="{{ route('admin.sistem.plugin.csp') }}" class="nav-item {{ request()->routeIs('admin.sistem.plugin.csp') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">Plugin (CSP)</a>
                    @endif
                </div>
            </div>
            @endif

            <div class="nav-category">Account</div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item" style="background: none; border: none; width: 100%; cursor: pointer;">
                    <i data-lucide="log-out"></i> Logout
                </button>
            </form>
        </nav>

        <div class="user-panel">
            <div class="user-avatar">{{ strtoupper(substr($__user->realname ?? $__user->username ?? 'A', 0, 1)) }}</div>
            <div>
                <div style="font-weight: 600; font-size: 0.9rem;">{{ $__user->realname ?? $__user->username ?? 'Admin' }}</div>
                <div style="font-size: 0.75rem; color: #64748b;">{{ $__isSuper ? 'Administrator' : ($__user->groups ?? 'Staff') }}</div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header Mobile (Optional) -->
        <header style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #0f172a;">@yield('pageTitle', 'Dashboard')</h2>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ url('/') }}" target="_blank" class="btn" style="background: white; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; border-radius: 0.5rem; color: #475569; font-size: 0.875rem;">
                    <i data-lucide="external-link" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i> View OPAC
                </a>
            </div>
        </header>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Oops, ada kesalahan:</div>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
