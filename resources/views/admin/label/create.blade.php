@extends('layouts.admin')

@section('pageTitle', 'Add Label')

@section('content')
<x-form-card 
  title="Tambah Label" 
  icon="tags" 
  action="{{ route('admin.label.store') }}" 
  method="POST" 
  cancelRoute="admin.label.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Label <span style="color: #ef4444;">*</span></label>
      <input type="text" name="label_name" required
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Deskripsi</label>
      <textarea name="label_desc" rows="3"
         class="form-input"></textarea>
    </div>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Gambar (Opsional URL/Path)</label>
      <input type="text" name="label_image"
         class="form-input">
    </div>

    </x-form-card>
@endsection

