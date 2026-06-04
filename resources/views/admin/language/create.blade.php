@extends('layouts.admin')

@section('pageTitle', 'Add Bahasa')

@section('content')
<x-form-card 
  title="Tambah Bahasa Dokumen" 
  icon="globe-2" 
  action="{{ route('admin.language.store') }}" 
  method="POST" 
  cancelRoute="admin.language.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">ID Bahasa (Maks 5 Karakter) <span style="color: #ef4444;">*</span></label>
      <input type="text" name="language_id" required maxlength="5"
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Bahasa <span style="color: #ef4444;">*</span></label>
      <input type="text" name="language_name" required
         class="form-input">
    </div>

    </x-form-card>
@endsection

