@extends('layouts.modern_landing')

@section('content')

<!-- Hero Section -->
<header style="padding: 6rem 1rem; text-align: center; background: radial-gradient(circle at center, rgba(235, 240, 255, 0.5) 0%, rgba(255,255,255,0) 70%); position: relative;">
    <div style="position: absolute; top: 1.5rem; right: 1.5rem;">
        <a href="{{ route('admin.login') }}" style="color: #64748b; font-size: 0.85rem; text-decoration: none; font-weight: 600; padding: 0.5rem 1rem; border-radius: 99px; background: rgba(255,255,255,0.5); border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='white'; this.style.color='#0f172a'" onmouseout="this.style.background='rgba(255,255,255,0.5)'; this.style.color='#64748b'">
            Librarian Login
        </a>
    </div>
    <div style="max-width: 800px; margin: 0 auto;">
        <span style="color: hsl(var(--primary)); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; display: block; margin-bottom: 1rem;">Welcome to Dudukbaca</span>
        <h1 style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 1.5rem; color: #0f172a; font-weight: 800; letter-spacing: -0.03em;">
            Find your next <span style="background: linear-gradient(120deg, hsl(var(--primary)), hsl(var(--accent))); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">favorite book</span>.
        </h1>
        <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 3rem; line-height: 1.6;">
            Access thousands of books, journals, and digital resources from our extensive library collection.
        </p>
        
        <form action="{{ route('opac.index') }}" method="GET" style="position: relative; max-width: 600px; margin: 0 auto;">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <input type="text" name="keywords" value="{{ request('keywords') }}" 
                style="width: 100%; padding: 1.25rem 2rem; border-radius: 99px; border: 1px solid #cbd5e1; font-size: 1.1rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); transition: all 0.3s; padding-right: 120px; outline: none;"
                placeholder="Search title, author, or ISBN...">
            <button type="submit" style="position: absolute; right: 8px; top: 8px; bottom: 8px; padding: 0 1.5rem; border-radius: 99px; background: #0f172a; color: white; border: none; font-weight: 600; cursor: pointer;">Search</button>
        </form>
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('landing') }}" style="display: inline-block; font-size: 0.9rem; color: #475569; font-weight: 600; text-decoration: none; padding-bottom: 2px; border-bottom: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.color='#0f172a'; this.style.borderColor='#0f172a'" onmouseout="this.style.color='#475569'; this.style.borderColor='transparent'">
                &larr; Kembali ke Beranda Komunitas
            </a>
        </div>
    </div>
</header>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
        <div>
            @if(request('keywords'))
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b;">Results for "{{ request('keywords') }}"</h2>
                <a href="{{ route('opac.index') }}" style="color: hsl(var(--primary)); font-size: 0.9rem; font-weight: 600;">Clear Search</a>
            @else
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b;">Fresh Arrivals</h2>
                <p style="color: #64748b;">The latest additions to our shelves.</p>
            @endif
        </div>
        
        <!-- Filter Tabs -->
        <div style="display: flex; gap: 0.5rem; background: #f1f5f9; padding: 0.25rem; border-radius: 0.5rem;">
            <a href="{{ route('opac.index', array_merge(request()->query(), ['type' => null])) }}" 
               style="padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; font-weight: 600; {{ !request('type') ? 'background: white; color: #0f172a; box-shadow: 0 1px 3px rgba(0,0,0,0.1);' : 'color: #64748b;' }}">
                Semua Koleksi
            </a>
            <a href="{{ route('opac.index', array_merge(request()->query(), ['type' => 'fisik'])) }}" 
               style="padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; font-weight: 600; {{ request('type') == 'fisik' ? 'background: white; color: #0f172a; box-shadow: 0 1px 3px rgba(0,0,0,0.1);' : 'color: #64748b;' }}">
                Koleksi Fisik
            </a>
            <a href="{{ route('opac.index', array_merge(request()->query(), ['type' => 'digital'])) }}" 
               style="padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; font-weight: 600; {{ request('type') == 'digital' ? 'background: white; color: #0f172a; box-shadow: 0 1px 3px rgba(0,0,0,0.1);' : 'color: #64748b;' }}">
                E-Digital
            </a>
        </div>
    </div>

    <div id="opac-results">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 2.5rem;">
            @forelse($biblios as $biblio)
                <article style="background: white; border-radius: 1rem; overflow: hidden; height: 100%; transition: all 0.3s; position: relative; border: 1px solid transparent;"
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)'; this.style.borderColor='#e2e8f0';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='transparent';">
                     
                    <a href="{{ route('opac.show', $biblio->biblio_id) }}" style="display: block; text-decoration: none; height: 100%; display: flex; flex-direction: column;">
                        
                        <!-- Cover Image -->
                        <div style="aspect-ratio: 2/3; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; border-bottom: 1px solid #f1f5f9;">
                            @if($biblio->image && file_exists(public_path('images/' . $biblio->image)))
                                <img src="{{ asset('images/' . $biblio->image) }}" alt="{{ $biblio->title }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            @else
                                <div style="text-align: center; color: #94a3b8; padding: 1rem;">
                                    <div style="font-size: 3rem; margin-bottom: 0.5rem; opacity: 0.5;">📖</div>
                                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">No Cover</div>
                                </div>
                            @endif
                            
                            <!-- Hover Overlay -->
                            <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15,23,42,0.6), transparent); opacity: 0; transition: 0.3s; display: flex; align-items: flex-end; padding: 1.5rem;"
                                 onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                                 <span style="color: white; font-weight: 700; font-size: 0.875rem; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); padding: 0.5rem 1rem; border-radius: 99px;">View Details</span>
                            </div>
                        </div>
    
                        <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $biblio->title }}
                            </h3>
                            
                            <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.5rem;">
                                {{ $biblio->authors->first()->author_name ?? 'Unknown Author' }}
                            </div>
    
                            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                                <span style="font-size: 0.8rem; font-weight: 600; color: #94a3b8;">{{ $biblio->publish_year }}</span>
                                <span style="font-size: 0.8rem; font-weight: 700; color: hsl(var(--primary));">View Details &rarr;</span>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: white; border-radius: 1rem; border: 1px dashed #cbd5e1;">
                    <p style="font-size: 1.2rem; color: #64748b;">No books found. Try a different search.</p>
                </div>
            @endforelse
        </div>
    
        <div style="margin-top: 4rem;">
            {{ $biblios->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Event delegation for pagination links
        document.body.addEventListener('click', (e) => {
            const link = e.target.closest('#opac-results nav a');
            if (link) {
                e.preventDefault();
                const url = link.href;
                fetchOpacResults(url);
            }
        });

        function fetchOpacResults(url) {
            const container = document.getElementById('opac-results');
            container.style.opacity = '0.5'; // Visual feedback

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('opac-results').innerHTML;
                    
                    container.innerHTML = newContent;
                    container.style.opacity = '1';
                    
                    // Scroll to top of results smoothly
                    document.querySelector('.container').scrollIntoView({ behavior: 'smooth' });
                })
                .catch(err => {
                    console.error('Pagination error:', err);
                    container.style.opacity = '1';
                    window.location.href = url; // Fallback
                });
        }
    });
</script>
@endsection
