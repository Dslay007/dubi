@extends('layouts.admin')

@section('pageTitle', 'Tipe Pembawa')

@section('content')

<x-master-file-dropdown type="terkendali" current="tipe_pembawa" />

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Daftar Tipe Pembawa</h3>
        <div>
            <a href="{{ route('admin.carrier_type.import') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; margin-right: 0.5rem;">Import CSV</a>
            <a href="{{ route('admin.carrier_type.export') }}" class="btn" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; margin-right: 0.5rem;">Export CSV</a>
            <a href="{{ route('admin.carrier_type.create') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none;">+ Add Tipe Pembawa</a>
        </div>
    </div>

    <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <form action="{{ route('admin.carrier_type.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Tipe Pembawa or Code..." 
                style="flex: 1; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #64748b; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Search</button>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">ID</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Tipe Pembawa</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Kode</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Last Update</th>
                    <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($carrierTypes as $item)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->id }}</td>
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1e293b;">{{ $item->carrier_type }}</td>
                    <td style="padding: 1rem 1.5rem; color: #334155;">{{ $item->code }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $item->last_update }}</td>
                    <td style="padding: 1rem 1.5rem; display: flex; gap: 0.5rem;">
                         <a href="{{ route('admin.carrier_type.edit', $item->id) }}" style="color: #3b82f6; font-weight: 500; text-decoration: none;">Edit</a>
                        <form action="{{ route('admin.carrier_type.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">No data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $carrierTypes->links() }}
    </div>
</div>
@endsection
