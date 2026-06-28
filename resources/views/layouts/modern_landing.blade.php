<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Dudukbaca') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Ultra Modern HSL Palette */
            --primary: 220 50% 40%;    /* Deep Blue */
            --primary-light: 220 80% 98%; 
            --accent: 330 80% 60%;     /* Vibrant Pink/Red */
            --surface: 0 0% 100%;
            --bg: 220 20% 97%;
            --text-main: 220 40% 15%;
            --text-muted: 220 20% 45%;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Outfit', sans-serif;
            background-color: hsl(var(--bg));
            color: hsl(var(--text-main));
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; transition: 0.2s; }

        /* Hide default browser eye icon for password inputs */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear,
        input[type="password"]::-webkit-reveal {
            display: none;
        }

        /* Modern Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .brand { 
            font-size: 1.75rem; 
            font-weight: 800; 
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.05em;
        }

        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-link { 
            font-weight: 600; 
            color: hsl(var(--text-muted)); 
            font-size: 0.95rem;
        }
        .nav-link:hover { color: hsl(var(--primary)); }
        
        .btn {
            background: hsl(var(--primary));
            color: white;
            padding: 0.7rem 1.7rem;
            border-radius: 99px;
            font-weight: 600;
            border: 2px solid hsl(var(--primary));
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .btn-outline {
            background: transparent;
            color: hsl(var(--primary));
            box-shadow: none;
        }
        .btn-outline:hover {
            background: hsl(var(--primary));
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        /* Active Nav Link */
        .nav-link {
            padding: 0.5rem 1.25rem;
            border-radius: 99px;
            transition: all 0.2s;
        }
        .nav-link:hover { 
            background: rgba(15, 23, 42, 0.03);
            color: hsl(var(--primary));
        }
        .nav-link.active {
            background: hsl(var(--primary));
            color: white !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        /* Footer */
        footer {
            background: white;
            padding: 4rem 2rem;
            text-align: center;
            margin-top: 6rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        /* Pagination Fixes */
        nav[role="navigation"] {
             display: flex;
             justify-content: center;
             margin-top: 2rem;
        }
        
        /* Hide the mobile "Previous / Next" text links */
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }
        
        /* The Desktop Container: Force it visible on all screens (override Tailwind 'hidden') */
        nav[role="navigation"] > div:nth-child(2) {
             display: flex !important;
             flex-direction: column;
             align-items: center;
             gap: 1rem;
             width: 100%;
        }

        /* The "Showing X to Y results" text container */
        nav[role="navigation"] > div:nth-child(2) > div:first-child {
             text-align: center;
             width: 100%;
        }
        nav[role="navigation"] > div:nth-child(2) > div:first-child p {
             font-size: 0.95rem;
             color: hsl(var(--text-muted));
        }

        /* The Links Container */
        nav[role="navigation"] > div:nth-child(2) > div:last-child {
             box-shadow: none !important;
             display: flex;
             justify-content: center;
             flex-wrap: wrap;
             gap: 0.25rem;
        }

        /* Individual Links */
        nav[role="navigation"] > div:nth-child(2) > div:last-child a,
        nav[role="navigation"] > div:nth-child(2) > div:last-child span[aria-disabled] > span,
        nav[role="navigation"] > div:nth-child(2) > div:last-child span[aria-current] > span {
            border: none !important;
            padding: 0.5rem 0.75rem !important;
            border-radius: 8px !important;
            margin: 0 !important;
            font-weight: 600 !important;
            box-shadow: none !important;
            background: transparent !important;
            color: hsl(var(--text-muted)) !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            text-decoration: none;
        }
        nav[role="navigation"] > div:nth-child(2) > div:last-child a:hover {
            background: #f1f5f9 !important;
            color: hsl(var(--primary)) !important;
        }
        nav[role="navigation"] > div:nth-child(2) > div:last-child span[aria-current="page"] > span {
            background: hsl(var(--primary)) !important;
            color: white !important;
        }
        
        /* Arrows */
        nav[role="navigation"] svg { 
            width: 1rem; 
            height: 1rem;
            display: inline-block;
        }
        /* Responsive Grid Utilities */
        .responsive-grid-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .responsive-grid-3 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        /* Typography Utilities */
        .hero-title {
            font-size: 2.5rem !important;
        }
        .section-title {
            font-size: 2rem !important;
        }
        .stat-value {
            font-size: 2.5rem !important;
        }

        /* Base Sections */
        section {
            padding: 4rem 1rem !important;
        }
        .campaign-content {
            padding: 2rem !important;
        }
        .stat-divider {
            border-left: none !important;
            border-right: none !important;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            padding: 2rem 0;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: hsl(var(--text-main));
            padding: 0.5rem;
        }
        .mobile-menu {
            display: none;
            flex-direction: column;
            background: white;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            padding: 1rem 2rem 2rem;
            box-shadow: 0 10px 15px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            gap: 1rem;
        }
        .mobile-menu.active {
            display: flex;
        }

        @media (min-width: 768px) {
            .responsive-grid-2 {
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
            }
            .responsive-grid-3 {
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
            }
            .hero-title {
                font-size: 4rem !important;
            }
            .section-title {
                font-size: 2.5rem !important;
            }
            .stat-value {
                font-size: 3.5rem !important;
            }
            section {
                padding: 6rem 1rem !important;
            }
            .campaign-content {
                padding: 4rem !important;
            }
            .stat-divider {
                border-top: none !important;
                border-bottom: none !important;
                border-left: 1px solid #e2e8f0 !important;
                border-right: 1px solid #e2e8f0 !important;
                padding: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .mobile-menu-btn {
                display: block;
            }
            .brand {
                font-size: 1.5rem;
            }
            footer {
                padding: 3rem 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="brand" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Dudukbaca" style="height: 2.5rem; width: auto; object-fit: contain;">
            Dudukbaca.
        </a>
        
        <button id="mobile-menu-btn" class="mobile-menu-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>

        <div class="nav-links">
            <a href="{{ route('landing') }}" class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('page.struktur') }}" class="nav-link {{ request()->routeIs('page.struktur') ? 'active' : '' }}">Struktur Komunitas</a>
            <a href="{{ route('page.jurnal') }}" class="nav-link {{ request()->routeIs('page.jurnal') ? 'active' : '' }}">Jurnal Lapak</a>
            <a href="{{ route('opac.index') }}" class="nav-link {{ request()->routeIs('opac.*') ? 'active' : '' }}" style="{{ request()->routeIs('opac.*') ? '' : 'color: hsl(var(--accent));' }}">Perpustakaan (OPAC)</a>
            
            @if(Auth::guard('member')->check())
                <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">Dashboard Saya</a>
                <form action="{{ route('member.logout') }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun ini?');">
                    @csrf
                    <button type="submit" class="btn" style="background: #ef4444; color: white; border: 1px solid #dc2626; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); font-weight: 600; padding: 0.5rem 1.25rem; border-radius: 99px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 0.4rem;" onmouseover="this.style.background='#dc2626'; this.style.borderColor='#b91c1c'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#ef4444'; this.style.borderColor='#dc2626'; this.style.transform='none';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Login Member
                </a>
            @endif
        </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="mobile-menu">
        <a href="{{ route('landing') }}" class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('page.struktur') }}" class="nav-link {{ request()->routeIs('page.struktur') ? 'active' : '' }}">Struktur Komunitas</a>
        <a href="{{ route('page.jurnal') }}" class="nav-link {{ request()->routeIs('page.jurnal') ? 'active' : '' }}">Jurnal Lapak</a>
        <a href="{{ route('opac.index') }}" class="nav-link {{ request()->routeIs('opac.*') ? 'active' : '' }}" style="{{ request()->routeIs('opac.*') ? '' : 'color: hsl(var(--accent));' }}">Perpustakaan (OPAC)</a>
        
        @if(Auth::guard('member')->check())
            <a href="{{ route('member.dashboard') }}" class="nav-link" style="font-size: 1.1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.5rem;">Dashboard Saya</a>
            <form action="{{ route('member.logout') }}" method="POST" style="margin-top: 1rem;" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun ini?');">
                @csrf
                <button type="submit" class="btn" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem; background: #ef4444; color: white; border: 1px solid #dc2626; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); font-weight: 600; padding: 0.75rem; border-radius: 0.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline" style="margin-top: 1rem; width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Login Member
            </a>
        @endif
    </div>
    </nav>

    @yield('content')

    <footer>
        <h4 class="brand" style="font-size: 1.5rem; margin-bottom: 0.5rem;">Dudukbaca.</h4>
        
        <!-- Social Media Icons -->
        <div style="display: flex; justify-content: center; gap: 1.5rem; margin-bottom: 2rem;">
            <a href="https://instagram.com/dudukbaca" target="_blank" title="Instagram" style="color: hsl(var(--text-muted)); padding: 0.5rem; border-radius: 50%; background: #f1f5f9; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.background='#be185d'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#f1f5f9'; this.style.color='hsl(var(--text-muted))'; this.style.transform='translateY(0)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
            </a>
            <a href="https://twitter.com/dudukbaca" target="_blank" title="Twitter / X" style="color: hsl(var(--text-muted)); padding: 0.5rem; border-radius: 50%; background: #f1f5f9; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.background='black'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#f1f5f9'; this.style.color='hsl(var(--text-muted))'; this.style.transform='translateY(0)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/></svg>
            </a>
            <a href="https://linktr.ee/dudukbaca" target="_blank" title="Linktree" style="color: hsl(var(--text-muted)); padding: 0.5rem; border-radius: 50%; background: #f1f5f9; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.background='#43e55e'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#f1f5f9'; this.style.color='hsl(var(--text-muted))'; this.style.transform='translateY(0)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            </a>
        </div>

        <p style="color: hsl(var(--text-muted))">&copy; {{ date('Y') }} Komunitas Literasi Malang. Hak Cipta Dilindungi.</p>
        <div style="margin-top: 1rem; font-size: 0.9rem; color: #94a3b8;">
            <a href="{{ route('page.struktur') }}" style="margin: 0 0.5rem;">Struktur</a> &middot;
            <a href="{{ route('page.jurnal') }}" style="margin: 0 0.5rem;">Jurnal</a> &middot;
            <a href="{{ route('opac.index') }}" style="margin: 0 0.5rem;">OPAC</a>
        </div>
    </footer>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize Lucide icons if used
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    mobileMenu.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
