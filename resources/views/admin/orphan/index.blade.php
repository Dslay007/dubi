@extends('layouts.admin')

@section('pageTitle', $title)

@section('content')

@php
    $currentMenu = '';
    if($type == 'author') $currentMenu = 'data_pengarang_tak_terpakai';
    if($type == 'topic') $currentMenu = 'data_subjek_tak_terpakai';
    if($type == 'publisher') $currentMenu = 'data_penerbit_tak_terpakai';
    if($type == 'place') $currentMenu = 'data_tempat_terbit_tak_terpakai';
@endphp

<x-master-file-dropdown type="peralatan" :current="$currentMenu" />

<x-master-header 
    title="{{ $title }}" 
    subtitle="Kelola data master yang tidak lagi terikat dengan bibliografi manapun." 
    icon="database"
>
    @if($data->count() > 0)
    <form action="{{ $deleteAllRoute }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGHAPUS SEMUA data tak terpakai ini secara permanen?');" style="margin:0;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(239,68,68,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i> Bersihkan Semua
        </button>
    </form>
    @endif
</x-master-header>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.orphan.index', $type) }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    @foreach($columns as $header => $field)
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">{{ $header }}</th>
                    @endforeach
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    @foreach($columns as $header => $field)
                    <td style="padding: 1rem 1.5rem; color: #1e293b;">{{ $item->$field }}</td>
                    @endforeach
                    <td style="padding: 1rem 1.5rem;">
                        <form action="{{ route($deleteRoutePrefix, $item->$idKey) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" style="padding: 2rem; text-align: center; color: #64748b;">
                        Sistem bersih! Tidak ada data yatim/tak terpakai ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $data->links() }}
    </div>
</div>
@endsection

