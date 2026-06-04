@extends('layouts.admin')

@section('pageTitle', 'Subject List')

@section('content')

<x-master-file-dropdown type="terkendali" current="topic" />

<x-master-header 
    title="Subjek (Topics)" 
    subtitle="Kelola subjek dan topik untuk pengklasifikasian." 
    icon="tag"
    importRoute="admin.topic.import"
    exportRoute="admin.topic.export"
    createRoute="admin.topic.create"
    createLabel="Tambah Subjek"
/>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); overflow: hidden;">

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.topic.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Subject..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Subject</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Type</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Last Update</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topics as $topic)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">{{ $topic->topic }}</td>
                    <td style="padding: 1rem 1.5rem; color: #334155;">
                        @switch($topic->topic_type)
                            @case('t') Topic @break
                            @case('g') Geographic @break
                            @case('n') Name @break
                            @case('s') Temporal @break
                            @case('o') Occupation @break
                            @default Unknown
                        @endswitch
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $topic->last_update }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.topic.edit', $topic->topic_id) }}" style="background: #f1f5f9; color: #475569; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                                <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                Edit
                            </a>
                            <form action="{{ route('admin.topic.destroy', $topic->topic_id) }}" method="POST" onsubmit="return confirm('Hapus subjek ini?');">
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
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #64748b;">No subjects found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $topics->links() }}
    </div>
</div>
@endsection

