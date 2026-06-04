@extends('layouts.admin')

@section('pageTitle', 'Add New Subject')

@section('content')
<x-form-card 
  title="Add New Subject" 
  icon="tag" 
  action="{{ route('admin.topic.store') }}" 
  method="POST" 
  cancelRoute="admin.topic.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Subject/Topic *</label>
      <input type="text" name="topic" required autofocus class="form-input" >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Topic Type</label>
      <select name="topic_type" class="form-input" class="form-input">
        <option value="t">Topic</option>
        <option value="g">Geographic</option>
        <option value="n">Name</option>
        <option value="s">Temporal</option>
        <option value="o">Occupation</option>
      </select>
    </div>

    </x-form-card>
@endsection

