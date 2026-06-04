@extends('layouts.admin')

@section('pageTitle', 'Add New GMD')

@section('content')
<x-form-card 
  title="Add New GMD" 
  icon="layers" 
  action="{{ route('admin.gmd.store') }}" 
  method="POST" 
  cancelRoute="admin.gmd.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">GMD Code *</label>
      <input type="text" name="gmd_code" required autofocus class="form-input" placeholder="e.g. Text, Art, Map">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">GMD Name *</label>
      <input type="text" name="gmd_name" required class="form-input" placeholder="e.g. Textual Material">
    </div>

    </x-form-card>
@endsection

