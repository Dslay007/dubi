@extends('layouts.admin')

@section('pageTitle', 'Edit Tipe Pembawa')

@section('content')
<x-form-card 
  title="Edit Tipe Pembawa" 
  icon="disc-3" 
  action="{{ route('admin.carrier_type.update', $carrierType->id) }}" 
  method="PUT" 
  cancelRoute="admin.carrier_type.index"
>
    
    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Tipe Pembawa <span style="color: #ef4444;">*</span></label>
      <input type="text" name="carrier_type" value="{{ $carrierType->carrier_type }}" required
        >
    </div>

    <div style="margin-bottom: 1.5rem;">
      <label class="form-label">Kode</label>
      <input type="text" name="code" value="{{ $carrierType->code }}"
        >
    </div>

    </x-form-card>
@endsection
