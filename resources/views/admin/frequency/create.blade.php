@extends('layouts.admin')

@section('pageTitle', 'Add Kala Terbit')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 2rem; max-width: 600px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 1.5rem;">Tambah Kala Terbit</h3>

    <form action="{{ route('admin.frequency.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Kala Terbit <span style="color: #ef4444;">*</span></label>
            <input type="text" name="frequency" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Awalan Bahasa (Opsional)</label>
            <input type="text" name="language_prefix"
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Jeda Waktu</label>
                <input type="number" name="time_increment"
                    style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Unit Waktu <span style="color: #ef4444;">*</span></label>
                <select name="time_unit" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white;">
                    <option value="day">Hari (Day)</option>
                    <option value="week">Minggu (Week)</option>
                    <option value="month">Bulan (Month)</option>
                    <option value="year">Tahun (Year)</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 0.375rem;">Simpan</button>
            <a href="{{ route('admin.frequency.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1.5rem; text-decoration: none; border-radius: 0.375rem;">Batal</a>
        </div>
    </form>
</div>
@endsection
