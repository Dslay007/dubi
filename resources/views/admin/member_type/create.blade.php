@extends('layouts.admin')

@section('pageTitle', 'Tambah Tipe Keanggotaan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
    <div>
        <h2 style="font-weight: 800; font-size: 1.5rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #8b5cf6;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Tambah Tipe Keanggotaan
        </h2>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Tambahkan tipe anggota baru dan atur kebijakannya.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.member_type.index') }}" class="btn" style="background: white; color: #475569; padding: 0.75rem 1.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; border: 2px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>
</div>

<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #8b5cf6;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
            Formulir Tipe Anggota
        </h3>
    </div>

    @if ($errors->any())
        <div style="margin: 2rem 2rem 0 2rem; background: #fef2f2; color: #b91c1c; padding: 1rem 1.5rem; border-radius: 1rem; border: 1px solid #fecaca; display: flex; gap: 0.75rem; align-items: flex-start;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 0.1rem;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <h4 style="font-weight: 700; margin: 0 0 0.25rem 0; font-size: 0.95rem;">Terjadi Kesalahan</h4>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.member_type.store') }}" method="POST" style="padding: 2rem;">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nama Tipe Keanggotaan <span style="color: #ef4444;">*</span></label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <input type="text" name="member_type_name" value="{{ old('member_type_name') }}" required class="input" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#8b5cf6'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none';" placeholder="Cth: Anggota Standar, Dosen">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Batas Pinjaman (Eksemplar) <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                        </div>
                        <input type="number" name="loan_limit" value="{{ old('loan_limit', 3) }}" required min="0" class="input" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#8b5cf6'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none';">
                    </div>
                </div>

                <div>
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Lama Pinjaman (Hari) <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <input type="number" name="loan_periode" value="{{ old('loan_periode', 7) }}" required min="0" class="input" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#8b5cf6'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none';">
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Denda Per Hari (Rp) <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        </div>
                        <input type="number" name="fine_each_day" value="{{ old('fine_each_day', 1000) }}" required min="0" class="input" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#8b5cf6'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none';">
                    </div>
                </div>

                <div>
                    <label class="label" style="display: block; font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Toleransi Terlambat (Hari) <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a10 10 0 1 0-10-10"/><path d="m15 15-3-3V7"/><path d="M22 12A10 10 0 0 0 12 2v0"/></svg>
                        </div>
                        <input type="number" name="grace_period" value="{{ old('grace_period', 0) }}" required min="0" class="input" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; outline: none; font-family: inherit; font-size: 0.95rem; transition: 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#8b5cf6'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none';">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 2rem;">
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 0.8rem 2.5rem; border: none; border-radius: 99px; font-weight: 700; font-size: 1rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(139,92,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Tipe Anggota
            </button>
        </div>
    </form>
</div>
@endsection
