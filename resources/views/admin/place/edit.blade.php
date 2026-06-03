@extends('layouts.admin')

@section('pageTitle', 'Edit Place')

@section('content')
<x-form-card 
  title="Edit Place" 
  icon="map-pin" 
  action="{{ route('admin.place.update', $place->place_id) }}" 
  method="PUT" 
  cancelRoute="admin.place.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Place Name *</label>
      <input type="text" name="place_name" value="{{ old('place_name', $place->place_name) }}" required class="form-input" >
    </div>

    </x-form-card>
@endsection
