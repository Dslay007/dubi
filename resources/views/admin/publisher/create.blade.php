@extends('layouts.admin')

@section('pageTitle', 'Add New Publisher')

@section('content')
<x-form-card 
  title="Add New Publisher" 
  icon="building-2" 
  action="{{ route('admin.publisher.store') }}" 
  method="POST" 
  cancelRoute="admin.publisher.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Publisher Name *</label>
      <input type="text" name="publisher_name" required autofocus class="form-input" >
    </div>

    </x-form-card>
@endsection

