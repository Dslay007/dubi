@extends('layouts.admin')

@section('pageTitle', 'Add New Author')

@section('content')
<x-form-card 
  title="Add New Author" 
  icon="users" 
  action="{{ route('admin.author.store') }}" 
  method="POST" 
  cancelRoute="admin.author.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Author Name *</label>
      <input type="text" name="author_name" required autofocus class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Birth Year (Optional)</label>
      <input type="text" name="author_year" class="form-input" placeholder="YYYY">
    </div>

    </x-form-card>
@endsection

