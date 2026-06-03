@extends('layouts.admin')

@section('pageTitle', 'Edit Kala Terbit')

@section('content')
<x-form-card 
  title="Edit Kala Terbit" 
  icon="clock-4" 
  action="{{ route('admin.frequency.update', $frequency->frequency_id) }}" 
  method="PUT" 
  cancelRoute="admin.frequency.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kala Terbit <span style="color: #ef4444;">*</span></label>
      <input type="text" name="frequency" value="{{ $frequency->frequency }}" required
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Awalan Bahasa (Opsional)</label>
      <input type="text" name="language_prefix" value="{{ $frequency->language_prefix }}"
        >
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Jeda Waktu</label>
        <input type="number" name="time_increment" value="{{ $frequency->time_increment }}"
          >
      </div>
      <div>
        <label class="form-label">Unit Waktu <span style="color: #ef4444;">*</span></label>
        <select name="time_unit" required class="form-input">
          <option value="day" {{ $frequency->time_unit == 'day' ? 'selected' : '' }}>Hari (Day)</option>
          <option value="week" {{ $frequency->time_unit == 'week' ? 'selected' : '' }}>Minggu (Week)</option>
          <option value="month" {{ $frequency->time_unit == 'month' ? 'selected' : '' }}>Bulan (Month)</option>
          <option value="year" {{ $frequency->time_unit == 'year' ? 'selected' : '' }}>Tahun (Year)</option>
        </select>
      </div>
    </div>

    </x-form-card>
@endsection
