@extends('layouts.modern_landing')

@section('title', $jurnal->title . ' | Duduk Baca')

@section('content')
<section style="padding: 6rem 1rem;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <a href="{{ route('page.jurnal') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; font-weight: 600; text-decoration: none; margin-bottom: 2rem; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
            <i data-lucide="arrow-left" style="width: 1.2rem; height: 1.2rem;"></i>
            Kembali ke Jurnal
        </a>

        <!-- Header -->
        <div style="margin-bottom: 3rem;">
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                <span style="background: rgba(14, 165, 233, 0.1); color: #0284c7; padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ $jurnal->category ?? 'Berita' }}
                </span>
                <span style="color: #64748b; font-size: 0.95rem; font-weight: 600;">
                    {{ $jurnal->created_at->format('d M Y') }}
                </span>
            </div>
            
            <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; line-height: 1.2;">
                {{ $jurnal->title }}
            </h1>
        </div>

        <!-- Cover Image -->
        @if($jurnal->cover_image)
        <div style="border-radius: 1.5rem; overflow: hidden; margin-bottom: 3rem; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);">
            <img src="{{ asset('uploads/jurnal/' . $jurnal->cover_image) }}" alt="{{ $jurnal->title }}" style="width: 100%; height: auto; display: block;">
        </div>
        @endif

        <!-- Content -->
        <div class="jurnal-content" style="color: #334155; font-size: 1.1rem; line-height: 1.8;">
            {!! $jurnal->content !!}
        </div>

        <style>
            .jurnal-content p { margin-bottom: 1.5rem; }
            .jurnal-content img { max-width: 100%; height: auto; border-radius: 1rem; margin: 2rem 0; }
            .jurnal-content h2, .jurnal-content h3 { color: #0f172a; font-weight: 800; margin: 2.5rem 0 1rem; line-height: 1.3; }
            .jurnal-content a { color: #3b82f6; text-decoration: underline; }
            .jurnal-content blockquote { border-left: 4px solid #cbd5e1; padding-left: 1rem; color: #64748b; font-style: italic; margin: 2rem 0; }
        </style>
    </div>
</section>
@endsection
