@extends('layouts.admin')

@section('pageTitle', 'Add New Place')

@section('content')
<x-form-card 
  title="Add New Place" 
  icon="map-pin" 
  action="{{ route('admin.place.store') }}" 
  method="POST" 
  cancelRoute="admin.place.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Place Name *</label>
      <input type="text" name="place_name" required autofocus class="form-input" >
    </div>

    </x-form-card>
@endsection

