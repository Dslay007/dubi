@extends('layouts.admin')

@section('pageTitle', $agenda ? 'Edit Agenda' : 'Tambah Agenda Baru')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.kegiatan.agenda.index') }}" style="width: 2.5rem; height: 2.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
            <i data-lucide="arrow-left" style="width: 1.25rem; height: 1.25rem;"></i>
        </a>
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $agenda ? 'Edit Agenda' : 'Tambah Agenda' }}</h1>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0; margin-top: 0.25rem;">Isi detail jadwal kegiatan/lapak komunitas.</p>
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
        <form action="{{ $agenda ? route('admin.kegiatan.agenda.update', $agenda->id) : route('admin.kegiatan.agenda.store') }}" method="POST">
            @csrf
            @if($agenda)
                @method('PUT')
            @endif

            <div style="padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Judul -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Judul Kegiatan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $agenda->title ?? '') }}" required placeholder="Contoh: Lapak Baca Alun-Alun Edisi Kemerdekaan" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Tanggal -->
                    <div>
                        <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Tanggal <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="event_date" value="{{ old('event_date', $agenda ? $agenda->event_date->format('Y-m-d') : '') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem;">
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $agenda->location ?? '') }}" placeholder="Contoh: Alun-Alun Malang" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem;">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Deskripsi</label>
                    <textarea name="description" rows="5" placeholder="Tuliskan ringkasan singkat kegiatan ini..." style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; resize: vertical;">{{ old('description', $agenda->description ?? '') }}</textarea>
                </div>

                <!-- Dokumentasi -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Tautan Dokumentasi</label>
                    <div style="position: relative;">
                        <i data-lucide="link" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; width: 1.25rem; height: 1.25rem;"></i>
                        <input type="url" name="documentation_link" value="{{ old('documentation_link', $agenda->documentation_link ?? '') }}" placeholder="Contoh: https://drive.google.com/..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem;">
                    </div>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem; margin-bottom: 0;">Masukkan link Google Drive, folder foto, atau artikel yang berisi dokumentasi jika acara sudah selesai.</p>
                </div>

                <!-- Status -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Status Publikasi</label>
                    <select name="is_active" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit; font-size: 0.95rem; background: white;">
                        <option value="1" {{ old('is_active', $agenda->is_active ?? true) == true ? 'selected' : '' }}>Publikasikan (Tampil di Website)</option>
                        <option value="0" {{ old('is_active', $agenda->is_active ?? true) == false ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                    </select>
                </div>

            </div>

            <!-- Footer Buttons -->
            <div style="padding: 1.5rem 2rem; background: rgba(248, 250, 252, 0.5); border-top: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.kegiatan.agenda.index') }}" style="padding: 0.75rem 1.5rem; color: #475569; text-decoration: none; font-weight: 600; border-radius: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" style="padding: 0.75rem 2rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 99px; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.3); cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    <i data-lucide="save" style="width: 1.25rem; height: 1.25rem;"></i>
                    Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

