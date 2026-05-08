@extends('layouts.admin')

@section('pageTitle', 'Plugin - Content Security Policy (CSP)')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0;">
        <h3 style="font-weight: 700; color: #1e293b; font-size: 1.25rem;">CSP (Content Security Policy)</h3>
    </div>

    <form action="{{ route('admin.sistem.plugin.csp.store') }}" method="POST" style="padding: 1.5rem;">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.25rem; border: none; border-radius: 0.25rem; font-weight: 600; font-size: 0.875rem;">Simpan Pengaturan</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0;">
            @php
                $fields = [
                    'base_uri' => 'Base Uri',
                    'script_src' => 'Script Src',
                    'style_src' => 'Style Src',
                    'img_src' => 'Img Src',
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
            <div style="display: flex; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                <label style="width: 200px; font-weight: 600; font-size: 0.875rem; color: #1e293b;">{{ $label }}</label>
                <div style="width: 20px; color: #94a3b8;">:</div>
                <input type="text" name="{{ $key }}" value="{{ $csp[$key] }}" 
                    style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; font-size: 0.875rem; color: #475569; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='#93c5fd'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            @endforeach
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.25rem; border: none; border-radius: 0.25rem; font-weight: 600; font-size: 0.875rem;">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection
