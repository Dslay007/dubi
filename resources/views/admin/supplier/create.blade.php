@extends('layouts.admin')

@section('pageTitle', 'Add Agen')

@section('content')
<x-form-card 
  title="Tambah Agen / Supplier" 
  icon="truck" 
  action="{{ route('admin.supplier.store') }}" 
  method="POST" 
  cancelRoute="admin.supplier.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Nama Agen <span style="color: #ef4444;">*</span></label>
      <input type="text" name="supplier_name" required
         class="form-input">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Kontak / Penanggung Jawab</label>
        <input type="text" name="contact"
           class="form-input">
      </div>
      <div>
        <label class="form-label">Email</label>
        <input type="email" name="e_mail"
           class="form-input">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Telepon</label>
        <input type="text" name="phone"
           class="form-input">
      </div>
      <div>
        <label class="form-label">Fax</label>
        <input type="text" name="fax"
           class="form-input">
      </div>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Alamat</label>
      <textarea name="address" rows="3"
         class="form-input"></textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
      <div>
        <label class="form-label">Kode Pos</label>
        <input type="text" name="postal_code"
           class="form-input">
      </div>
      <div>
        <label class="form-label">Nomor Akun</label>
        <input type="text" name="account"
           class="form-input">
      </div>
    </div>

    </x-form-card>
@endsection
