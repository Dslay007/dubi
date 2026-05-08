@extends('layouts.admin')

@section('pageTitle', 'Edit Server')

@section('content')
<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 2rem; max-width: 600px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 1.5rem;">Edit Peladen (Server)</h3>

    <form action="{{ route('admin.server.update', $server->server_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Nama Server <span style="color: #ef4444;">*</span></label>
            <input type="text" name="name" value="{{ $server->name }}" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">URI Server <span style="color: #ef4444;">*</span></label>
            <input type="text" name="uri" value="{{ $server->uri }}" required
                style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Tipe Server <span style="color: #ef4444;">*</span></label>
            <select name="server_type" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white;">
                <option value="1" {{ $server->server_type == 1 ? 'selected' : '' }}>P2P Server</option>
                <option value="2" {{ $server->server_type == 2 ? 'selected' : '' }}>Z39.50 Server</option>
            </select>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 0.375rem;">Perbarui</button>
            <a href="{{ route('admin.server.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1.5rem; text-decoration: none; border-radius: 0.375rem;">Batal</a>
        </div>
    </form>
</div>
@endsection
