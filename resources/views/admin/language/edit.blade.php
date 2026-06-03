@extends('layouts.admin')

@section('pageTitle', 'Edit Bahasa')

@section('content')
<x-form-card 
  title="Edit Bahasa Dokumen" 
  icon="globe-2" 
  action="{{ route('admin.language.update', $language->language_id) }}" 
  method="PUT" 
  cancelRoute="admin.language.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">ID Bahasa</label>
      <input type="text" name="language_id" value="{{ $language->language_id }}" disabled
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Bahasa <span style="color: #ef4444;">*</span></label>
      <input type="text" name="language_name" value="{{ $language->language_name }}" required
        >
    </div>

    </x-form-card>
@endsection
