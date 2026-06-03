@extends('layouts.admin')

@section('pageTitle', 'Edit Publisher')

@section('content')
<x-form-card 
  title="Edit Publisher" 
  icon="building-2" 
  action="{{ route('admin.publisher.update', $publisher->publisher_id) }}" 
  method="PUT" 
  cancelRoute="admin.publisher.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Publisher Name *</label>
      <input type="text" name="publisher_name" value="{{ old('publisher_name', $publisher->publisher_name) }}" required class="form-input" >
    </div>

    </x-form-card>
@endsection
