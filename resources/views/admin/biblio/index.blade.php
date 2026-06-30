@extends('layouts.admin')

@section('pageTitle', 'Bibliografi')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #ec4899;"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
            Daftar Bibliografi
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Kelola data buku, eksemplar, dan sumber referensi perpustakaan.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.biblio.import') }}" class="btn" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#fef3c7';" onmouseout="this.style.background='#fffbeb';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            Import
        </a>
        <a href="{{ route('admin.biblio.export') }}" class="btn" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#d1fae5';" onmouseout="this.style.background='#ecfdf5';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Export
        </a>
        <a href="{{ route('admin.biblio.create') }}" class="btn" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(236,72,153,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Buku
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
        <form action="{{ route('admin.biblio.index') }}" method="GET" style="display: flex; gap: 0.75rem; width: 100%; flex-wrap: wrap; align-items: center;">
            <div style="position: relative;">
                <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau ISBN..." 
                    style="padding: 0.6rem 1rem 0.6rem 2.5rem; border: 2px solid #e2e8f0; border-radius: 99px; outline: none; width: 280px; font-family: inherit; font-size: 0.9rem; transition: 0.2s;" onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236,72,153,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            
            <button type="submit" style="padding: 0.6rem 1.25rem; background: #0f172a; color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#1e293b';" onmouseout="this.style.background='#0f172a';">Filter</button>
            <a href="{{ route('admin.biblio.index') }}" style="padding: 0.6rem 1.25rem; background: white; color: #64748b; border: 2px solid #e2e8f0; border-radius: 99px; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">Reset</a>
        </form>
    </div>

    <div style="overflow-x: auto; padding: 1rem 2rem;">
        <table data-visible-cols="1" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); width: 80px;">Cover</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Judul & ISBN</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Pengarang</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Penerbit</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Tahun Terbit</th>
                    <th style="padding: 1rem; border-bottom: 2px solid rgba(0,0,0,0.05); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($biblios as $biblio)
                <tr data-href="{{ route('admin.biblio.edit', $biblio->biblio_id) }}" style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 1rem;">
                        @if($biblio->image)
                            <img src="{{ asset('images/docs/' . $biblio->image) }}" alt="Cover" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        @else
                            <div style="width: 50px; height: 70px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <i data-lucide="image" style="width: 20px; height: 20px;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        <div style="font-weight: 800; color: #1e293b; margin-bottom: 0.25rem;">{{ $biblio->title }}</div>
                        <div style="color: #64748b; font-size: 0.8rem; font-family: monospace; letter-spacing: 0.05em;">
                            ISBN: {{ $biblio->isbn_issn ?: '-' }}
                        </div>
                    </td>
                    <td class="mobile-force-hide" style="padding: 1.25rem 1rem;">
                        @if($biblio->authors->count() > 0)
                            <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                                @foreach($biblio->authors as $author)
                                    <div style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.85rem; background: #f1f5f9; padding: 0.2rem 0.6rem; border-radius: 99px; width: fit-content; border: 1px solid #e2e8f0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        {{ $author->author_name }}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; color: #475569; font-weight: 500;">
                        {{ optional($biblio->publisher)->publisher_name ?? '-' }}
                    </td>
                    <td style="padding: 1.25rem 1rem;">
                        @if($biblio->publish_year)
                            <span style="background: #eff6ff; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.75rem; border: 1px solid #bfdbfe;">
                                {{ $biblio->publish_year }}
                            </span>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.biblio.edit', $biblio->biblio_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.biblio.destroy', $biblio->biblio_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini? Semua data yang terkait akan hilang.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white; border: 1px solid #fecaca; color: #ef4444; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#fef2f2';">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem 2rem; text-align: center;">
                        <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                        </div>
                        <h4 style="font-weight: 800; color: #475569; font-size: 1.1rem; margin-bottom: 0.25rem;">Tidak Ada Data</h4>
                        <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Tidak ada bibliografi yang ditemukan berdasarkan pencarian.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($biblios->hasPages())
    <div style="padding: 1rem 2rem 2rem 2rem;">
        {{ $biblios->links() }}
    </div>
    @endif
</div>
@endsection

