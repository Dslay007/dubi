@extends('layouts.admin')

@section('pageTitle', 'Grup Pengguna')

@section('content')

<x-master-header 
    title="Grup Pengguna (Roles)" 
    subtitle="Kelola grup pengguna sistem dan tentukan hak akses masing-masing grup." 
    icon="shield"
>
    <a href="{{ route('admin.sistem.role.import') }}" class="btn" style="background: white; color: #10b981; border: 2px solid #a7f3d0; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#ecfdf5';" onmouseout="this.style.background='white';">
        <i data-lucide="upload" style="width: 16px; height: 16px;"></i> Import
    </a>
    <a href="{{ route('admin.sistem.role.export') }}" class="btn" style="background: white; color: #334155; border: 2px solid #cbd5e1; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
        <i data-lucide="download" style="width: 16px; height: 16px;"></i> Export
    </a>
    <a href="{{ route('admin.sistem.role.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
        <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Tambah Role
    </a>
</x-master-header>
    
<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05);">Nama Role (Grup)</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); width: 350px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr data-href="{{ route('admin.sistem.role.edit', $role->group_id) }}" style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                    <td style="padding: 1.25rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background: {{ $role->group_id == 1 ? 'linear-gradient(135deg, #f59e0b, #d97706)' : '#f1f5f9' }}; color: {{ $role->group_id == 1 ? 'white' : '#64748b' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="{{ $role->group_id == 1 ? 'shield-alert' : 'users' }}" style="width: 1.25rem; height: 1.25rem;"></i>
                            </div>
                            <span style="font-weight: 700; color: #0f172a; font-size: 1rem;">{{ $role->group_name }}</span>
                        </div>
                    </td>
                    <td style="padding: 1.25rem 1.5rem; text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('admin.sistem.role.permissions', $role->group_id) }}" class="btn" style="background: #ecfdf5; color: #059669; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-weight: 700; transition: 0.2s;" onmouseover="this.style.background='#d1fae5';">
                                <i data-lucide="shield-check" style="width: 14px; height: 14px;"></i> Atur Hak Akses
                            </a>
                            <a href="{{ route('admin.sistem.role.edit', $role->group_id) }}" class="btn" style="background: #eff6ff; color: #3b82f6; padding: 0.4rem 0.75rem; border-radius: 99px; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; font-weight: 700; transition: 0.2s;" onmouseover="this.style.background='#dbeafe';">
                                <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i> Edit
                            </a>
                            @if($role->group_id != 1)
                            <form action="{{ route('admin.sistem.role.destroy', $role->group_id) }}" method="POST" onsubmit="return confirm('Hapus role ini beserta semua hak aksesnya?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background: #fee2e2; color: #ef4444; padding: 0.4rem 0.75rem; border: none; border-radius: 99px; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem; font-weight: 700; transition: 0.2s;" onmouseover="this.style.background='#fecaca';">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                                </button>
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

