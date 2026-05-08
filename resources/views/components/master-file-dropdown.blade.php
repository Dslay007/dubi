@props(['type' => 'terkendali', 'current' => 'gmd'])

@php
    $menus = [
        'terkendali' => [
            'gmd' => ['label' => 'GMD', 'url' => route('admin.gmd.index')],
            'tipe_isi' => ['label' => 'Tipe Isi', 'url' => route('admin.content_type.index')],
            'tipe_media' => ['label' => 'Tipe Media', 'url' => route('admin.media_type.index')],
            'tipe_pembawa' => ['label' => 'Tipe Pembawa', 'url' => route('admin.carrier_type.index')],
            'publisher' => ['label' => 'Penerbit', 'url' => route('admin.publisher.index')],
            'agen' => ['label' => 'Agen', 'url' => route('admin.supplier.index')],
            'author' => ['label' => 'Pengarang', 'url' => route('admin.author.index')],
            'topic' => ['label' => 'Subjek', 'url' => route('admin.topic.index')],
            'lokasi' => ['label' => 'Lokasi', 'url' => route('admin.location.index')],
        ],
        'referensi' => [
            'place' => ['label' => 'Tempat', 'url' => route('admin.place.index')],
            'item_status' => ['label' => 'Status Eksemplar', 'url' => route('admin.item_status.index')],
            'tipe_koleksi' => ['label' => 'Tipe Koleksi', 'url' => route('admin.coll_type.index')],
            'bahasa_dokumen' => ['label' => 'Bahasa Dokumen', 'url' => route('admin.language.index')],
            'label' => ['label' => 'Label', 'url' => route('admin.label.index')],
            'kala_terbit' => ['label' => 'Kala Terbit', 'url' => route('admin.frequency.index')],
        ],
        'peralatan' => [
            'ruang_pengunjung' => ['label' => 'Ruang Pengunjung', 'url' => route('admin.visitor.index')],
            'manajemen_komentar' => ['label' => 'Manajemen Komentar', 'url' => route('admin.comment.index')],
            'peladen_salin_katalog' => ['label' => 'Peladen Salin Katalog', 'url' => route('admin.server.index')],
            'pola_kode_eksemplar' => ['label' => 'Pola Kode Eksemplar', 'url' => route('admin.setting.item_pattern')],
            'data_pengarang_tak_terpakai' => ['label' => 'Data Pengarang Tak Terpakai', 'url' => route('admin.orphan.index', 'author')],
            'data_subjek_tak_terpakai' => ['label' => 'Data Subjek Tak Terpakai', 'url' => route('admin.orphan.index', 'topic')],
            'data_penerbit_tak_terpakai' => ['label' => 'Data Penerbit Tak Terpakai', 'url' => route('admin.orphan.index', 'publisher')],
            'data_tempat_terbit_tak_terpakai' => ['label' => 'Data Tempat Terbit Tak Terpakai', 'url' => route('admin.orphan.index', 'place')],
        ]
    ];

    $options = $menus[$type] ?? [];
@endphp

<div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; background: white; padding: 1rem 1.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
    <label for="master-file-select" style="font-weight: 600; color: #475569; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
        <i data-lucide="layers" style="width: 1.25rem; height: 1.25rem;"></i>
        Pilih Modul:
    </label>
    <select id="master-file-select" onchange="window.location.href=this.value" style="padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; min-width: 280px; font-family: inherit; font-size: 0.95rem; color: #1e293b; outline: none; background: #f8fafc; cursor: pointer;">
        @foreach($options as $key => $option)
            <option value="{{ $option['url'] }}" {{ $current === $key ? 'selected' : '' }}>
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
</div>
