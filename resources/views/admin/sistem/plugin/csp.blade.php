@extends('layouts.admin')

@section('pageTitle', 'Plugin - Content Security Policy (CSP)')

@section('content')

<x-form-card 
    title="Content Security Policy (CSP)" 
    icon="shield-alert" 
    action="{{ route('admin.sistem.plugin.csp.store') }}" 
    method="POST" 
    submitText="Simpan Konfigurasi CSP"
>
    
    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 0.75rem; padding: 1.25rem; display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 2rem;">
        <i data-lucide="alert-triangle" style="width: 1.5rem; height: 1.5rem; color: #d97706; flex-shrink: 0;"></i>
        <div>
            <h4 style="font-weight: 700; color: #92400e; margin-bottom: 0.25rem;">Peringatan Keamanan</h4>
            <p style="color: #b45309; font-size: 0.875rem; margin: 0; line-height: 1.5;">Hati-hati saat mengonfigurasi CSP. Kesalahan konfigurasi dapat menyebabkan fitur web berhenti berfungsi karena pemblokiran script atau sumber daya.</p>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1rem;">
        @php
            $fields = [
                'base_uri' => 'Base URI',
                'script_src' => 'Script Src',
                'style_src' => 'Style Src',
                'img_src' => 'Image Src',
                'connect_src' => 'Connect Src',
                'frame_src' => 'Frame Src',
                'font_src' => 'Font Src',
                'media_src' => 'Media Src',
                'object_src' => 'Object Src',
                'manifest_src' => 'Manifest Src',
                'worker_src' => 'Worker Src',
                'frame_ancestors' => 'Frame Ancestors',
            ];
        @endphp

        @foreach($fields as $key => $label)
        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
            <label class="form-label" style="font-size: 0.8rem; color: #64748b; margin-bottom: 0;">{{ $label }}</label>
            <input type="text" name="{{ $key }}" value="{{ $csp[$key] ?? '' }}" 
                   placeholder="Kosongkan jika default..."
                   class="form-input" style="font-family: monospace; font-size: 0.85rem;">
        </div>
        @endforeach
    </div>

</x-form-card>

@endsection

