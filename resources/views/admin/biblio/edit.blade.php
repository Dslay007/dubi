@extends('layouts.admin')

@section('pageTitle', 'Edit Book')

@section('content')

@php
    $allAuthors = \App\Models\Author::orderBy('author_name')->get(['author_id', 'author_name'])->map(function($a) {
        return ['id' => $a->author_id, 'name' => $a->author_name];
    });
    $allTopics = \App\Models\Topic::orderBy('topic')->get(['topic_id', 'topic'])->map(function($t) {
        return ['id' => $t->topic_id, 'name' => $t->topic];
    });
    
    $levels = [
        '1' => 'Pengarang Utama',
        '2' => 'Pengarang Tambahan',
        '3' => 'Penyunting (Editor)',
        '4' => 'Penerjemah',
        '5' => 'Sutradara',
        '6' => 'Produser',
        '7' => 'Komposer',
        '8' => 'Ilustrator'
    ];
    $existingAuthors = $biblio->authors->map(function($a) use ($levels) {
        return [
            'id' => $a->author_id,
            'name' => $a->author_name,
            'level' => strval($a->pivot->level ?? '1'),
            'levelName' => $levels[$a->pivot->level ?? '1'] ?? 'Pengarang Utama'
        ];
    });
    
    $existingTopicIds = $biblio->topics->pluck('topic_id')->map(fn($id) => strval($id))->toArray();

    // Auto-generate next item code (Pattern: DB00001)
    $lastItem = \App\Models\Item::where('item_code', 'like', 'DB%')->orderBy('item_code', 'desc')->first();
    $nextCode = 'DB00001';
    if ($lastItem) {
        $lastNumber = (int) substr($lastItem->item_code, 2);
        $nextCode = 'DB' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }
@endphp

<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">Edit Data Bibliografi</h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0; margin-top: 0.25rem;">Perbarui detail buku, kelola pengarang, dan tambah eksemplar fisik buku ini.</p>
    </div>

    <form id="biblioForm" action="{{ route('admin.biblio.update', $biblio->biblio_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Section 1: Informasi Dasar -->
        <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white);">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="book-open" style="color: #3b82f6;"></i> Informasi Utama</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Judul Buku *</label>
                    <input type="text" name="title" value="{{ old('title', $biblio->title) }}" required class="form-input">
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">Penanggung Jawab (Statement of Responsibility)</label>
                        <input type="text" name="sor" value="{{ old('sor', $biblio->sor) }}" class="form-input">
                    </div>
                    <div>
                         <label class="form-label">Judul Seri</label>
                        <input type="text" name="series_title" value="{{ old('series_title', $biblio->series_title) }}" class="form-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">Edisi</label>
                        <input type="text" name="edition" value="{{ old('edition', $biblio->edition) }}" class="form-input">
                    </div>
                    <div>
                         <label class="form-label">Info Detail Spesifik</label>
                        <input type="text" name="spec_detail_info" value="{{ old('spec_detail_info', $biblio->spec_detail_info) }}" class="form-input">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <div style="grid-column: 1 / -1;">
                         <label class="form-label">Kolasi (Deskripsi Fisik)</label>
                         <input type="text" name="collation" value="{{ old('collation', $biblio->collation) }}" class="form-input">
                    </div>
                </div>
                
                <div>
                     <label class="form-label">Catatan</label>
                     <textarea name="notes" rows="3" class="form-input">{{ old('notes', $biblio->notes) }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Section 2: Publikasi & Klasifikasi -->
        <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2rem; position: relative;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="building-2" style="color: #3b82f6;"></i> Penerbitan & Klasifikasi</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">Penerbit</label>
                        <select name="publisher_id" class="form-input">
                            <option value="">-- Pilih Penerbit --</option>
                            @foreach(\App\Models\Publisher::all() as $pub)
                                <option value="{{ $pub->publisher_id }}" {{ $biblio->publisher_id == $pub->publisher_id ? 'selected' : '' }}>{{ $pub->publisher_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="publish_year" value="{{ old('publish_year', $biblio->publish_year) }}" class="form-input">
                    </div>
                     <div>
                        <label class="form-label">Tempat Terbit</label>
                        <select name="publish_place_id" class="form-input">
                            <option value="">-- Pilih Tempat --</option>
                            @foreach(\App\Models\Place::all() as $place)
                                <option value="{{ $place->place_id }}" {{ $biblio->publish_place_id == $place->place_id ? 'selected' : '' }}>{{ $place->place_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">ISBN/ISSN</label>
                        <input type="text" name="isbn_issn" value="{{ old('isbn_issn', $biblio->isbn_issn) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Nomor Panggil (Call Number)</label>
                        <input type="text" name="call_number" value="{{ old('call_number', $biblio->call_number) }}" class="form-input">
                    </div>
                     <div>
                        <label class="form-label">Klasifikasi (DDC)</label>
                        <input type="text" name="classification" value="{{ old('classification', $biblio->classification) }}" class="form-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label class="form-label">GMD (Bentuk Karya)</label>
                        <select name="gmd_id" class="form-input">
                             @foreach(\App\Models\Gmd::all() as $gmd)
                                <option value="{{ $gmd->gmd_id }}" {{ $biblio->gmd_id == $gmd->gmd_id ? 'selected' : '' }}>{{ $gmd->gmd_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                         <label class="form-label">Bahasa</label>
                         <select name="language" class="form-input">
                            <option value="id" {{ $biblio->language == 'id' ? 'selected' : '' }}>Indonesian</option>
                            <option value="en" {{ $biblio->language == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ $biblio->language == 'ar' ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                </div>
                
                <!-- Authors & Topics Dynamic Section via Alpine.js -->
                <div x-data="{
                        authors: {{ json_encode($allAuthors) }},
                        topics: {{ json_encode($allTopics) }},
                        
                        // Topic Search
                        topicSearch: '',
                        selectedTopics: {{ json_encode($existingTopicIds) }},
                        get filteredTopics() {
                            if (this.topicSearch === '') return this.topics;
                            return this.topics.filter(t => t.name.toLowerCase().includes(this.topicSearch.toLowerCase()));
                        },
                        
                        // Dynamic Authors
                        showAuthorModal: false,
                        authorSearch: '',
                        selectedAuthorId: '',
                        selectedAuthorLevel: '1',
                        addedAuthors: {{ json_encode($existingAuthors) }}, 
                        
                        levels: {
                            '1': 'Pengarang Utama',
                            '2': 'Pengarang Tambahan',
                            '3': 'Penyunting (Editor)',
                            '4': 'Penerjemah',
                            '5': 'Sutradara',
                            '6': 'Produser',
                            '7': 'Komposer',
                            '8': 'Ilustrator'
                        },
                        
                        get filteredAuthors() {
                            if (this.authorSearch === '') return this.authors.slice(0, 50);
                            return this.authors.filter(a => a.name.toLowerCase().includes(this.authorSearch.toLowerCase())).slice(0, 50);
                        },
                        
                        addAuthor() {
                            if (!this.selectedAuthorId) return;
                            const author = this.authors.find(a => a.id == this.selectedAuthorId);
                            if (author) {
                                if (!this.addedAuthors.find(a => a.id == author.id)) {
                                    this.addedAuthors.push({
                                        id: author.id,
                                        name: author.name,
                                        level: this.selectedAuthorLevel,
                                        levelName: this.levels[this.selectedAuthorLevel]
                                    });
                                }
                            }
                            this.showAuthorModal = false;
                            this.selectedAuthorId = '';
                            this.authorSearch = '';
                            this.selectedAuthorLevel = '1';
                        },
                        
                        removeAuthor(id) {
                            this.addedAuthors = this.addedAuthors.filter(a => a.id != id);
                        }
                    }" 
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 0.5rem; border-top: 1px dashed #e2e8f0; padding-top: 1.5rem;">
                    
                    <div>
                        <!-- Hidden inputs for authors form submission -->
                        <template x-for="(author, index) in addedAuthors" :key="author.id">
                            <div>
                                <input type="hidden" :name="`authors[${index}][id]`" :value="author.id">
                                <input type="hidden" :name="`authors[${index}][level]`" :value="author.level">
                            </div>
                        </template>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <label class="form-label" style="margin: 0;">Penulis / Pengarang</label>
                            <button type="button" @click="showAuthorModal = true" style="background: #e0f2fe; color: #0284c7; border: none; padding: 0.35rem 0.75rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.25rem;"><i data-lucide="plus" style="width: 1rem; height: 1rem;"></i> Tambah Pengarang</button>
                        </div>
                        <div style="border: 2px solid #e2e8f0; border-radius: 0.75rem; background: #f8fafc; min-height: 150px;">
                            <template x-if="addedAuthors.length === 0">
                                <div style="padding: 2rem 1rem; text-align: center; color: #94a3b8; font-size: 0.9rem; font-style: italic;">
                                    Belum ada pengarang ditambahkan.
                                </div>
                            </template>
                            <template x-for="author in addedAuthors" :key="author.id">
                                <div style="padding: 0.75rem 1rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: white; border-radius: 0.5rem; margin: 0.25rem;">
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b; font-size: 0.95rem;" x-text="author.name"></div>
                                        <div style="font-size: 0.8rem; color: #64748b;" x-text="author.levelName"></div>
                                    </div>
                                    <button type="button" @click="removeAuthor(author.id)" style="background: #fee2e2; color: #ef4444; border: none; padding: 0.35rem; border-radius: 0.375rem; cursor: pointer; display: flex; align-items: center; justify-content: center; min-width: 32px; min-height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Author Modal -->
                        <div x-show="showAuthorModal" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 99999;" x-cloak>
                            <div @click.outside="showAuthorModal = false" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 1rem; width: 100%; max-width: 500px; padding: 1.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); max-height: 90vh; overflow-y: auto;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0 0 1.5rem 0;">Tambah Data Pengarang</h3>
                                
                                <div style="margin-bottom: 1rem;">
                                    <label class="form-label">Cari Pengarang</label>
                                    <input type="text" x-model="authorSearch" placeholder="Ketik nama pengarang..." class="form-input" style="margin-bottom: 0.5rem;">
                                    <select x-model="selectedAuthorId" class="form-input" size="5" style="padding: 0.5rem; height: auto;">
                                        <template x-for="author in filteredAuthors" :key="author.id">
                                            <option :value="author.id" x-text="author.name" style="padding: 0.25rem;"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div style="margin-bottom: 1.5rem;">
                                    <label class="form-label">Peran (Role)</label>
                                    <select x-model="selectedAuthorLevel" class="form-input">
                                        <template x-for="(name, val) in levels">
                                            <option :value="val" x-text="name"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                    <button type="button" @click="showAuthorModal = false" style="padding: 0.5rem 1rem; background: #f1f5f9; color: #475569; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600;">Batal</button>
                                    <button type="button" @click="addAuthor()" style="padding: 0.5rem 1.5rem; background: #3b82f6; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600;">Tambahkan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label" style="margin-bottom: 0.5rem; display: block;">Topik / Subjek</label>
                        <div style="border: 2px solid #e2e8f0; border-radius: 0.75rem; background: #f8fafc; padding: 1rem; display: flex; flex-direction: column; gap: 1rem; max-height: 250px;">
                            <input type="text" x-model="topicSearch" placeholder="Cari topik..." class="form-input" style="flex-shrink: 0; padding: 0.5rem 0.75rem;">
                            
                            <div style="overflow-y: auto; flex-grow: 1; padding-right: 0.5rem;">
                                <template x-for="topic in filteredTopics" :key="topic.id">
                                    <div style="margin-bottom: 0.5rem;">
                                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; color: #334155; font-size: 0.95rem;">
                                            <input type="checkbox" name="topic_id[]" :value="topic.id" style="width: 1.25rem; height: 1.25rem; accent-color: #3b82f6;" x-model="selectedTopics">
                                            <span x-text="topic.name"></span>
                                        </label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Media & Digital -->
        <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2rem; position: relative;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="image" style="color: #3b82f6;"></i> Media & Arsip Digital</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
                
                <div style="background: #f0f9ff; padding: 1.5rem; border-radius: 0.75rem; border: 1px dashed #7dd3fc;">
                    <h4 style="font-weight: 700; color: #0369a1; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="image-plus" style="width: 1.25rem;"></i> Cover Buku</h4>
                    
                    @if($biblio->image)
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: white; border: 1px solid #bae6fd; border-radius: 0.75rem; display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 60px; height: 80px; border-radius: 0.375rem; overflow: hidden; border: 1px solid #e2e8f0; flex-shrink: 0;">
                            @if(\str_starts_with($biblio->image, 'http'))
                                <img src="{{ $biblio->image }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/' . $biblio->image) }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">Cover Saat Ini</div>
                            <div style="font-size: 0.8rem; color: #64748b; word-break: break-all;">{{ $biblio->image }}</div>
                        </div>
                    </div>
                    @endif

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label class="form-label" style="color: #0369a1;">Ganti Gambar Baru</label>
                            <input type="file" name="image" accept="image/*" class="form-input" style="background: white; border-color: #bae6fd; cursor: pointer;">
                        </div>
                        <div>
                            <label class="form-label" style="color: #0369a1;">Atau Tautan URL Gambar</label>
                            <input type="url" name="image_url" placeholder="https://" value="{{ \str_starts_with($biblio->image ?? '', 'http') ? $biblio->image : '' }}" class="form-input" style="border-color: #bae6fd;">
                        </div>
                    </div>
                </div>

                <div style="background: #fdf4ff; padding: 1.5rem; border-radius: 0.75rem; border: 1px dashed #f5d0fe;">
                    <h4 style="font-weight: 700; color: #86198f; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="file-up" style="width: 1.25rem;"></i> E-Digital / File Lampiran</h4>
                    <p style="font-size: 0.85rem; color: #a21caf; margin-bottom: 1rem;">Unggah file e-book (PDF/EPUB) atau masukkan tautan eksternal (Google Drive, dll) untuk mengubah yang ada.</p>
                    
                    @if($biblio->file_att)
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: white; border: 1px solid #f5d0fe; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; border-radius: 0.5rem; background: #fae8ff; color: #c026d3; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="file-check" style="width: 1.25rem;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">File Saat Ini</div>
                            <div style="font-size: 0.8rem; color: #64748b; word-break: break-all;">
                                @if(\str_starts_with($biblio->file_att, 'http'))
                                    <a href="{{ $biblio->file_att }}" target="_blank" style="color: #2563eb; text-decoration: underline;">{{ $biblio->file_att }}</a>
                                @else
                                    {{ $biblio->file_att }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label class="form-label" style="color: #86198f;">Ganti File (Max 50MB)</label>
                            <input type="file" name="file_att_upload" accept=".pdf,.epub" class="form-input" style="background: white; border-color: #e879f9; cursor: pointer;">
                        </div>
                        <div>
                            <label class="form-label" style="color: #86198f;">Atau Link URL E-Book</label>
                            <input type="url" name="file_att_link" placeholder="https://" value="{{ \str_starts_with($biblio->file_att ?? '', 'http') ? $biblio->file_att : '' }}" class="form-input" style="border-color: #e879f9;">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center; justify-content: flex-end; margin-bottom: 3rem;">
            <a href="{{ route('admin.biblio.index') }}" style="padding: 0.75rem 2rem; background: white; border: 1px solid #cbd5e1; color: #475569; text-decoration: none; border-radius: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9'"><i data-lucide="x" style="width: 1.25rem;"></i> Batal</a>
            <button type="submit" style="padding: 0.75rem 2.5rem; background: #3b82f6; color: white; border: none; border-radius: 0.75rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'"><i data-lucide="save" style="width: 1.25rem;"></i> Simpan Pembaruan Bibliografi</button>
        </div>
    </form>
    
    <!-- Section 4: Daftar Eksemplar -->
    <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2rem; position: relative;" x-data="{ showItemModal: false, itemCode: '', autoCode: '{{ $nextCode }}' }">
        <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f0fdf4, white); display: flex; justify-content: space-between; align-items: center; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="layers" style="color: #10b981;"></i> Daftar Eksemplar (Fisik Buku)</h2>
                <p style="margin: 0; font-size: 0.85rem; color: #64748b; margin-top: 0.25rem;">Kelola fisik buku dari bibliografi ini.</p>
            </div>
            <button type="button" @click="showItemModal = true" style="background: #10b981; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="plus-circle" style="width: 1rem;"></i> Tambah Eksemplar Baru</button>
        </div>
        
        <div style="padding: 1.5rem; overflow-x: auto;">
            @if($biblio->items->count() > 0)
                <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                            <th style="padding: 0.75rem 1rem; color: #475569; font-size: 0.85rem; font-weight: 600;">Barcode/Eksemplar</th>
                            <th style="padding: 0.75rem 1rem; color: #475569; font-size: 0.85rem; font-weight: 600;">No. Inventaris</th>
                            <th style="padding: 0.75rem 1rem; color: #475569; font-size: 0.85rem; font-weight: 600;">Status</th>
                            <th style="padding: 0.75rem 1rem; color: #475569; font-size: 0.85rem; font-weight: 600;">Tipe Koleksi</th>
                            <th style="padding: 0.75rem 1rem; color: #475569; font-size: 0.85rem; font-weight: 600; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($biblio->items as $item)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 0.75rem 1rem; font-family: monospace; font-weight: 600; color: #0f172a;">{{ $item->item_code }}</td>
                            <td style="padding: 0.75rem 1rem; color: #64748b; font-size: 0.9rem;">{{ $item->inventory_code ?? '-' }}</td>
                            <td style="padding: 0.75rem 1rem;">
                                <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                                    {{ $item->status->item_status_name ?? 'Tersedia' }}
                                </span>
                            </td>
                            <td style="padding: 0.75rem 1rem; color: #64748b; font-size: 0.9rem;">
                                {{ \App\Models\CollType::where('coll_type_id', $item->coll_type_id)->value('coll_type_name') ?? 'Textbook' }}
                            </td>
                            <td style="padding: 0.75rem 1rem; text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="{{ route('admin.item.edit', $item->item_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.35rem 0.75rem; border-radius: 0.375rem; font-size: 0.85rem; font-weight: 600; text-decoration: none;">Sunting</a>
                                
                                <form action="{{ route('admin.item.destroy', $item->item_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus eksemplar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 0.35rem 0.75rem; border-radius: 0.375rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                    <i data-lucide="inbox" style="width: 3rem; height: 3rem; margin: 0 auto 1rem auto; opacity: 0.5;"></i>
                    <p style="margin: 0; font-size: 0.95rem;">Buku ini belum memiliki Eksemplar Fisik.</p>
                </div>
            @endif
        </div>
        
        <!-- Modal Tambah Eksemplar (Outside main form) -->
        <div x-show="showItemModal" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 99999;" x-cloak>
            <div @click.outside="showItemModal = false" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 1rem; width: 100%; max-width: 600px; padding: 1.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); max-height: 90vh; overflow-y: auto;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0 0 1.5rem 0;">Tambah Eksemplar Baru</h3>
                
                <form action="{{ route('admin.item.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="biblio_id" value="{{ $biblio->biblio_id }}">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label class="form-label">Kode Eksemplar / Barcode *</label>
                            <div style="display: flex; gap: 0.5rem; align-items: stretch;">
                                <input type="text" name="item_code" x-model="itemCode" required class="form-input" style="border-color: #3b82f6; background: #eff6ff; flex-grow: 1;">
                                <button type="button" @click="itemCode = autoCode" style="padding: 0 0.75rem; background: #e0f2fe; color: #0284c7; border: none; border-radius: 0.375rem; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#bae6fd'" onmouseout="this.style.background='#e0f2fe'">Auto</button>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">No. Inventaris</label>
                            <input type="text" name="inventory_code" class="form-input">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label class="form-label">Lokasi Ruang / Rak</label>
                            <select name="location_id" class="form-input">
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Models\Location::all() as $loc)
                                    <option value="{{ $loc->location_id }}">{{ $loc->location_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Tipe Koleksi</label>
                            <select name="coll_type_id" class="form-input">
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Models\CollType::all() as $ct)
                                    <option value="{{ $ct->coll_type_id }}">{{ $ct->coll_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label class="form-label">Sumber Pengadaan</label>
                            <select name="source" class="form-input">
                                <option value="0">Beli (Purchase)</option>
                                <option value="1">Hadiah / Hibah</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Tanggal Penerimaan</label>
                            <input type="date" name="received_date" class="form-input" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                        <button type="button" @click="showItemModal = false" style="padding: 0.5rem 1rem; background: #f1f5f9; color: #475569; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600;">Batal</button>
                        <button type="submit" style="padding: 0.5rem 1.5rem; background: #10b981; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 0.25rem;"><i data-lucide="plus" style="width: 1rem;"></i> Simpan Eksemplar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

