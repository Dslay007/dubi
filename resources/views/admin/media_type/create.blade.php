@extends('layouts.admin')

@section('pageTitle', 'Add Tipe Media')

@section('content')
<x-form-card 
  title="Tambah Tipe Media" 
  icon="film" 
  action="{{ route('admin.media_type.store') }}" 
  method="POST" 
  cancelRoute="admin.media_type.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Media <span style="color: #ef4444;">*</span></label>
      <input type="text" name="media_type" required
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kode</label>
      <input type="text" name="code"
         class="form-input">
    </div>

    </x-form-card>
@endsection
