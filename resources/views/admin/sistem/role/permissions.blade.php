@extends('layouts.admin')

@section('pageTitle', 'Atur Hak Akses: ' . $role->group_name)

@section('content')
<div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
        <div>
            <h3 style="font-weight: 700; color: white; font-size: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="shield-check" style="width: 1.25rem; height: 1.25rem;"></i>
                Atur Hak Akses
            </h3>
            <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.25rem;">Role: <strong style="color: #60a5fa;">{{ $role->group_name }}</strong></p>
        </div>
        <a href="{{ route('admin.sistem.role.index') }}" class="btn" style="background: rgba(255,255,255,0.15); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">← Kembali</a>
    </div>

    <div style="padding: 1rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
        <p style="color: #64748b; font-size: 0.875rem;">
            <i data-lucide="info" style="width: 0.875rem; height: 0.875rem; display: inline; vertical-align: -2px;"></i>
            Centang sub-menu yang boleh diakses oleh role ini. Menu utama akan otomatis tersembunyi jika semua sub-menunya tidak dicentang.
        </p>
        <div style="display: flex; gap: 0.5rem;">
            <button type="button" onclick="toggleAll(true)" class="btn" style="background: #10b981; color: white; padding: 0.4rem 0.85rem; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer; font-weight: 500;">
                <i data-lucide="check-square" style="width: 0.85rem; height: 0.85rem; display: inline; vertical-align: -2px;"></i> Centang Semua
            </button>
            <button type="button" onclick="toggleAll(false)" class="btn" style="background: #ef4444; color: white; padding: 0.4rem 0.85rem; border: none; border-radius: 0.375rem; font-size: 0.8rem; cursor: pointer; font-weight: 500;">
                <i data-lucide="square" style="width: 0.85rem; height: 0.85rem; display: inline; vertical-align: -2px;"></i> Hapus Semua
            </button>
        </div>
    </div>
</div>

<form action="{{ route('admin.sistem.role.permissions.save', $role->group_id) }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1rem;">
        @foreach($menuStructure as $menuKey => $menuData)
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: box-shadow 0.2s;" 
             onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" 
             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
            
            {{-- Menu Header with toggle all --}}
            <div style="padding: 0.85rem 1.25rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.6rem;">
                    <div style="width: 2rem; height: 2rem; background: linear-gradient(135deg, #3b82f6, #6366f1); border-radius: 0.375rem; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="{{ $menuData['icon'] }}" style="width: 1rem; height: 1rem; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #1e293b; font-size: 0.95rem; margin: 0;">{{ $menuData['label'] }}</h4>
                </div>
                <button type="button" onclick="toggleGroup('{{ $menuKey }}')" 
                        style="background: none; border: 1px solid #cbd5e1; padding: 0.25rem 0.6rem; border-radius: 0.25rem; font-size: 0.7rem; color: #64748b; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                        onmouseover="this.style.borderColor='#3b82f6'; this.style.color='#3b82f6';"
                        onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#64748b';">
                    Toggle
                </button>
            </div>

            {{-- Sub-menu checkboxes --}}
            <div style="padding: 0.75rem 1.25rem;">
                @foreach($menuData['submenus'] as $permKey => $permLabel)
                <label style="display: flex; align-items: center; gap: 0.65rem; cursor: pointer; padding: 0.5rem 0.5rem; border-radius: 0.375rem; transition: background 0.15s; margin-bottom: 0.15rem;"
                       onmouseover="this.style.background='#f1f5f9'" 
                       onmouseout="this.style.background='transparent'">
                    <input type="checkbox" 
                           name="perms[{{ $permKey }}]" 
                           value="1" 
                           class="perm-checkbox group-{{ $menuKey }}"
                           {{ in_array($permKey, $savedPerms) ? 'checked' : '' }}
                           style="width: 1.15rem; height: 1.15rem; accent-color: #3b82f6; cursor: pointer; flex-shrink: 0;">
                    <span style="font-size: 0.875rem; color: #334155; font-weight: 450;">{{ $permLabel }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Submit --}}
    <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem; position: sticky; bottom: 1rem; background: white; padding: 1rem 1.5rem; border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 -4px 12px rgba(0,0,0,0.1);">
        <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 0.75rem 2rem; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="save" style="width: 1rem; height: 1rem;"></i> Simpan Hak Akses
        </button>
        <a href="{{ route('admin.sistem.role.index') }}" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-weight: 500; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center;">Batal</a>
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
