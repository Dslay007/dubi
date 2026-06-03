@props(['title', 'subtitle', 'icon', 'importRoute' => null, 'exportRoute' => null, 'createRoute' => null, 'createLabel' => 'Tambah Data'])
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <i data-lucide="{{ $icon }}" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
            {{ $title }}
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">{{ $subtitle }}</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        @if($importRoute)
        <a href="{{ route($importRoute) }}" class="btn" style="background: white; color: #d97706; border: 2px solid #fde68a; padding: 0.75rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#fef3c7';" onmouseout="this.style.background='white';">
            <i data-lucide="download" style="width: 16px; height: 16px;"></i>
            Import
        </a>
        @endif
        @if($exportRoute)
        <a href="{{ route($exportRoute) }}" class="btn" style="background: white; color: #059669; border: 2px solid #a7f3d0; padding: 0.75rem 1.25rem; border-radius: 99px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#ecfdf5';" onmouseout="this.style.background='white';">
            <i data-lucide="upload" style="width: 16px; height: 16px;"></i>
            Export
        </a>
        @endif
        @if($createRoute)
        <a href="{{ route($createRoute) }}" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 99px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(139,92,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            {{ $createLabel }}
        </a>
        @endif
        {{ $slot }}
    </div>
</div>
