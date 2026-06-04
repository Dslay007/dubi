@extends('layouts.admin')

@section('pageTitle', 'Place List')

@section('content')

<x-master-file-dropdown type="referensi" current="place" />

<x-master-header 
    title="Tempat Terbit (Places)" 
    subtitle="Kelola tempat/kota terbit bahan pustaka." 
    icon="map-pin"
    importRoute="admin.place.import"
    exportRoute="admin.place.export"
    createRoute="admin.place.create"
    createLabel="Tambah Tempat"
/>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.place.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Place..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Place Name</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Last Update</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($places as $place)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">{{ $place->place_name }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $place->last_update }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.place.edit', $place->place_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                                <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                Edit
                            </a>
                            <form action="{{ route('admin.place.destroy', $place->place_id) }}" method="POST" onsubmit="return confirm('Hapus tempat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white; border: 1px solid #fecaca; color: #ef4444; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='white';">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 2rem; text-align: center; color: #64748b;">No places found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $places->links() }}
    </div>
</div>
@endsection

