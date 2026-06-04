@extends('layouts.admin')

@section('pageTitle', 'Pendaftar: ' . $form->form_title)

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">Data Pendaftar</h3>
            <p style="color: #64748b; font-size: 0.875rem;">Acara: {{ $form->event->title ?? '-' }}</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.acara.pendaftaran.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1;">
                <i data-lucide="arrow-left" style="width: 1rem; height: 1rem;"></i> Kembali
            </a>
            <button type="button" class="btn" onclick="alert('MOCKUP: Fitur Export Spreadsheet (CSV/Excel) belum diimplementasikan backend-nya.');" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer;">
                <i data-lucide="sheet" style="width: 1rem; height: 1rem;"></i> Export Data (Excel)
            </button>
        </div>
    </div>

    <!-- Table Data -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; width: 50px;">Aksi</th>
                    <th style="padding: 1rem 1.5rem;">Waktu Daftar</th>
                    <th style="padding: 1rem 1.5rem;">Nama & Email</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    @foreach($form->fields as $field)
                        <th style="padding: 1rem 1.5rem;">{{ $field->field_label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($form->registrants as $reg)
                <tr style="border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                    <td style="padding: 1rem 1.5rem;">
                        @if($reg->status === 'pending')
                            <form action="{{ route('admin.acara.pendaftaran.registrants.confirm', $reg->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn" onclick="return confirm('MOCKUP: Konfirmasi pendaftar ini dan kirim email pemberitahuan?');" style="background: #3b82f6; color: white; padding: 0.35rem 0.5rem; border: none; border-radius: 0.25rem; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.25rem;">
                                    <i data-lucide="mail-check" style="width: 0.8rem; height: 0.8rem;"></i> Konfirmasi
                                </button>
                            </form>
                        @else
                            <span style="font-size: 0.75rem; color: #166534; display: flex; align-items: center; gap: 0.25rem;">
                                <i data-lucide="check-circle-2" style="width: 0.8rem; height: 0.8rem;"></i> Selesai
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.8rem;">{{ $reg->registered_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 0.25rem;">{{ $reg->name }}</div>
                        <div style="color: #64748b; font-size: 0.8rem;">{{ $reg->email }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($reg->status === 'confirmed')
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Dikonfirmasi</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Pending</span>
                        @endif
                    </td>
                    
                    <!-- Dynamic Answers -->
                    @foreach($form->fields as $field)
                        @php
                            $answer = $reg->answers->where('field_id', $field->id)->first();
                        @endphp
                        <td style="padding: 1rem 1.5rem; color: #475569;">
                            {{ $answer ? $answer->answer_value : '-' }}
                        </td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ 4 + $form->fields->count() }}" style="padding: 2rem; text-align: center; color: #94a3b8;">Belum ada pendaftar untuk form ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

