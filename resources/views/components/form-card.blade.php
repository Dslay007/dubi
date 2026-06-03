@props(['title', 'icon', 'action', 'method' => 'POST', 'cancelRoute' => null, 'submitText' => 'Simpan Data'])
<div style="background: white; padding: 2.5rem; border-radius: 1.5rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    <h3 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
        <i data-lucide="{{ $icon }}" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
        {{ $title }}
    </h3>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(strtoupper($method) !== 'POST')
            @method($method)
        @endif
        
        {{ $slot }}

        <div style="display: flex; gap: 1rem; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
            <button type="submit" class="btn" style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; border: none; border-radius: 99px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 6px -1px rgba(139,92,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                {{ $submitText }}
            </button>
            @if($cancelRoute)
            <a href="{{ route($cancelRoute) }}" style="padding: 0.75rem 2rem; background: #f1f5f9; color: #475569; text-decoration: none; border-radius: 99px; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                Batal
            </a>
            @endif
        </div>
    </form>
</div>
