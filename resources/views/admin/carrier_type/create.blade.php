@extends('layouts.admin')

@section('pageTitle', 'Add Tipe Pembawa')

@section('content')
<x-form-card 
  title="Tambah Tipe Pembawa" 
  icon="disc-3" 
  action="{{ route('admin.carrier_type.store') }}" 
  method="POST" 
  cancelRoute="admin.carrier_type.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Pembawa <span style="color: #ef4444;">*</span></label>
      <input type="text" name="carrier_type" required
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kode</label>
      <input type="text" name="code"
         class="form-input">
    </div>

    </x-form-card>
@endsection

