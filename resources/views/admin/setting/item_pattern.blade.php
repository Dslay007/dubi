@extends('layouts.admin')

@section('pageTitle', 'Pola Kode Eksemplar')

@section('content')

<x-master-file-dropdown type="peralatan" current="pola_kode_eksemplar" />

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; max-width: 600px;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-weight: 700; color: #1e293b;">Pengaturan Pola Kode Eksemplar</h3>
    </div>

    <div style="padding: 1.5rem;">
        <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 1.5rem; font-size: 0.875rem; color: #475569;">
            <p style="margin-bottom: 0.5rem;"><strong>Panduan:</strong> Daftarkan pola barcode eksemplar yang Anda inginkan. Anda dapat memiliki lebih dari satu pola untuk dipilih nanti.</p>
            <ul style="margin-left: 1.5rem;">
                <li>Gunakan angka <code>0</code> (nol) untuk menentukan panjang digit nomor urut yang dihasilkan otomatis.</li>
                <li>Gunakan karakter lain sebagai *Prefix* (Awalan) atau *Suffix* (Akhiran).</li>
            </ul>
            <p style="margin-top: 0.5rem;"><strong>Contoh:</strong> <code>B00000</code> akan menghasilkan B00001, B00002, dst.</p>
        </div>

        <div style="margin-bottom: 2rem;">
            <h4 style="font-weight: 600; color: #334155; margin-bottom: 1rem;">Daftar Pola Eksemplar</h4>
            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 0.375rem;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 0.75rem; font-weight: 700;">
                            <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0;">Pola Barcode Eksemplar</th>
                            <th style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #e2e8f0; width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patterns as $pat)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem 1.5rem; color: #1e293b; font-weight: 600;">{{ $pat }}</td>
                            <td style="padding: 1rem 1.5rem;">
                                <form action="{{ route('admin.setting.item_pattern.destroy') }}" method="POST" onsubmit="return confirm('Hapus pola ini?');">
                                    @csrf
                                    <input type="hidden" name="pattern" value="{{ $pat }}">
                                    <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="padding: 1.5rem; text-align: center; color: #64748b;">Belum ada pola yang didaftarkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('admin.setting.item_pattern.store') }}" method="POST" style="background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
            <h4 style="font-weight: 600; color: #334155; margin-bottom: 1rem;">Tambah Pola Baru</h4>
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Pola Barcode</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" name="pattern" placeholder="Contoh: B00000" required
                        style="flex: 1; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; font-size: 1rem;">
                    <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; font-weight: 500;">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
