@extends('layouts.admin')

@section('pageTitle', 'Form Pendaftaran Kegiatan')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Daftar Form Pendaftaran Kegiatan</h3>
        <a href="{{ route('admin.acara.pendaftaran.create') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="plus-circle" style="width: 1rem; height: 1rem;"></i> Buat Form Baru
        </a>
    </div>

    <!-- Table Data -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; width: 50px;">Aksi</th>
                    <th style="padding: 1rem 1.5rem;">Nama Form</th>
                    <th style="padding: 1rem 1.5rem;">Terkait Acara</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    <th style="padding: 1rem 1.5rem;">Pendaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($forms as $form)
                <tr data-href="{{ route('admin.acara.pendaftaran.edit', $form->id) }}" style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; text-align: center; display: flex; gap: 0.5rem; justify-content: center;">
                        <a href="{{ route('admin.acara.pendaftaran.edit', $form->id) }}" style="color: #3b82f6; text-decoration: none;" title="Edit Atribut Form">
                            <i data-lucide="edit" style="width: 1.1rem; height: 1.1rem;"></i>
                        </a>
                        <form action="{{ route('admin.acara.pendaftaran.destroy', $form->id) }}" method="POST" onsubmit="return confirm('Hapus form pendaftaran ini secara permanen? Seluruh pendaftar dan pertanyaan di dalamnya juga akan terhapus.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;" title="Hapus">
                                <i data-lucide="trash-2" style="width: 1.1rem; height: 1.1rem;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #1e293b; font-weight: 600;">
                        {{ $form->form_title }}
                        <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.acara.pendaftaran.builder', $form->id) }}" style="font-size: 0.75rem; background: #f8fafc; color: #475569; padding: 0.2rem 0.5rem; border-radius: 0.25rem; border: 1px solid #cbd5e1; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i data-lucide="layout-template" style="width: 0.8rem; height: 0.8rem;"></i> Atur Pertanyaan
                            </a>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $form->event->title ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($form->is_active)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Dibuka</span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Ditutup</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <a href="{{ route('admin.acara.pendaftaran.registrants', $form->id) }}" style="background: #3b82f6; color: white; padding: 0.35rem 0.75rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <i data-lucide="users" style="width: 0.9rem; height: 0.9rem;"></i> List Pendaftar
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8;">Belum ada data form pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($forms->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $forms->links() }}
    </div>
    @endif
</div>
@endsection

