@extends('layouts.admin')

@section('pageTitle', 'Absensi Anggota')

@section('content')
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Absensi Anggota
        </h3>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Scan kartu anggota atau ketik nama untuk mencatat kunjungan.</p>
    </div>
    
    <div style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        
        <div style="width: 100%; max-width: 500px; text-align: center;">
            <div style="width: 80px; height: 80px; background: #eff6ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: inset 0 0 0 6px #dbeafe;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;"><path d="M3 7V5c0-1.1.9-2 2-2h2"/><path d="M17 3h2c1.1 0 2 .9 2 2v2"/><path d="M21 17v2c0 1.1-.9 2-2 2h-2"/><path d="M7 21H5c-1.1 0-2-.9-2-2v-2"/><rect x="7" y="7" width="10" height="10" rx="1"/></svg>
            </div>
            
            <form action="{{ route('admin.member.attendance.store') }}" method="POST" id="attendanceForm">
                @csrf
                <div style="position: relative; margin-bottom: 1.5rem;">
                    <select name="member_id" id="memberSelect" style="width: 100%;" required>
                        <option value=""></option>
                    </select>
                </div>
                
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 99px; font-weight: 800; font-size: 1rem; width: 100%; box-shadow: 0 4px 6px -1px rgba(59,130,246,0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';">
                    Catat Kunjungan
                </button>
            </form>
            
            <p style="margin-top: 2rem; color: #94a3b8; font-size: 0.85rem;">Anda dapat memindai barcode menggunakan scanner, atau mengetik ID/Nama secara manual.</p>
        </div>
    </div>
</div>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 64px;
        border-radius: 1.5rem;
        border: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .select2-container--default .select2-selection--single:hover {
        border-color: #93c5fd;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1), 0 4px 6px -2px rgba(59, 130, 246, 0.05);
        transform: translateY(-2px);
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.15), 0 10px 25px -5px rgba(59, 130, 246, 0.2);
        background: white;
        transform: translateY(-2px);
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #0f172a;
        font-weight: 800;
        font-size: 1.15rem;
        padding-left: 1.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 60px;
        right: 1.25rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8;
        font-weight: 600;
    }
    
    /* Styling dropdown list */
    .select2-dropdown {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-top: 10px;
        background: white;
    }
    .select2-search--dropdown {
        padding: 1.25rem;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    .select2-search--dropdown .select2-search__field {
        border-radius: 1rem;
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        outline: none;
        transition: 0.2s;
    }
    .select2-search--dropdown .select2-search__field:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .select2-results__option {
        padding: 1.25rem 1.75rem;
        font-weight: 600;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        transition: all 0.2s;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: linear-gradient(to right, #eff6ff, white);
        color: #1d4ed8;
        font-weight: 800;
        padding-left: 2.25rem;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#memberSelect').select2({
            placeholder: 'Scan Barcode atau Ketik Nama Anggota...',
            allowClear: true,
            ajax: {
                url: '{{ route('admin.circulation.search_member') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function(item) {
                            return { id: item.member_id, text: item.member_name + ' (' + item.member_id + ')' };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
        
        // Auto focus on select2 input
        $('#memberSelect').select2('open');
        
        // When selected, optionally auto-submit
        $('#memberSelect').on('select2:select', function (e) {
            let memberId = $(this).val();
            
            // Fetch member info
            $.get('{{ route('admin.member.attendance.check') }}', { member_id: memberId }, function(response) {
                if(response.success) {
                    let m = response.data;
                    let imageHtml = m.image ? `<img src="${m.image}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 3px solid #eff6ff;">` 
                                            : `<div style="width: 80px; height: 80px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>`;
                                            
                    Swal.fire({
                        title: 'Konfirmasi Kehadiran',
                        html: `
                            ${imageHtml}
                            <h3 style="font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; font-size: 1.25rem;">${m.member_name}</h3>
                            <div style="background: #f8fafc; padding: 1rem; border-radius: 1rem; text-align: left; margin-top: 1rem; border: 1px solid #f1f5f9;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span style="color: #64748b; font-weight: 600; font-size: 0.9rem;">ID Anggota</span>
                                    <span style="color: #0f172a; font-weight: 700; font-size: 0.9rem;">${m.member_id}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span style="color: #64748b; font-weight: 600; font-size: 0.9rem;">Total Kunjungan</span>
                                    <span style="color: #3b82f6; font-weight: 800; font-size: 0.9rem;">${m.visit_count} Kali</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #64748b; font-weight: 600; font-size: 0.9rem;">Anggota Sejak</span>
                                    <span style="color: #0f172a; font-weight: 700; font-size: 0.9rem;">${m.member_since}</span>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Konfirmasi Hadir',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#94a3b8',
                        customClass: {
                            cancelButton: 'text-white'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#attendanceForm').submit();
                        } else {
                            $('#memberSelect').val(null).trigger('change');
                            $('#memberSelect').select2('open');
                        }
                    });
                } else {
                    Swal.fire('Error', response.message, 'error').then(() => {
                        $('#memberSelect').val(null).trigger('change');
                        $('#memberSelect').select2('open');
                    });
                }
            }).fail(function() {
                Swal.fire('Error', 'Gagal menghubungi server.', 'error').then(() => {
                    $('#memberSelect').val(null).trigger('change');
                    $('#memberSelect').select2('open');
                });
            });
        });

        // Select2 auto-focus fix: when opened, ensure the search input gets focus
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    });

    @if(session('merch_reward'))
        Swal.fire({
            title: '🎉 SELAMAT! 🎉',
            html: `
                <div style="font-size: 1.1rem; color: #1e293b; margin-bottom: 1rem;">Anggota ini telah mencapai kunjungan ke-<b>{{ session("visit_count") }}</b>!</div>
                <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 0.5rem; display: block;"><polyline points="20 12 20 22 4 22 4 12"/><rect width="20" height="5" x="2" y="7"/><line x1="12" x2="12" y1="22" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
                    <h3 style="font-weight: 800; font-size: 1.25rem; margin: 0; letter-spacing: 0.05em;">BERHAK MENDAPATKAN MERCHANDISE GRATIS!</h3>
                </div>
            `,
            icon: 'success',
            confirmButtonText: 'Luar Biasa!',
            confirmButtonColor: '#f59e0b',
            width: '400px'
        }).then(() => {
            $('#memberSelect').select2('open');
        });
    @elseif(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            // Re-open select2 after success
            $('#memberSelect').select2('open');
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first() }}',
            timer: 2500,
            showConfirmButton: false
        }).then(() => {
            $('#memberSelect').select2('open');
        });
    @endif
</script>
@endsection
