@extends('layouts.modern_landing')

@section('title', 'Jurnal Lapak | Duduk Baca')

@section('content')
<section style="padding: 6rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">Jurnal Lapak</h2>
            <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Berita, dokumentasi, dan pengumuman terbaru dari kegiatan komunitas Duduk Baca.</p>
        </div>

        <!-- Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.5rem; margin-bottom: 3rem;">
            @forelse($jurnals as $jurnal)
            <article style="background: white; border-radius: 1.5rem; overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                @if($jurnal->cover_image)
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('uploads/jurnal/' . $jurnal->cover_image) }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </div>
                @else
                <div style="height: 200px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <i data-lucide="image" style="width: 3rem; height: 3rem;"></i>
                </div>
                @endif
                
                <div style="padding: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <span style="background: rgba(14, 165, 233, 0.1); color: #0284c7; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">{{ $jurnal->category ?? 'Berita' }}</span>
                        <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">
                            {{ $jurnal->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem; line-height: 1.4;">
                        {{ $jurnal->title }}
                    </h3>
                    <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        {{ Str::limit(strip_tags($jurnal->content), 120) }}
                    </p>
                    
                    <a href="{{ route('page.jurnal.detail', $jurnal->id) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #0f172a; font-weight: 700; text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='hsl(var(--primary))'" onmouseout="this.style.color='#0f172a'">
                        Baca Selengkapnya
                        <i data-lucide="arrow-right" style="width: 1rem; height: 1rem;"></i>
                    </a>
                </div>
            </article>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 4rem;">
                <i data-lucide="newspaper" style="width: 4rem; height: 4rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem;">Belum Ada Jurnal</h3>
                <p>Nantikan berita dan cerita terbaru dari komunitas kami.</p>
            </div>
            @endforelse
        </div>

        @if($jurnals->hasPages())
        <div style="display: flex; justify-content: center;">
            {{ $jurnals->links() }}
        </div>
        @endif
    </div>
    </div>
</section>
@endsection
