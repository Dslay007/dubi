@extends('layouts.admin')

@section('pageTitle', 'Atur Hak Akses: ' . $role->group_name)

@section('content')

<x-master-header 
    title="Atur Hak Akses" 
    subtitle="Role: {{ $role->group_name }}" 
    icon="shield-check"
>
    <a href="{{ route('admin.sistem.role.index') }}" class="btn" style="background: white; color: #475569; padding: 0.6rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 600; font-size: 0.875rem; border: 1px solid #cbd5e1; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
    </a>
</x-master-header>

<div style="background: white; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; background: #f8fafc; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <p style="color: #64748b; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
            <i data-lucide="info" style="width: 16px; height: 16px; color: #3b82f6;"></i>
            Centang sub-menu yang boleh diakses oleh role ini. Menu utama akan otomatis tersembunyi jika semua sub-menunya tidak dicentang.
        </p>
        <div style="display: flex; gap: 0.5rem;">
            <button type="button" onclick="toggleAll(true)" class="btn" style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.875rem; cursor: pointer; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#bbf7d0';">
                <i data-lucide="check-square" style="width: 16px; height: 16px;"></i> Centang Semua
            </button>
            <button type="button" onclick="toggleAll(false)" class="btn" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.875rem; cursor: pointer; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#fecaca';">
                <i data-lucide="square" style="width: 16px; height: 16px;"></i> Hapus Semua
            </button>
        </div>
    </div>
</div>

<form action="{{ route('admin.sistem.role.permissions.save', $role->group_id) }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
        @foreach($menuStructure as $menuKey => $menuData)
        <div style="background: white; border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.3s;" 
             onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.06)';" 
             onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.02)';">
            
            {{-- Menu Header with toggle all --}}
            <div style="padding: 1.25rem 1.5rem; background: #f8fafc; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.25rem; height: 2.25rem; background: linear-gradient(135deg, #3b82f6, #6366f1); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.3);">
                        <i data-lucide="{{ $menuData['icon'] }}" style="width: 1.1rem; height: 1.1rem; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; font-size: 1rem; margin: 0;">{{ $menuData['label'] }}</h4>
                </div>
                <button type="button" onclick="toggleGroup('{{ $menuKey }}')" 
                        style="background: white; border: 1px solid #cbd5e1; padding: 0.3rem 0.75rem; border-radius: 99px; font-size: 0.75rem; color: #475569; cursor: pointer; font-weight: 700; transition: all 0.2s;"
                        onmouseover="this.style.borderColor='#3b82f6'; this.style.color='#3b82f6';"
                        onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#475569';">
                    Toggle
                </button>
            </div>

            {{-- Sub-menu checkboxes --}}
            <div style="padding: 1rem 1.5rem;">
                @foreach($menuData['submenus'] as $permKey => $permLabel)
                <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.6rem 0.75rem; border-radius: 0.5rem; transition: 0.2s; margin-bottom: 0.25rem;"
                       onmouseover="this.style.background='#f8fafc'" 
                       onmouseout="this.style.background='transparent'">
                    <input type="checkbox" 
                           name="perms[{{ $permKey }}]" 
                           value="1" 
                           class="perm-checkbox group-{{ $menuKey }}"
                           {{ in_array($permKey, $savedPerms) ? 'checked' : '' }}
                           style="width: 1.25rem; height: 1.25rem; accent-color: #8b5cf6; cursor: pointer; flex-shrink: 0; border-radius: 0.25rem;">
                    <span style="font-size: 0.95rem; color: #334155; font-weight: 500;">{{ $permLabel }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Submit --}}
    <div style="margin-top: 2rem; position: sticky; bottom: 2rem; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); padding: 1.25rem 2rem; border-radius: 1.5rem; border: 1px solid rgba(255,255,255,0.5); box-shadow: 0 10px 40px -10px rgba(0,0,0,0.15); display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="{{ route('admin.sistem.role.index') }}" style="background: white; color: #475569; padding: 0.875rem 1.5rem; border: 1px solid #cbd5e1; border-radius: 99px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s;" onmouseover="this.style.background='#f8fafc';">Batalkan</a>
        <button type="submit" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.875rem 2.5rem; border: none; border-radius: 99px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <i data-lucide="save" style="width: 18px; height: 18px;"></i> Simpan Hak Akses
        </button>
    </div>
</form>

<script>
    function toggleAll(checked) {
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = checked);
    }

    function toggleGroup(groupKey) {
        const checkboxes = document.querySelectorAll('.group-' + groupKey);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    }
</script>
@endsection
