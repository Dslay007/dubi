@extends('layouts.admin')

@section('pageTitle', 'Bibliography')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Book List</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.biblio.import') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Import</a>
            <a href="{{ route('admin.biblio.export') }}" class="btn" style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Export</a>
            <a href="{{ route('admin.biblio.create') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">+ Add New Book</a>
        </div>
    </div>

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.biblio.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or ISBN..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Title</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Author</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Publisher</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Publish Year</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($biblios as $biblio)
                <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.1s;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">
                        {{ $biblio->title }}
                        <div style="font-size: 0.75rem; color: #94a3b8; font-weight: normal;">ISBN: {{ $biblio->isbn_issn }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #334155;">
                        @foreach($biblio->authors as $author)
                            <div>{{ $author->author_name }}</div>
                        @endforeach
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">
                        {{ optional($biblio->publisher)->publisher_name ?? '-' }}
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">
                        {{ $biblio->publish_year }}
                    </td>
                    <td style="padding: 1rem 1.5rem; display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.biblio.edit', $biblio->biblio_id) }}" style="color: #3b82f6; font-weight: 500; text-decoration: none;">Edit</a>
                        
                        <form action="{{ route('admin.biblio.destroy', $biblio->biblio_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">
                        No books found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($biblios->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $biblios->links() }}
    </div>
    @endif
</div>
@endsection
