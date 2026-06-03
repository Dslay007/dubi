@extends('layouts.admin')

@section('pageTitle', 'Add Server')

@section('content')
<x-form-card 
  title="Tambah Peladen (Server)" 
  icon="server" 
  action="{{ route('admin.server.store') }}" 
  method="POST" 
  cancelRoute="admin.server.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Server <span style="color: #ef4444;">*</span></label>
      <input type="text" name="name" required
         class="form-input">
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">URI Server <span style="color: #ef4444;">*</span></label>
      <input type="text" name="uri" required
         class="form-input">
    </div>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Server <span style="color: #ef4444;">*</span></label>
      <select name="server_type" required class="form-input">
        <option value="1">P2P Server</option>
        <option value="2">Z39.50 Server</option>
      </select>
    </div>

    </x-form-card>
@endsection
