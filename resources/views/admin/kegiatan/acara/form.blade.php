@extends('layouts.admin')

@section('pageTitle', $event ? 'Edit Acara' : 'Tambah Acara Baru')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.kegiatan.acara.index') }}" style="width: 2.5rem; height: 2.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
            <i data-lucide="arrow-left" style="width: 1.25rem; height: 1.25rem;"></i>
        </a>
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $event ? 'Edit Acara/Kampanye' : 'Tambah Acara/Kampanye' }}</h1>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0; margin-top: 0.25rem;">Buat kampanye besar untuk ditampilkan di halaman beranda.</p>
        </div>
    </div>

    @if ($errors->any())
    <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem;">
        <div style="font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="alert-circle" style="width: 1.25rem; height: 1.25rem;"></i>
            Terdapat Kesalahan
        </div>
        <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05); overflow: hidden;">
        <form action="{{ $event ? route('admin.kegiatan.acara.update', $event->id) : route('admin.kegiatan.acara.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($event)
                @method('PUT')
            @endif

            <div style="padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Judul -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Judul Acara <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required placeholder="Contoh: Open Volunteer Batch 9" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Deskripsi Kampanye <span style="color: #ef4444;">*</span></label>
                    <textarea name="description" rows="5" required placeholder="Tuliskan ajakan bergabung atau detail kampanye..." style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; resize: vertical;">{{ old('description', $event->description ?? '') }}</textarea>
                </div>

                <!-- Link Pendaftaran -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Tautan Form Pendaftaran</label>
                    <div style="position: relative;">
                        <i data-lucide="link" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; width: 1.25rem; height: 1.25rem;"></i>
                        <input type="url" name="registration_link" value="{{ old('registration_link', $event->registration_link ?? '') }}" placeholder="Contoh: https://forms.gle/..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem;">
                    </div>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem; margin-bottom: 0;">Link eksternal (Google Form, Typeform, dll) tempat pengunjung mendaftar. Sistem akan melacak jumlah klik ke link ini.</p>
                </div>

                <!-- Unggah Foto -->
                <div style="padding: 1.5rem; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 0.75rem;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Foto Utama Acara (Banner)</label>
                    
                    @if($event && $event->photos)
                        @php
                            $photos = json_decode($event->photos, true);
                        @endphp
                        <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            @foreach($photos as $photo)
                                <img src="{{ asset('uploads/acara/' . $photo) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                            @endforeach
                        </div>
                        <p style="font-size: 0.8rem; color: #f59e0b; margin-bottom: 0.5rem;">* Mengunggah foto baru akan menimpa foto-foto yang sudah ada di atas.</p>
                    @endif
                    
                    <input type="file" name="photos[]" multiple accept="image/*" style="width: 100%; padding: 0.5rem; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; font-family: inherit; font-size: 0.9rem; cursor: pointer;">
                    
                    <ul style="font-size: 0.8rem; color: #64748b; margin-top: 0.75rem; margin-bottom: 0; padding-left: 1.5rem;">
                        <li>Anda dapat memilih <strong>lebih dari 1 foto sekaligus</strong> (tekan Ctrl/Cmd saat memilih).</li>
                        <li>Jika diunggah 1 foto, halaman depan menampilkannya statis.</li>
                        <li>Jika diunggah > 1 foto, halaman depan menampilkannya sebagai <em>Carousel</em> (Gambar Geser).</li>
                        <li>Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB/foto.</li>
                    </ul>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div style="padding: 1.5rem 2rem; background: rgba(248, 250, 252, 0.5); border-top: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.kegiatan.acara.index') }}" style="padding: 0.75rem 1.5rem; color: #475569; text-decoration: none; font-weight: 600; border-radius: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" style="padding: 0.75rem 2rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 99px; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.3); cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    <i data-lucide="save" style="width: 1.25rem; height: 1.25rem;"></i>
                    Simpan Acara
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

