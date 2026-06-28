@extends('layouts.admin')

@section('pageTitle', 'Verifikasi Anggota Baru')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
    
    <div style="margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e293b;">Daftar Antrean Verifikasi (Self-Registration)</h3>
            <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">Pendaftar wajib diverifikasi setelah menunjukkan KTP asli di lapak baca.</p>
        </div>
        
        <form action="{{ route('admin.member.verifikasi') }}" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.25rem 0.5rem;">
                <i data-lucide="search" style="width: 1rem; height: 1rem; color: #94a3b8; margin-right: 0.5rem;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK / Nama..." 
                    style="border: none; background: transparent; outline: none; font-size: 0.875rem; width: 150px; color: #334155;">
            </div>
            
            <select name="sort" onchange="this.form.submit()" style="border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.4rem 0.5rem; font-size: 0.875rem; background: #f8fafc; color: #334155; outline: none;">
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
            
            @if(request('search'))
            <a href="{{ route('admin.member.verifikasi') }}" class="btn" style="background: #e2e8f0; color: #475569; padding: 0.4rem 0.75rem; border-radius: 0.375rem; border: none; font-size: 0.875rem; text-decoration: none;">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
            <thead>
                <tr style="background-color: #f8fafc; color: #475569; font-weight: 600;">
                    <th style="padding: 1rem; border-bottom: 2px solid #e2e8f0;">NIK / Member ID</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e2e8f0;">Nama Lengkap</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e2e8f0;">No. WhatsApp</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e2e8f0;">Tgl. Daftar</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #e2e8f0; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem; color: #1e293b; font-weight: 500;">{{ $member->member_id }}</td>
                    <td style="padding: 1rem; color: #334155;">{{ $member->member_name }}</td>
                    <td style="padding: 1rem; color: #334155;">{{ $member->member_phone }}</td>
                    <td style="padding: 1rem; color: #64748b;">{{ \Carbon\Carbon::parse($member->input_date)->format('d M Y') }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <!-- Tombol Cek Detail -->
                            <button type="button" x-data @click="$dispatch('open-modal-{{ $member->member_id }}')" 
                                style="background: #eff6ff; color: #2563eb; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; border: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s; cursor: pointer;" 
                                onmouseover="this.style.background='#dbeafe';" onmouseout="this.style.background='#eff6ff';">
                                <i data-lucide="eye" style="width: 14px; height: 14px;"></i> Cek
                            </button>
                            
                            <!-- Tombol Verifikasi -->
                            <button type="button" class="btn-verify" 
                                data-id="{{ $member->member_id }}" 
                                data-name="{{ $member->member_name }}"
                                data-phone="{{ $member->member_phone }}"
                                style="background: #f0fdf4; color: #16a34a; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; border: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s; cursor: pointer;" 
                                onmouseover="this.style.background='#dcfce7';" onmouseout="this.style.background='#f0fdf4';">
                                <i data-lucide="check-circle-2" style="width: 14px; height: 14px;"></i> Verifikasi
                            </button>
                            
                            <!-- Tombol Tolak -->
                            <button type="button" class="btn-reject" 
                                data-id="{{ $member->member_id }}" 
                                data-name="{{ $member->member_name }}"
                                data-phone="{{ $member->member_phone }}"
                                style="background: white; border: 1px solid #fecaca; color: #ef4444; padding: 0.4rem 0.75rem; border-radius: 99px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: 0.2s; cursor: pointer;" 
                                onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='white';">
                                <i data-lucide="x-circle" style="width: 14px; height: 14px;"></i> Tolak
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #64748b;">
                        <i data-lucide="inbox" style="width: 2rem; height: 2rem; margin: 0 auto 1rem auto; display: block; opacity: 0.5;"></i>
                        Tidak ada pendaftar baru yang menunggu verifikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $members->links() }}
    </div>
</div>

<!-- Modals Detail (Placed outside the table) -->
@foreach($members as $member)
<div x-data="{ show: false }" 
     @open-modal-{{ $member->member_id }}.window="show = true"
     x-show="show" 
     style="display: none;">
     
    <!-- Backdrop -->
    <div x-show="show" 
         x-transition.opacity
         style="position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.5); z-index: 40;" 
         @click="show = false"></div>
    
    <!-- Modal Panel -->
    <div x-show="show"
         x-transition
         style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 0.75rem; z-index: 50; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        
        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem;">
            Detail Pendaftar
        </h3>
        
        <table style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 1.5rem;">
            <tr>
                <th style="padding: 0.5rem 0; color: #64748b; font-weight: 500; width: 35%;">NIK</th>
                <td style="padding: 0.5rem 0; color: #0f172a; font-weight: 600;">: {{ $member->member_id }}</td>
            </tr>
            <tr>
                <th style="padding: 0.5rem 0; color: #64748b; font-weight: 500;">Nama Lengkap</th>
                <td style="padding: 0.5rem 0; color: #0f172a;">: {{ $member->member_name }}</td>
            </tr>
            <tr>
                <th style="padding: 0.5rem 0; color: #64748b; font-weight: 500;">Email</th>
                <td style="padding: 0.5rem 0; color: #0f172a;">: {{ $member->member_email }}</td>
            </tr>
            <tr>
                <th style="padding: 0.5rem 0; color: #64748b; font-weight: 500;">No WhatsApp</th>
                <td style="padding: 0.5rem 0; color: #0f172a;">: {{ $member->member_phone }}</td>
            </tr>
            <tr>
                <th style="padding: 0.5rem 0; color: #64748b; font-weight: 500;">Jenis Kelamin</th>
                <td style="padding: 0.5rem 0; color: #0f172a;">: {{ $member->gender == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <th style="padding: 0.5rem 0; color: #64748b; font-weight: 500;">Alamat</th>
                <td style="padding: 0.5rem 0; color: #0f172a;">: {{ $member->member_address }}</td>
            </tr>
        </table>
        
        <div style="background: #fef3c7; color: #92400e; padding: 1rem; border-radius: 0.5rem; font-size: 0.875rem; display: flex; align-items: flex-start; gap: 0.5rem;">
            <i data-lucide="alert-triangle" style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;"></i>
            <span>Pastikan untuk memeriksa KTP fisik calon anggota sebelum menekan tombol Verifikasi.</span>
        </div>
        
        <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
            <button @click="show = false" class="btn" style="background: #e2e8f0; color: #475569; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-weight: 500;">
                Tutup
            </button>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Fungsi untuk membersihkan nomor telepon untuk format WA
    function formatWaNumber(phone) {
        if (!phone) return '';
        let cleaned = phone.replace(/\D/g, '');
        if (cleaned.startsWith('0')) {
            cleaned = '62' + cleaned.substring(1);
        }
        return cleaned;
    }

    // Aksi Verifikasi
    document.querySelectorAll('.btn-verify').forEach(btn => {
        btn.addEventListener('click', function() {
            const memberId = this.dataset.id;
            const memberName = this.dataset.name;
            const phone = this.dataset.phone;
            
            Swal.fire({
                title: 'Verifikasi Akun?',
                html: `Anda yakin ingin MEMVERIFIKASI akun <strong>${memberName}</strong> (${memberId})?<br><br><small class="text-warning">Pastikan nomor KTP fisik sudah sesuai.</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Verifikasi & Kirim WA',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Menyimpan data dan menyiapkan pesan WhatsApp',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    fetch(`{{ url('/admin/member/verifikasi') }}/${memberId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            const waNumber = formatWaNumber(phone);
                            const message = `Halo ${memberName}, pendaftaran akun lapak baca Anda (NIK: ${memberId}) telah berhasil kami verifikasi. Anda sekarang dapat menikmati seluruh layanan kami. Terima kasih.\n\n ~ Admin Buku Dudukbaca`;
                            const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
                            
                            window.open(waUrl, '_blank');
                            window.location.reload();
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat memverifikasi data.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan jaringan.', 'error');
                    });
                }
            });
        });
    });

    // Aksi Tolak
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const memberId = this.dataset.id;
            const memberName = this.dataset.name;
            const phone = this.dataset.phone;
            
            Swal.fire({
                title: 'Tolak Pendaftaran?',
                html: `Anda yakin ingin MENOLAK dan MENGHAPUS data pendaftaran <strong>${memberName}</strong> (${memberId})?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tolak & Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Menghapus data dan menyiapkan pesan WhatsApp',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    fetch(`{{ url('/admin/member/verifikasi') }}/${memberId}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            const waNumber = formatWaNumber(phone);
                            const message = `Halo ${memberName}, mohon maaf pendaftaran akun lapak baca Anda (NIK: ${memberId}) tidak dapat kami proses karena ketidaksesuaian data. Silakan datang ke lapak baca untuk informasi lebih lanjut.\n\n- Admin Buku Dudukbaca`;
                            const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
                            
                            window.open(waUrl, '_blank');
                            window.location.reload();
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menolak data.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan jaringan.', 'error');
                    });
                }
            });
        });
    });
});
</script>
@endpush

