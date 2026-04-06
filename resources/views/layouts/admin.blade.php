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
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>

            <!-- Circulation Group (Dropdown) -->
            <div x-data="{ open: {{ request()->is('admin/circulation*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="repeat"></i> Sirkulasi
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    <a href="{{ route('admin.circulation.index') }}" class="nav-item {{ request()->routeIs('admin.circulation.index') || request()->routeIs('admin.circulation.transaction') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Transaksi
                    </a>
                    <a href="{{ route('admin.circulation.quick_return') }}" class="nav-item {{ request()->routeIs('admin.circulation.quick_return') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Pengembalian Kilat
                    </a>
                    <a href="{{ route('admin.circulation.rules') }}" class="nav-item {{ request()->routeIs('admin.circulation.rules') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Aturan Peminjaman
                    </a>
                    <a href="{{ route('admin.circulation.history') }}" class="nav-item {{ request()->routeIs('admin.circulation.history') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Sejarah Peminjaman
                    </a>
                    <a href="{{ route('admin.circulation.overdue') }}" class="nav-item {{ request()->routeIs('admin.circulation.overdue') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Daftar Keterlambatan
                    </a>
                    <a href="{{ route('admin.circulation.reservations') }}" class="nav-item {{ request()->routeIs('admin.circulation.reservations') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Reservasi
                    </a>
                </div>
            </div>
            <a href="{{ route('admin.member.index') }}" class="nav-item {{ request()->routeIs('admin.member.*') ? 'active' : '' }}">
                <i data-lucide="users"></i> Membership
            </a>

            <!-- Bibliography Group (Dropdown) -->
            <div x-data="{ open: {{ request()->is('admin/biblio*') || request()->is('admin/item*') || request()->is('admin/marc*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="nav-item" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-lucide="book-open"></i> Bibliografi
                    </span>
                    <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; width: 1rem; height: 1rem;"></i>
                </button>
                
                <div x-show="open" style="padding-left: 2rem; display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;" x-transition>
                    <a href="{{ route('admin.biblio.index') }}" class="nav-item {{ request()->routeIs('admin.biblio.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Bibliografi (Data Buku)
                    </a>
                    <a href="{{ route('admin.item.index') }}" class="nav-item {{ request()->routeIs('admin.item.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Eksemplar
                    </a>
                    <a href="{{ route('admin.item.out') }}" class="nav-item {{ request()->routeIs('admin.item.out') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Daftar Eksemplar Keluar
                    </a>
                    <a href="{{ route('admin.item.barcode') }}" class="nav-item {{ request()->routeIs('admin.item.barcode') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        Cetak Barcode
                    </a>
                    <a href="{{ route('admin.marc.index') }}" class="nav-item {{ request()->routeIs('admin.marc.index') ? 'active-sub' : '' }}" style="font-size: 0.9rem;">
                        MARC Import/Export
                    </a>
                </div>
            </div>

            <div class="nav-category">Master Files</div>
            <a href="{{ route('admin.author.index') }}" class="nav-item {{ request()->routeIs('admin.author.*') ? 'active' : '' }}">
                <i data-lucide="pen-tool"></i> Authors
            </a>
            <a href="{{ route('admin.publisher.index') }}" class="nav-item {{ request()->routeIs('admin.publisher.*') ? 'active' : '' }}">
                <i data-lucide="building-2"></i> Publishers
            </a>
            <a href="{{ route('admin.gmd.index') }}" class="nav-item {{ request()->routeIs('admin.gmd.*') ? 'active' : '' }}">
                <i data-lucide="tag"></i> GMD
            </a>
            <a href="{{ route('admin.topic.index') }}" class="nav-item {{ request()->routeIs('admin.topic.*') ? 'active' : '' }}">
                <i data-lucide="hash"></i> Subjects
            </a>
            <a href="{{ route('admin.place.index') }}" class="nav-item {{ request()->routeIs('admin.place.*') ? 'active' : '' }}">
                <i data-lucide="map-pin"></i> Places
            </a>
             <a href="{{ route('admin.item_status.index') }}" class="nav-item {{ request()->routeIs('admin.item_status.*') ? 'active' : '' }}">
                <i data-lucide="alert-circle"></i> Item Status
            </a>

            <div class="nav-category">System</div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item" style="background: none; border: none; width: 100%; cursor: pointer;">
                    <i data-lucide="log-out"></i> Logout
                </button>
            </form>
        </nav>

        <div class="user-panel">
            <div class="user-avatar">A</div>
            <div>
                <div style="font-weight: 600; font-size: 0.9rem;">Administrator</div>
                <div style="font-size: 0.75rem; color: #64748b;">Online</div>
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
