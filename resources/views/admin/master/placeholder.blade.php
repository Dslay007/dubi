@extends('layouts.admin')

@section('pageTitle', 'Daftar Terkendali - ' . ucwords(str_replace('_', ' ', $current)))

@section('content')

<x-master-file-dropdown :type="$type" :current="$current" />

<div style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 4rem 2rem; text-align: center;">
    <div style="display: inline-flex; align-items: center; justify-content: center; width: 4rem; height: 4rem; background: #f1f5f9; color: #64748b; border-radius: 99px; margin-bottom: 1.5rem;">
        <i data-lucide="wrench" style="width: 2rem; height: 2rem;"></i>
    </div>
    <h3 style="font-weight: 700; color: #1e293b; font-size: 1.25rem; margin-bottom: 0.5rem;">Fitur Belum Tersedia</h3>
    <p style="color: #64748b; max-width: 400px; margin: 0 auto;">
        Halaman untuk modul <strong>{{ ucwords(str_replace('_', ' ', $current)) }}</strong> masih dalam tahap pengembangan (Under Construction). Tabel dan form untuk modul ini akan ditambahkan segera.
    </p>
</div>
@endsection
