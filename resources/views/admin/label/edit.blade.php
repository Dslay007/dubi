@extends('layouts.admin')

@section('pageTitle', 'Edit Label')

@section('content')
<x-form-card 
  title="Edit Label" 
  icon="tags" 
  action="{{ route('admin.label.update', $label->label_id) }}" 
  method="PUT" 
  cancelRoute="admin.label.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Label <span style="color: #ef4444;">*</span></label>
      <input type="text" name="label_name" value="{{ $label->label_name }}" required
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Deskripsi</label>
      <textarea name="label_desc" rows="3"
         class="form-input">{{ $label->label_desc }}</textarea>
    </div>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Gambar</label>
      <input type="text" name="label_image" value="{{ $label->label_image }}"
        >
    </div>

    </x-form-card>
@endsection

