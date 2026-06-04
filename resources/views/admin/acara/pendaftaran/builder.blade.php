@extends('layouts.admin')

@section('pageTitle', 'Atur Pertanyaan Form: ' . $form->form_title)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h3 style="font-weight: 700; color: #1e293b;">Atur Pertanyaan Form</h3>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.acara.pendaftaran.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #cbd5e1;">
            <i data-lucide="list" style="width: 1rem; height: 1rem;"></i> Daftar Form
        </a>
        <a href="{{ route('admin.acara.pendaftaran.edit', $form->id) }}" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="edit" style="width: 1rem; height: 1rem;"></i> Edit Info Form
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    
    <!-- Kolom Kiri: Preview Pertanyaan yang sudah dibuat -->
    <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; align-self: start;">
        <div style="padding: 1.25rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h4 style="font-weight: 700; color: #1e293b; font-size: 1rem;">Preview Pertanyaan</h4>
            <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.25rem;">Daftar pertanyaan yang akan ditanyakan ke calon pendaftar. Nama dan Email otomatis sudah ada dan wajib.</p>
        </div>

        <div style="padding: 1.5rem;">
            <!-- Field Default -->
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.25rem;">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                    <span style="font-size: 0.75rem; color: #94a3b8; background: #f1f5f9; padding: 0.1rem 0.4rem; border-radius: 0.25rem;">Teks Pendek (Bawaan)</span>
                </div>
            </div>
            
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.25rem;">Alamat Email <span style="color: #ef4444;">*</span></label>
                    <span style="font-size: 0.75rem; color: #94a3b8; background: #f1f5f9; padding: 0.1rem 0.4rem; border-radius: 0.25rem;">Email (Bawaan)</span>
                </div>
            </div>

            <!-- Custom Fields -->
            @forelse($form->fields as $field)
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.25rem;">
                        {{ $field->field_label }}
                        @if($field->is_required) <span style="color: #ef4444;">*</span> @endif
                    </label>
                    <span style="font-size: 0.75rem; color: #64748b; background: #e0e7ff; padding: 0.1rem 0.4rem; border-radius: 0.25rem;">{{ ucfirst($field->field_type) }}</span>
                    
                    @if(in_array($field->field_type, ['select', 'radio', 'checkbox']) && $field->options)
                    <div style="margin-top: 0.5rem; font-size: 0.8rem; color: #64748b;">
                        Pilihan: {{ implode(', ', json_decode($field->options, true) ?? []) }}
                    </div>
                    @endif
                </div>
                
                <form action="{{ route('admin.acara.pendaftaran.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; border: 1px solid #fca5a5; color: #ef4444; padding: 0.35rem 0.5rem; border-radius: 0.25rem; cursor: pointer;" title="Hapus">
                        <i data-lucide="trash-2" style="width: 1rem; height: 1rem;"></i>
                    </button>
                </form>
            </div>
            @empty
            <div style="text-align: center; color: #94a3b8; font-size: 0.875rem; padding: 2rem 0;">
                Belum ada pertanyaan tambahan. Tambahkan melalui form di samping.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Kolom Kanan: Form Tambah Pertanyaan -->
    <div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; align-self: start;">
        <div style="padding: 1.25rem 1.5rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h4 style="font-weight: 700; color: #1e293b; font-size: 1rem;">Tambah Pertanyaan Baru</h4>
        </div>

        <form action="{{ route('admin.acara.pendaftaran.fields.store', $form->id) }}" method="POST" style="padding: 1.5rem;">
            @csrf

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Pertanyaan / Label*</label>
                <input type="text" name="field_label" required placeholder="Contoh: Instansi Asal" 
                    style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Tipe Jawaban*</label>
                <select name="field_type" id="field_type_select" required style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white; font-size: 0.875rem;">
                    <option value="text">Teks Pendek (Satu baris)</option>
                    <option value="textarea">Paragraf (Banyak baris)</option>
                    <option value="select">Pilihan Dropdown (Pilih satu)</option>
                    <option value="radio">Radio Button (Pilih satu)</option>
                    <option value="checkbox">Kotak Centang (Bisa pilih banyak)</option>
                </select>
            </div>

            <div id="options_container" style="display: none; margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Daftar Pilihan* <span style="font-size:0.75rem; font-weight:normal; color:#64748b;">(Pisahkan dengan koma)</span></label>
                <input type="text" name="options" id="options_input" placeholder="Contoh: Mahasiswa, Dosen, Umum" 
                    style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            </div>

            <div style="margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_required" value="1" id="is_required_chk" style="width: 1rem; height: 1rem; accent-color: #3b82f6;">
                <label for="is_required_chk" style="font-weight: 500; font-size: 0.875rem; color: #1e293b; cursor: pointer;">Wajib Diisi</label>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.5rem;">Urutan (Opsional)</label>
                <input type="number" name="sort_order" value="0" style="width: 100px; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 0.875rem;">
            </div>

            <button type="submit" class="btn" style="width: 100%; background: #10b981; color: white; padding: 0.75rem; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i data-lucide="plus" style="width: 1rem; height: 1rem;"></i> Tambah Pertanyaan
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('field_type_select');
        const optionsContainer = document.getElementById('options_container');
        const optionsInput = document.getElementById('options_input');

        function toggleOptions() {
            const val = typeSelect.value;
            if (['select', 'radio', 'checkbox'].includes(val)) {
                optionsContainer.style.display = 'block';
                optionsInput.required = true;
            } else {
                optionsContainer.style.display = 'none';
                optionsInput.required = false;
                optionsInput.value = '';
            }
        }

        typeSelect.addEventListener('change', toggleOptions);
        toggleOptions(); // run on load
    });
</script>
@endsection

