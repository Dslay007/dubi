@extends('layouts.admin')

@section('pageTitle', 'Edit Agen')

@section('content')
<x-form-card 
  title="Edit Agen / Supplier" 
  icon="truck" 
  action="{{ route('admin.supplier.update', $supplier->supplier_id) }}" 
  method="PUT" 
  cancelRoute="admin.supplier.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Agen <span style="color: #ef4444;">*</span></label>
      <input type="text" name="supplier_name" value="{{ $supplier->supplier_name }}" required
        >
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Kontak / Penanggung Jawab</label>
        <input type="text" name="contact" value="{{ $supplier->contact }}"
          >
      </div>
      <div>
        <label class="form-label">Email</label>
        <input type="email" name="e_mail" value="{{ $supplier->e_mail }}"
          >
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" value="{{ $supplier->phone }}"
          >
      </div>
      <div>
        <label class="form-label">Fax</label>
        <input type="text" name="fax" value="{{ $supplier->fax }}"
          >
      </div>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Alamat</label>
      <textarea name="address" rows="3"
         class="form-input">{{ $supplier->address }}</textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Kode Pos</label>
        <input type="text" name="postal_code" value="{{ $supplier->postal_code }}"
          >
      </div>
      <div>
        <label class="form-label">Nomor Akun</label>
        <input type="text" name="account" value="{{ $supplier->account }}"
          >
      </div>
    </div>

    </x-form-card>
@endsection

