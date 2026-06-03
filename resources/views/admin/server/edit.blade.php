@extends('layouts.admin')

@section('pageTitle', 'Edit Server')

@section('content')
<x-form-card 
  title="Edit Peladen (Server)" 
  icon="server" 
  action="{{ route('admin.server.update', $server->server_id) }}" 
  method="PUT" 
  cancelRoute="admin.server.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Server <span style="color: #ef4444;">*</span></label>
      <input type="text" name="name" value="{{ $server->name }}" required
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">URI Server <span style="color: #ef4444;">*</span></label>
      <input type="text" name="uri" value="{{ $server->uri }}" required
        >
    </div>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Server <span style="color: #ef4444;">*</span></label>
      <select name="server_type" required class="form-input">
        <option value="1" {{ $server->server_type == 1 ? 'selected' : '' }}>P2P Server</option>
        <option value="2" {{ $server->server_type == 2 ? 'selected' : '' }}>Z39.50 Server</option>
      </select>
    </div>

    </x-form-card>
@endsection
