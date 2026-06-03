@extends('layouts.admin')

@section('pageTitle', 'Edit Tipe Isi')

@section('content')
<x-form-card 
  title="Edit Tipe Isi" 
  icon="file-text" 
  action="{{ route('admin.content_type.update', $contentType->id) }}" 
  method="PUT" 
  cancelRoute="admin.content_type.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Isi <span style="color: #ef4444;">*</span></label>
      <input type="text" name="content_type" value="{{ $contentType->content_type }}" required
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kode</label>
      <input type="text" name="code" value="{{ $contentType->code }}"
        >
    </div>

    </x-form-card>
@endsection
