@extends('layouts.admin')

@section('pageTitle', 'Edit Subject')

@section('content')
<x-form-card 
  title="Edit Subject" 
  icon="tag" 
  action="{{ route('admin.topic.update', $topic->topic_id) }}" 
  method="PUT" 
  cancelRoute="admin.topic.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Subject/Topic *</label>
      <input type="text" name="topic" value="{{ old('topic', $topic->topic) }}" required class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Topic Type</label>
      <select name="topic_type" class="form-input" class="form-input">
        <option value="t" {{ $topic->topic_type == 't' ? 'selected' : '' }}>Topic</option>
        <option value="g" {{ $topic->topic_type == 'g' ? 'selected' : '' }}>Geographic</option>
        <option value="n" {{ $topic->topic_type == 'n' ? 'selected' : '' }}>Name</option>
        <option value="s" {{ $topic->topic_type == 's' ? 'selected' : '' }}>Temporal</option>
        <option value="o" {{ $topic->topic_type == 'o' ? 'selected' : '' }}>Occupation</option>
      </select>
    </div>

    </x-form-card>
@endsection

