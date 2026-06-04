@extends('layouts.admin')

@section('pageTitle', 'Edit Lokasi')

@section('content')
<x-form-card 
  title="Edit Lokasi" 
  icon="map" 
  action="{{ route('admin.location.update', $location->location_id) }}" 
  method="PUT" 
  cancelRoute="admin.location.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">ID Lokasi</label>
      <input type="text" name="location_id" value="{{ $location->location_id }}" disabled
        >
      <small style="color: #64748b; font-size: 0.75rem;">ID Lokasi tidak bisa diubah karena merupakan Primary Key.</small>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Lokasi <span style="color: #ef4444;">*</span></label>
      <input type="text" name="location_name" value="{{ $location->location_name }}" required
        >
    </div>

    </x-form-card>
@endsection

