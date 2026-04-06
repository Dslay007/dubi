@extends('layouts.admin')

@section('pageTitle', 'Item Manager & Barcodes')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Physical Items</h3>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
             <a href="{{ route('admin.item.import') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Import</a>
            <a href="{{ route('admin.item.export') }}" class="btn" style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Export</a>
            <span style="font-size: 0.875rem; color: #64748b; margin-left: 1rem;">Select items to print barcodes</span>
        </div>
    </div>

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.item.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 500px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Item Code or Book Title..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <form action="{{ route('admin.item.print_barcodes') }}" method="POST" target="_blank">
        @csrf
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 40px;">
                            <input type="checkbox" onclick="toggleAll(this)">
                        </th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Item Code</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Title</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Call Number</th>
                        <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Location</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 1rem 1.5rem;">
                            <input type="checkbox" name="items[]" value="{{ $item->item_id }}" class="item-checkbox">
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">{{ $item->item_code }}</td>
                        <td style="padding: 1rem 1.5rem; color: #334155;">{{ $item->biblio->title ?? 'Unknown Title' }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->call_number ?? '-' }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->location_id ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">No items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; position: sticky; bottom: 0;">
            <div style="font-size: 0.875rem; color: #64748b;">
                {{ $items->total() }} items total
            </div>
            
            <div style="display: flex; gap: 1rem; align-items: center;">
                <button type="submit" class="btn" style="padding: 0.75rem 2rem; background: #0f172a; color: white; border: none; border-radius: 0.375rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="printer"></i> Generate Barcodes
                </button>
            </div>
        </div>
    </form>
    
    <div style="padding: 1rem 1.5rem;">
        {{ $items->links() }}
    </div>
</div>

<script>
    function toggleAll(source) {
        checkboxes = document.getElementsByClassName('item-checkbox');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
@endsection
