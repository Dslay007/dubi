@extends('layouts.admin')

@section('pageTitle', 'Add Kala Terbit')

@section('content')
<x-form-card 
  title="Tambah Kala Terbit" 
  icon="clock-4" 
  action="{{ route('admin.frequency.store') }}" 
  method="POST" 
  cancelRoute="admin.frequency.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kala Terbit <span style="color: #ef4444;">*</span></label>
      <input type="text" name="frequency" required
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Awalan Bahasa (Opsional)</label>
      <input type="text" name="language_prefix"
         class="form-input">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Jeda Waktu</label>
        <input type="number" name="time_increment"
           class="form-input">
      </div>
      <div>
        <label class="form-label">Unit Waktu <span style="color: #ef4444;">*</span></label>
        <select name="time_unit" required class="form-input">
          <option value="day">Hari (Day)</option>
          <option value="week">Minggu (Week)</option>
          <option value="month">Bulan (Month)</option>
          <option value="year">Tahun (Year)</option>
        </select>
      </div>
    </div>

    </x-form-card>
@endsection

