@extends('layouts.modern_landing')

@section('content')

<style>
    .opac-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        align-items: start;
    }
    .opac-sidebar {
        position: relative;
    }
    @media (min-width: 768px) {
        .opac-grid {
            grid-template-columns: 300px 1fr;
            gap: 3rem;
        }
        .opac-sidebar {
            position: sticky;
            top: 100px;
        }
    }
</style>
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
    <a href="{{ url('/') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem; font-weight: 500; color: #64748b;">
        &larr; Kembali ke Katalog
    </a>

    <div class="opac-grid">
        
        <!-- Sidebar: Image -->
        <div class="opac-sidebar">
            <div style="background: white; padding: 1rem; border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                @if($biblio->image)
                    @if(\str_starts_with($biblio->image, 'http'))
                        <img src="{{ $biblio->image }}" alt="{{ $biblio->title }}" style="width: 100%; border-radius: 0.5rem;">
                    @else
                        <img src="{{ asset('images/docs/' . $biblio->image) }}" alt="{{ $biblio->title }}" style="width: 100%; border-radius: 0.5rem;">
                    @endif
                @else
                    <div style="aspect-ratio: 2/3; background: #f1f5f9; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: #94a3b8;">
                        📚
                    </div>
                @endif
            </div>

            @if($biblio->isbn_issn)
            <div style="margin-top: 1.5rem; padding: 1rem; background: #eff6ff; border-radius: 0.5rem; color: #1e40af; font-size: 0.9rem; font-weight: 500; text-align: center; word-break: break-word; overflow-wrap: anywhere;">
                ISBN: {{ $biblio->isbn_issn }}
            </div>
            @endif
        </div>

        <!-- Main Content -->
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; line-height: 1.2; margin-bottom: 1rem;">
                {{ $biblio->title }}
            </h1>

            <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem;">
                @foreach($biblio->authors as $author)
                    <span style="background: #e2e8f0; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 600; color: #475569;">
                        👤 {{ $author->author_name }}
                    </span>
                @endforeach
                <span style="display: flex; align-items: center; color: #64748b;">
                    📅 {{ $biblio->publish_year }}
                </span>
                <span style="display: flex; align-items: center; color: #64748b;">
                    🏢 {{ $biblio->publisher->publisher_name ?? 'Penerbit Tidak Diketahui' }}
                </span>
            </div>

            <!-- Detail Informasi (SLiMS Style) -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow-x: auto;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.5rem;">Detail Informasi</h3>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; color: #475569;">
                    <tbody>
                        @if($biblio->series_title)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Judul Seri</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->series_title }}</td>
                        </tr>
                        @endif
                        @if($biblio->call_number)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">No. Panggil</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->call_number }}</td>
                        </tr>
                        @endif
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Penerbit</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">
                                {{ $biblio->place->place_name ?? '' }} : {{ $biblio->publisher->publisher_name ?? 'Penerbit Tidak Diketahui' }}., {{ $biblio->publish_year }}
                            </td>
                        </tr>
                        @if($biblio->collation)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Deskripsi Fisik</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->collation }}</td>
                        </tr>
                        @endif
                        @if($biblio->language_id)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Bahasa</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->language_id }}</td>
                        </tr>
                        @endif
                        @if($biblio->isbn_issn)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">ISBN/ISSN</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->isbn_issn }}</td>
                        </tr>
                        @endif
                        @if($biblio->classification)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Klasifikasi</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->classification }}</td>
                        </tr>
                        @endif
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Tipe Isi</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->gmd->gmd_name ?? 'Text' }}</td>
                        </tr>
                        @if($biblio->edition)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Edisi</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->edition }}</td>
                        </tr>
                        @endif
                        @if($biblio->topics->isNotEmpty())
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Subyek</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">
                                @foreach($biblio->topics as $topic)
                                    {{ $topic->topic }}{{ !$loop->last ? ' ; ' : '' }}
                                @endforeach
                            </td>
                        </tr>
                        @endif
                        @if($biblio->spec_detail_info)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Info Detail Spesifik</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->spec_detail_info }}</td>
                        </tr>
                        @endif
                        @if($biblio->sor)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600; vertical-align: top;">Pernyataan Tanggungjawab</td>
                            <td style="padding: 0.75rem 0; color: #1e293b;">{{ $biblio->sor }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Description / Notes -->
            @if($biblio->notes)
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #334155; margin-bottom: 0.75rem;">Deskripsi</h3>
                <div style="color: #475569; line-height: 1.8;">
                    {{ $biblio->notes }}
                </div>
            </div>
            @endif

            <!-- E-Digital Access -->
            @if($biblio->file_att)
            <div style="margin-bottom: 3rem; background: #f8fafc; border: 1px solid #bfdbfe; border-radius: 0.75rem; padding: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e3a8a; margin-bottom: 1rem;">E-Digital Format</h3>
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div style="color: #475569;">
                        Buku ini tersedia dalam format digital.
                    </div>
                    
                    @if(Auth::guard('member')->check())
                        @if(\str_starts_with($biblio->file_att, 'http'))
                            <a href="{{ $biblio->file_att }}" target="_blank" style="display: inline-block; padding: 0.75rem 1.5rem; background: #059669; color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#047857'" onmouseout="this.style.background='#059669'">
                                🔗 Kunjungi / Buka Tautan
                            </a>
                        @else
                            <a href="{{ route('digital.download', $biblio->biblio_id) }}" target="_blank" style="display: inline-block; padding: 0.75rem 1.5rem; background: #2563eb; color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                                📥 Baca / Download E-Book
                            </a>
                        @endif
                    @else
                        <div style="text-align: right;">
                            <span style="font-size: 0.875rem; color: #dc2626; display: block; margin-bottom: 0.5rem; font-weight: 500;">
                                Anda harus login sebagai member untuk membaca.
                            </span>
                            <a href="{{ route('login') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #e2e8f0; color: #0f172a; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                                Login Member
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Availability Section -->
            @if(session('success'))
                <div style="margin-bottom: 1rem; padding: 1rem; background: #dcfce7; color: #166534; border-radius: 0.5rem; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="margin-bottom: 1rem; padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 0.5rem; font-weight: 500;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div style="margin-bottom: 3rem;">
                @php
                    $itemStatuses = [];
                    $hasAvailableCopy = false;
                    foreach ($biblio->items as $itemCopy) {
                        $onLoan = \App\Models\Loan::where('item_code', $itemCopy->item_code)->where('is_return', 0)->exists();
                        $isReserved = \App\Models\Reservation::where('item_code', $itemCopy->item_code)->whereIn('status', ['pending', 'approved'])->exists();
                        $noLoan = optional($itemCopy->status)->no_loan;

                        if ($onLoan) {
                            $itemStatuses[$itemCopy->item_code] = 'loan';
                        } elseif ($isReserved) {
                            $itemStatuses[$itemCopy->item_code] = 'reserved';
                        } elseif ($noLoan) {
                            $itemStatuses[$itemCopy->item_code] = 'no_loan';
                        } else {
                            $itemStatuses[$itemCopy->item_code] = 'available';
                            $hasAvailableCopy = true;
                        }
                    }
                @endphp

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #334155; margin-bottom: 0;">Ketersediaan Eksemplar</h3>
                    @if($biblio->is_reservable)
                        @if($hasAvailableCopy)
                            @if(Auth::guard('member')->check())
                                <form action="{{ route('opac.reserve', $biblio->biblio_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="padding: 0.5rem 1rem; background: #6366f1; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                                        📅 Reservasi Buku
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" style="padding: 0.5rem 1rem; background: #e2e8f0; color: #475569; border-radius: 0.5rem; text-decoration: none; font-weight: 600; font-size: 0.875rem;">Login untuk Reservasi</a>
                            @endif
                        @else
                            @php
                                $allOnLoan = true;
                                foreach($itemStatuses as $status) {
                                    if($status !== 'loan') $allOnLoan = false;
                                }
                            @endphp
                            <span style="padding: 0.5rem 1rem; background: #fef2f2; color: #dc2626; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; border: 1px solid #fecaca;">
                                {{ $allOnLoan ? 'Semua eksemplar sedang dipinjam' : 'Buku saat ini tidak tersedia untuk direservasi' }}
                            </span>
                        @endif
                    @endif
                </div>
                
                @if($biblio->items->count() > 0)
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <tr>
                                <th style="text-align: left; padding: 1rem; font-weight: 600; color: #475569;">Kode Eksemplar</th>
                                <th style="text-align: left; padding: 1rem; font-weight: 600; color: #475569;">Lokasi</th>
                                <th style="text-align: left; padding: 1rem; font-weight: 600; color: #475569;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($biblio->items as $item)
                            @php $realStatus = $itemStatuses[$item->item_code] ?? 'available'; @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 1rem; font-family: monospace; font-size: 1.1em;">{{ $item->item_code }}</td>
                                <td style="padding: 1rem; color: #64748b;">{{ $item->location_id ?? 'Koleksi Umum' }}</td>
                                <td style="padding: 1rem;">
                                    @if($realStatus === 'available')
                                        <span style="color: #059669; font-weight: 700; background: #ecfdf5; padding: 0.3rem 0.85rem; border-radius: 99px; font-size: 0.85rem; border: 1px solid #a7f3d0;">
                                            ✓ Tersedia
                                        </span>
                                    @elseif($realStatus === 'loan')
                                        <span style="color: #dc2626; font-weight: 700; background: #fef2f2; padding: 0.3rem 0.85rem; border-radius: 99px; font-size: 0.85rem; border: 1px solid #fecaca;">
                                            ✗ Sedang Dipinjam
                                        </span>
                                    @elseif($realStatus === 'reserved')
                                        <span style="color: #7c3aed; font-weight: 700; background: #f5f3ff; padding: 0.3rem 0.85rem; border-radius: 99px; font-size: 0.85rem; border: 1px solid #ddd6fe;">
                                            ◷ Sudah Direservasi
                                        </span>
                                    @elseif($realStatus === 'no_loan')
                                        <span style="color: #475569; font-weight: 700; background: #f1f5f9; padding: 0.3rem 0.85rem; border-radius: 99px; font-size: 0.85rem; border: 1px solid #e2e8f0;">
                                            {{ optional($item->status)->item_status_name ?? 'Tidak Tersedia' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div style="padding: 1rem; background: #fff1f2; color: #be123c; border-radius: 0.5rem; border: 1px solid #fecdd3;">
                        Tidak ada salinan fisik yang tercatat dalam sistem.
                    </div>
                @endif
            </div>

            <!-- Topics -->
            @if($biblio->topics->isNotEmpty())
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #334155; margin-bottom: 1rem;">Topik</h3>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    @foreach($biblio->topics as $topic)
                        <a href="{{ route('opac.index', ['keywords' => $topic->topic]) }}" style="padding: 0.4rem 1rem; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; color: #475569; text-decoration: none; transition: all 0.2s;">
                            # {{ $topic->topic }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
