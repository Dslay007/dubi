@extends('layouts.admin')

@section('pageTitle', 'Edit Item Status')

@section('content')
<x-form-card 
  title="Edit Item Status" 
  icon="activity" 
  action="{{ route('admin.item_status.update', $status->item_status_id) }}" 
  method="PUT" 
  cancelRoute="admin.item_status.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Status ID *</label>
      <input type="text" name="item_status_id" value="{{ old('item_status_id', $status->item_status_id) }}" required maxlength="3" class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Status Name *</label>
      <input type="text" name="item_status_name" value="{{ old('item_status_name', $status->item_status_name) }}" required class="form-input" >
    </div>

    </x-form-card>
@endsection

