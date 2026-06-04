@extends('layouts.admin')

@section('pageTitle', 'Struktur Komunitas')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;" x-data="{ 
    openEditStatic: false, 
    editStaticData: { id: '', title: '', name: '', subtitle: '' },
    openEditDiv: false,
    editDivData: { id: '', title: '', name: '', vice_name: '', members_list: '' },
    openAddDiv: false
}">
    
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">Struktur Komunitas</h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0; margin-top: 0.25rem;">Kelola susunan Founder, Pengurus Inti, dan Divisi lapak baca.</p>
    </div>

    @if(session('success'))
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
        <i data-lucide="check-circle" style="width: 1.25rem; height: 1.25rem;"></i>
        <span style="font-weight: 500;">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Card 1: Founder -->
    <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0;">Founder</h2>
                <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Edit nama dan foto 4 founder utama.</p>
            </div>
        </div>
        <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
            @foreach($founders as $founder)
            <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; text-align: center;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; border: 1px solid #cbd5e1; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    @if($founder->photo)
                        <img src="{{ asset('uploads/struktur/' . $founder->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i data-lucide="user" style="color: #94a3b8; width: 2rem; height: 2rem;"></i>
                    @endif
                </div>
                <div style="font-size: 0.8rem; font-weight: 700; color: #3b82f6; text-transform: uppercase; margin-bottom: 0.25rem;">{{ $founder->title }}</div>
                <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">{{ $founder->name ?: '-' }}</div>
                <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">{{ $founder->subtitle ?: '-' }}</div>
                
                <button @click="openEditStatic = true; editStaticData = { id: '{{ $founder->id }}', title: {{ json_encode($founder->title) }}, name: {{ json_encode($founder->name) }}, subtitle: {{ json_encode($founder->subtitle) }} }" style="background: white; border: 1px solid #cbd5e1; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">Edit</button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Card 2: Pengurus Inti -->
    <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0;">Anggota Inti</h2>
                <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Edit nama dan foto pengurus inti (Ketua, Wakil, dll).</p>
            </div>
        </div>
        <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
            @foreach($cores as $core)
            <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; text-align: center; border-top: 3px solid #f59e0b;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; border: 1px solid #cbd5e1; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    @if($core->photo)
                        <img src="{{ asset('uploads/struktur/' . $core->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="background: #3b82f6; color: white; font-weight: 700; font-size: 0.8rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            {{ $core->title }}
                        </div>
                    @endif
                </div>
                <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;">{{ $core->name ?: '-' }}</div>
                <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">{{ $core->subtitle ?: '-' }}</div>
                
                <button @click="openEditStatic = true; editStaticData = { id: '{{ $core->id }}', title: {{ json_encode($core->subtitle) }}, name: {{ json_encode($core->name) }}, subtitle: {{ json_encode($core->subtitle) }} }" style="background: white; border: 1px solid #cbd5e1; padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">Edit</button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Card 3: Divisi -->
    <div style="background: white; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0;">Divisi Komunitas</h2>
                <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Kelola daftar divisi, koordinator, dan anggotanya.</p>
            </div>
            <button @click="openAddDiv = true" style="background: #3b82f6; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="plus" style="width: 1rem;"></i> Tambah Divisi
            </button>
        </div>

        <div style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                @forelse($divisions as $divisi)
                <div style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <h3 style="font-weight: 700; color: #0f172a; margin: 0;">{{ $divisi->title }}</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <button @click="openEditDiv = true; editDivData = { id: '{{ $divisi->id }}', title: {{ json_encode($divisi->title) }}, name: {{ json_encode($divisi->name) }}, vice_name: {{ json_encode($divisi->vice_name) }}, members_list: {{ json_encode($divisi->members_list) }} }" style="background: none; border: none; color: #3b82f6; cursor: pointer;"><i data-lucide="edit" style="width: 1rem;"></i></button>
                            <form action="{{ route('admin.kegiatan.struktur.destroyDivision', $divisi->id) }}" method="POST" onsubmit="return confirm('Hapus divisi ini?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;"><i data-lucide="trash-2" style="width: 1rem;"></i></button>
                            </form>
                        </div>
                    </div>
                    
                    <div style="font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600; color: #475569;">Koordinator:</span> <br>
                        {{ $divisi->name ?: '-' }}
                    </div>
                    <div style="font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600; color: #475569;">Wakil Koordinator:</span> <br>
                        {!! $divisi->vice_name ? str_replace([',', ';'], '<br>', e($divisi->vice_name)) : '-' !!}
                    </div>
                    <div style="font-size: 0.85rem;">
                        <span style="font-weight: 600; color: #475569;">Anggota:</span> <br>
                        {!! $divisi->members_list ? str_replace([',', ';'], '<br>', nl2br(e($divisi->members_list))) : '-' !!}
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 2rem;">
                    Belum ada divisi komunitas.
                </div>
                @endforelse
            </div>
        </div>
    </div>


    <!-- ================= MODALS ================= -->

    <!-- Modal Edit Static -->
    <!-- Overlay -->
    <div x-show="openEditStatic" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99998;" x-cloak></div>
    <!-- Dialog -->
    <div x-show="openEditStatic" @click.away="openEditStatic = false" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; width: 100%; max-width: 400px; border-radius: 1rem; overflow: hidden; text-align: left; z-index: 99999;" x-cloak>
        <form :action="'{{ url('admin/kegiatan/struktur') }}/' + editStaticData.id + '/static'" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-weight: 700; margin: 0;" x-text="`Edit ${editStaticData.title}`"></h3>
                    <button type="button" @click="openEditStatic = false" style="background: none; border: none; cursor: pointer;"><i data-lucide="x" style="width: 1.25rem;"></i></button>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Nama</label>
                        <input type="text" name="name" x-model="editStaticData.name" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Jabatan / Keterangan</label>
                        <input type="text" name="subtitle" x-model="editStaticData.subtitle" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px dashed #cbd5e1; border-radius: 0.5rem; font-size: 0.85rem;">
                    </div>
                </div>
                <div style="padding: 1rem 1.5rem; background: #f8fafc; text-align: right;">
                    <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">Simpan</button>
                </div>
            </form>
    </div>

    <!-- Modal Edit Division -->
    <!-- Overlay -->
    <div x-show="openEditDiv" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99998;" x-cloak></div>
    <!-- Dialog -->
    <div x-show="openEditDiv" @click.away="openEditDiv = false" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; width: 100%; max-width: 500px; border-radius: 1rem; overflow: hidden; text-align: left; z-index: 99999;" x-cloak>
        <form :action="'{{ url('admin/kegiatan/struktur/division') }}/' + editDivData.id" method="POST">
                @csrf
                @method('PUT')
                <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-weight: 700; margin: 0;">Edit Divisi</h3>
                    <button type="button" @click="openEditDiv = false" style="background: none; border: none; cursor: pointer;"><i data-lucide="x" style="width: 1.25rem;"></i></button>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Nama Divisi *</label>
                        <input type="text" name="title" x-model="editDivData.title" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Koordinator</label>
                        <input type="text" name="name" x-model="editDivData.name" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Wakil Koordinator (Bisa lebih dari 1)</label>
                        <input type="text" name="vice_name" x-model="editDivData.vice_name" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Anggota Divisi</label>
                        <textarea name="members_list" x-model="editDivData.members_list" rows="3" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit;"></textarea>
                    </div>
                </div>
                <div style="padding: 1rem 1.5rem; background: #f8fafc; text-align: right;">
                    <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">Simpan</button>
                </div>
            </form>
    </div>

    <!-- Modal Tambah Divisi -->
    <!-- Overlay -->
    <div x-show="openAddDiv" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99998;" x-cloak></div>
    <!-- Dialog -->
    <div x-show="openAddDiv" @click.away="openAddDiv = false" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; width: 100%; max-width: 500px; border-radius: 1rem; overflow: hidden; text-align: left; z-index: 99999;" x-cloak>
        <form action="{{ route('admin.kegiatan.struktur.storeDivision') }}" method="POST">
                @csrf
                <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-weight: 700; margin: 0;">Tambah Divisi</h3>
                    <button type="button" @click="openAddDiv = false" style="background: none; border: none; cursor: pointer;"><i data-lucide="x" style="width: 1.25rem;"></i></button>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Nama Divisi *</label>
                        <input type="text" name="title" required placeholder="Contoh: Content Creator" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Koordinator</label>
                        <input type="text" name="name" placeholder="Nama Koordinator" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Wakil Koordinator</label>
                        <input type="text" name="vice_name" placeholder="Nama Wakil (pisahkan dengan koma jika lebih dari 1)" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem;">Anggota Divisi</label>
                        <textarea name="members_list" rows="3" placeholder="Nama-nama anggota..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; font-family: inherit;"></textarea>
                    </div>
                </div>
                <div style="padding: 1rem 1.5rem; background: #f8fafc; text-align: right;">
                    <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">Simpan Divisi</button>
                </div>
            </form>
    </div>
</div>
@endsection

