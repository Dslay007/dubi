@extends('layouts.admin')

@section('pageTitle', 'Subject List')

@section('content')

<x-master-file-dropdown type="terkendali" current="topic" />

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Master File: Subjects</h3>
        <div>
            <a href="{{ route('admin.topic.import') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; margin-right: 0.5rem;">Import CSV</a>
            <a href="{{ route('admin.topic.export') }}" class="btn" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; margin-right: 0.5rem;">Export CSV</a>
            <a href="{{ route('admin.topic.create') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">+ Add New Subject</a>
        </div>
    </div>

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
                    <td style="padding: 1rem 1.5rem; display: flex; gap: 0.5rem;">
                         <a href="{{ route('admin.topic.edit', $topic->topic_id) }}" style="color: #3b82f6; font-weight: 500; text-decoration: none;">Edit</a>
                        <form action="{{ route('admin.topic.destroy', $topic->topic_id) }}" method="POST" onsubmit="return confirm('Delete this subject?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                        </form>
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
