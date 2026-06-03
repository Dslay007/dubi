@extends('layouts.modern_landing')

@section('title', 'Struktur Komunitas | Duduk Baca')

@section('content')
<section style="padding: 6rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 5rem;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">Struktur Komunitas</h2>
            <p style="color: #64748b; font-size: 1.1rem;">Orang-orang di balik layar yang menggerakkan roda literasi Duduk Baca.</p>
        </div>

        <!-- Founders -->
        <div style="margin-bottom: 5rem;">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: hsl(var(--primary)); margin-bottom: 2rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e2e8f0; display: inline-block;">
                Founder
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem;">
                @foreach($founders as $index => $founder)
                <div style="background: white; padding: 2rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center; transition: 0.2s;" onmouseover="this.style.boxShadow='0 10px 20px -5px rgba(0,0,0,0.05)'" onmouseout="this.style.boxShadow='none'">
                    @if($founder->photo)
                        <img src="{{ asset('uploads/struktur/' . $founder->photo) }}" alt="{{ $founder->title }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; border: 4px solid #f0f9ff;">
                    @else
                        <img src="https://placehold.co/150x150/14b8a6/ffffff?text=F{{ $index+1 }}" alt="{{ $founder->title }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; border: 4px solid #f0f9ff;">
                    @endif
                    <h4 style="font-weight: 700; color: #0f172a; font-size: 1.1rem;">{{ $founder->name ?: $founder->title }}</h4>
                    <span style="display: block; font-size: 0.85rem; color: hsl(var(--primary)); font-weight: 600; margin-top: 0.25rem;">{{ $founder->subtitle }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Core Team -->
        <div style="margin-bottom: 5rem;">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: hsl(var(--primary)); margin-bottom: 2rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e2e8f0; display: inline-block;">
                Anggota Inti
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem;">
                @foreach($cores as $core)
                <div style="background: white; padding: 2rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center; position: relative; overflow: hidden; transition: 0.2s;" onmouseover="this.style.boxShadow='0 10px 20px -5px rgba(0,0,0,0.05)'" onmouseout="this.style.boxShadow='none'">
                    <div style="width: 100%; height: 5px; background: hsl(var(--accent)); position: absolute; top: 0; left: 0;"></div>
                    @if($core->photo)
                        <img src="{{ asset('uploads/struktur/' . $core->photo) }}" alt="{{ $core->subtitle }}" style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 1rem; object-fit: cover;">
                    @else
                        <img src="https://placehold.co/150x150/3b82f6/ffffff?text={{ $core->title }}" alt="{{ $core->subtitle }}" style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 1rem; object-fit: cover;">
                    @endif
                    <h4 style="font-weight: 700; color: #0f172a;">{{ $core->name ?: '-' }}</h4>
                    <span style="font-size: 0.85rem; color: #64748b;">{{ $core->subtitle }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Divisions -->
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: hsl(var(--primary)); margin-bottom: 2rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e2e8f0; display: inline-block;">
                Divisi Komunitas
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                
                @forelse($divisions as $divisi)
                <div x-data="{ open: false }" style="background: white; border-radius: 1rem; border: 1px solid #e2e8f0; overflow: hidden; transition: 0.2s;" onmouseover="this.style.boxShadow='0 10px 20px -5px rgba(0,0,0,0.05)'" onmouseout="this.style.boxShadow='none'">
                    <!-- Header -->
                    <div @click="open = !open" style="padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer; user-select: none; background: linear-gradient(to right, hsl(var(--primary)/0.05), transparent); border-left: 4px solid hsl(var(--primary));">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div>
                                <h4 style="font-size: 1.1rem; font-weight: 800; color: hsl(var(--primary)); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">{{ $divisi->title }}</h4>
                            </div>
                        </div>
                        <i data-lucide="chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.2s; color: hsl(var(--primary));"></i>
                    </div>
                    
                    <!-- Accordion Body -->
                    <div x-show="open" x-transition style="padding: 0 1.5rem 1.5rem 1.5rem; border-top: 1px dashed #e2e8f0;" x-cloak>
                        <div style="margin-top: 1.5rem;">
                            <div style="margin-bottom: 1rem;">
                                <span style="display: block; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Koordinator</span>
                                <span style="font-weight: 600; color: #0f172a;">{{ $divisi->name ?: '-' }}</span>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <span style="display: block; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Wakil Koordinator</span>
                                <span style="font-weight: 600; color: #0f172a;">{!! $divisi->vice_name ? str_replace([',', ';'], '<br>', e($divisi->vice_name)) : '-' !!}</span>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Anggota</span>
                                <span style="font-size: 0.9rem; color: #475569; line-height: 1.5;">{!! $divisi->members_list ? str_replace([',', ';'], '<br>', nl2br(e($divisi->members_list))) : '-' !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 2rem;">
                    Belum ada data divisi komunitas.
                </div>
                @endforelse

            </div>
        </div>

    </div>
</section>
        </div>
    </div>
</section>
@endsection
