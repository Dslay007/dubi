@extends('layouts.admin')

@section('pageTitle', 'Edit GMD')

@section('content')
<x-form-card 
  title="Edit GMD" 
  icon="layers" 
  action="{{ route('admin.gmd.update', $gmd->gmd_id) }}" 
  method="PUT" 
  cancelRoute="admin.gmd.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">GMD Code *</label>
      <input type="text" name="gmd_code" value="{{ old('gmd_code', $gmd->gmd_code) }}" required class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">GMD Name *</label>
      <input type="text" name="gmd_name" value="{{ old('gmd_name', $gmd->gmd_name) }}" required class="form-input" >
    </div>

    </x-form-card>
@endsection

