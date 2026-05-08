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

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">{{ $title }}</h3>
        <div>
            @if($data->count() > 0)
            <form action="{{ $deleteAllRoute }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGHAPUS SEMUA data tak terpakai ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">
                    <i data-lucide="trash-2" style="width: 1rem; height: 1rem; display: inline-block; vertical-align: middle;"></i> Bersihkan Semua Data Tak Terpakai
                </button>
            </form>
            @endif
        </div>
    </div>

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
