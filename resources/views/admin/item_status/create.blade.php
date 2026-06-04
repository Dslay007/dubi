@extends('layouts.admin')

@section('pageTitle', 'Add New Item Status')

@section('content')
<x-form-card 
  title="Add New Item Status" 
  icon="activity" 
  action="{{ route('admin.item_status.store') }}" 
  method="POST" 
  cancelRoute="admin.item_status.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Status ID (Max 3 chars) *</label>
      <input type="text" name="item_status_id" required autofocus maxlength="3" class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Status Name *</label>
      <input type="text" name="item_status_name" required class="form-input" >
    </div>

    </x-form-card>
@endsection

