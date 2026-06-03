@extends('layouts.admin')

@section('pageTitle', 'Edit Author')

@section('content')
<x-form-card 
  title="Edit Author" 
  icon="users" 
  action="{{ route('admin.author.update', $author->author_id) }}" 
  method="PUT" 
  cancelRoute="admin.author.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Author Name *</label>
      <input type="text" name="author_name" value="{{ old('author_name', $author->author_name) }}" required class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Birth Year (Optional)</label>
      <input type="text" name="author_year" value="{{ old('author_year', $author->author_year) }}" class="form-input" placeholder="YYYY">
    </div>

    </x-form-card>
@endsection
