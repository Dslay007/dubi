@extends('layouts.admin')

@section('pageTitle', 'Add Tipe Isi')

@section('content')
<x-form-card 
  title="Tambah Tipe Isi" 
  icon="file-text" 
  action="{{ route('admin.content_type.store') }}" 
  method="POST" 
  cancelRoute="admin.content_type.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Isi <span style="color: #ef4444;">*</span></label>
      <input type="text" name="content_type" required
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kode</label>
      <input type="text" name="code"
         class="form-input">
    </div>

    </x-form-card>
@endsection
