@extends('layouts.admin')

@section('pageTitle', 'Add Lokasi')

@section('content')
<x-form-card 
  title="Tambah Lokasi" 
  icon="map" 
  action="{{ route('admin.location.store') }}" 
  method="POST" 
  cancelRoute="admin.location.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">ID Lokasi (Maks 3 Karakter) <span style="color: #ef4444;">*</span></label>
      <input type="text" name="location_id" required maxlength="3"
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Lokasi <span style="color: #ef4444;">*</span></label>
      <input type="text" name="location_name" required
         class="form-input">
    </div>

    </x-form-card>
@endsection
