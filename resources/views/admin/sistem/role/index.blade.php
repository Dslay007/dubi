@extends('layouts.admin')

@section('pageTitle', 'Role and Permission')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Role and Permission</h3>
        <div>
            <a href="{{ route('admin.sistem.role.import') }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; margin-right: 0.5rem;">Import CSV</a>
            <a href="{{ route('admin.sistem.role.export') }}" class="btn" style="background: #64748b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; margin-right: 0.5rem;">Export CSV</a>
            <a href="{{ route('admin.sistem.role.create') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">+ Tambah Role</a>
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem;">Role Name</th>
                    <th style="padding: 1rem 1.5rem; width: 300px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1e293b;">{{ $role->group_name }}</td>
                    <td style="padding: 1rem 1.5rem; text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('admin.sistem.role.permissions', $role->group_id) }}" class="btn" style="background: #10b981; color: white; padding: 0.4rem 0.75rem; border-radius: 0.375rem; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; font-weight: 500;">
                                <i data-lucide="shield-check" style="width: 0.9rem; height: 0.9rem;"></i> Atur Hak Akses
                            </a>
                            <a href="{{ route('admin.sistem.role.edit', $role->group_id) }}" class="btn" style="background: #3b82f6; color: white; padding: 0.4rem 0.75rem; border-radius: 0.375rem; font-size: 0.8rem; text-decoration: none; font-weight: 500;">
                                Edit
                            </a>
                            @if($role->group_id != 1)
                            <form action="{{ route('admin.sistem.role.destroy', $role->group_id) }}" method="POST" onsubmit="return confirm('Hapus role ini beserta semua hak aksesnya?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.4rem 0.75rem; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer; font-weight: 500;">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
