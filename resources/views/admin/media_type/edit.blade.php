@extends('layouts.admin')

@section('pageTitle', 'Edit Tipe Media')

@section('content')
<x-form-card 
  title="Edit Tipe Media" 
  icon="film" 
  action="{{ route('admin.media_type.update', $mediaType->id) }}" 
  method="PUT" 
  cancelRoute="admin.media_type.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Media <span style="color: #ef4444;">*</span></label>
      <input type="text" name="media_type" value="{{ $mediaType->media_type }}" required
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kode</label>
      <input type="text" name="code" value="{{ $mediaType->code }}"
        >
    </div>

    </x-form-card>
@endsection

