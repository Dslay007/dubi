@extends('layouts.admin')

@section('pageTitle', 'Counter Tamu')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    {{-- Today's Guest Count Card --}}
    <div style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border-radius: 1.5rem; padding: 2rem; color: white; box-shadow: 0 10px 30px -10px rgba(99,102,241,0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; right: 40px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; position: relative; z-index: 1;">
            <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            </div>
            <div>
                <div style="font-size: 0.85rem; font-weight: 600; opacity: 0.85;">Tamu Hari Ini</div>
            </div>
        </div>
        <div id="todayCountDisplay" style="font-size: 3rem; font-weight: 800; line-height: 1; position: relative; z-index: 1;">{{ $todayCount }}</div>
        <div style="font-size: 0.8rem; opacity: 0.7; margin-top: 0.5rem; position: relative; z-index: 1;">{{ now()->format('l, d F Y') }}</div>
    </div>

    {{-- Quick Info Card --}}
    <div style="background: white; border-radius: 1.5rem; padding: 2rem; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: center;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
            <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div>
                <div style="font-weight: 800; color: #0f172a; font-size: 1.1rem;">Informasi</div>
            </div>
        </div>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6; margin: 0;">
            Halaman ini khusus untuk mencatat kunjungan <strong style="color: #0f172a;">pengunjung non-anggota (tamu)</strong>. 
            Untuk pencatatan kunjungan anggota, gunakan menu <a href="{{ route('admin.member.attendance') }}" style="color: #3b82f6; font-weight: 700; text-decoration: none;">Absensi Anggota</a>.
        </p>
    </div>
</div>

{{-- Input Form --}}
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <h3 style="font-weight: 800; color: #0f172a; font-size: 1.25rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #6366f1;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            Catat Kunjungan Tamu
        </h3>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Isi nama dan asal institusi tamu yang berkunjung.</p>
    </div>

    <div style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <div style="width: 100%; max-width: 550px;">
            <div style="width: 80px; height: 80px; background: #eef2ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: inset 0 0 0 6px #e0e7ff;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6366f1;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>

            <form id="guestForm">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-weight: 700; font-size: 0.9rem; color: #475569; margin-bottom: 0.5rem;">
                        Nama Tamu <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <input type="text" id="guest_name" name="guest_name" required autocomplete="off"
                            style="width: 100%; padding: 1rem 1rem 1rem 3rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 1rem; font-weight: 500; color: #1e293b; transition: border-color 0.2s; font-family: inherit;"
                            placeholder="Masukkan nama tamu..."
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)';"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 700; font-size: 0.9rem; color: #475569; margin-bottom: 0.5rem;">
                        Institusi / Asal
                    </label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                        <input type="text" id="institution" name="institution" autocomplete="off"
                            style="width: 100%; padding: 1rem 1rem 1rem 3rem; border: 2px solid #cbd5e1; border-radius: 0.75rem; outline: none; font-size: 1rem; font-weight: 500; color: #1e293b; transition: border-color 0.2s; font-family: inherit;"
                            placeholder="Nama sekolah, organisasi, dll. (opsional)"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)';"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                    </div>
                </div>

                <button type="submit" id="submitBtn" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 99px; font-weight: 800; font-size: 1rem; width: 100%; box-shadow: 0 4px 6px -1px rgba(99,102,241,0.3); transition: 0.2s; cursor: pointer; font-family: inherit;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px -3px rgba(99,102,241,0.4)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px -1px rgba(99,102,241,0.3)';">
                    <span style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        Catat Kunjungan
                    </span>
                </button>
            </form>

            <p style="margin-top: 2rem; color: #94a3b8; font-size: 0.85rem; text-align: center;">Data tamu akan tersimpan di log pengunjung perpustakaan.</p>
        </div>
    </div>
</div>

{{-- Recent Guests Table --}}
<div style="background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);">
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="font-weight: 800; color: #0f172a; font-size: 1.1rem; margin-bottom: 0.15rem;">Tamu Terbaru</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">10 kunjungan tamu terakhir yang tercatat.</p>
        </div>
        <a href="{{ route('admin.visitor.index') }}" style="background: #f1f5f9; color: #475569; padding: 0.5rem 1rem; border-radius: 99px; font-weight: 700; text-decoration: none; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.35rem; transition: 0.2s; border: 1px solid #e2e8f0;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            Lihat Semua Pengunjung
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table id="recentGuestsTable" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.05em;">
                    <th style="padding: 1rem 1.5rem; border-bottom: 2px solid rgba(0,0,0,0.05); width: 50px;">#</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Nama Tamu</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Institusi</th>
                    <th style="padding: 1rem 1.5rem; border-bottom: 2px solid rgba(0,0,0,0.05);">Waktu Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentGuests as $index => $guest)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1rem 1.5rem; color: #94a3b8; font-weight: 700;">{{ $index + 1 }}</td>
                    <td style="padding: 1rem 1.5rem; font-weight: 700; color: #1e293b;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #4f46e5; font-size: 0.8rem; flex-shrink: 0;">
                                {{ strtoupper(substr($guest->member_name, 0, 1)) }}
                            </div>
                            {{ $guest->member_name }}
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b;">{{ $guest->institution ?: '-' }}</td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.85rem;">
                        <span style="background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($guest->checkin_date)->format('d M Y, H:i') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 3rem; text-align: center;">
                        <div style="width: 56px; height: 56px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; margin: 0 auto 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        </div>
                        <h4 style="font-weight: 700; color: #475569; font-size: 1rem; margin-bottom: 0.25rem;">Belum Ada Tamu</h4>
                        <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">Belum ada kunjungan tamu yang tercatat.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
    document.getElementById('guestForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const nameInput = document.getElementById('guest_name');
        const instInput = document.getElementById('institution');
        const submitBtn = document.getElementById('submitBtn');

        if (!nameInput.value.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Nama Wajib Diisi',
                text: 'Silakan masukkan nama tamu terlebih dahulu.',
                timer: 2500,
                showConfirmButton: false
            });
            nameInput.focus();
            return;
        }

        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';

        const formData = new FormData(this);

        fetch("{{ route('admin.member.guest_counter.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update counter display
                document.getElementById('todayCountDisplay').textContent = data.today_count;

                // Add new row to table
                addGuestToTable(data.guest_name, instInput.value || '-');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: `
                        <div style="margin-top: 0.5rem;">
                            <div style="font-weight: 700; font-size: 1.1rem; color: #1e293b; margin-bottom: 0.5rem;">${data.guest_name}</div>
                            <div style="background: #f1f5f9; padding: 0.75rem 1rem; border-radius: 0.75rem; display: inline-block;">
                                <span style="color: #64748b; font-weight: 600;">Tamu hari ini:</span>
                                <span style="color: #6366f1; font-weight: 800; font-size: 1.1rem; margin-left: 0.25rem;">${data.today_count}</span>
                            </div>
                        </div>
                    `,
                    timer: 2500,
                    showConfirmButton: false
                });

                // Clear form
                nameInput.value = '';
                instInput.value = '';
                nameInput.focus();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat menyimpan data.',
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        });
    });

    function addGuestToTable(name, institution) {
        const tbody = document.querySelector('#recentGuestsTable tbody');
        const emptyRow = tbody.querySelector('td[colspan]');
        if (emptyRow) {
            emptyRow.closest('tr').remove();
        }

        const now = new Date();
        const dateStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        const initial = name.charAt(0).toUpperCase();

        const newRow = document.createElement('tr');
        newRow.style.cssText = 'border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s; background: #f0fdf4;';
        newRow.onmouseover = function() { this.style.background = '#f8fafc'; };
        newRow.onmouseout = function() { this.style.background = 'transparent'; };
        newRow.innerHTML = `
            <td style="padding: 1rem 1.5rem; color: #94a3b8; font-weight: 700;">•</td>
            <td style="padding: 1rem 1.5rem; font-weight: 700; color: #1e293b;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #4f46e5; font-size: 0.8rem; flex-shrink: 0;">
                        ${initial}
                    </div>
                    ${name}
                </div>
            </td>
            <td style="padding: 1rem 1.5rem; color: #64748b;">${institution}</td>
            <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.85rem;">
                <span style="background: #dcfce7; padding: 0.25rem 0.75rem; border-radius: 99px; font-weight: 600; color: #16a34a;">
                    Baru saja
                </span>
            </td>
        `;

        tbody.insertBefore(newRow, tbody.firstChild);

        // Animate highlight
        setTimeout(() => {
            newRow.style.background = 'transparent';
        }, 2000);

        // Remove last row if more than 10
        const rows = tbody.querySelectorAll('tr');
        if (rows.length > 10) {
            rows[rows.length - 1].remove();
        }

        // Re-number rows
        let num = 1;
        tbody.querySelectorAll('tr').forEach(row => {
            const firstTd = row.querySelector('td');
            if (firstTd && !firstTd.getAttribute('colspan')) {
                firstTd.textContent = num++;
            }
        });
    }
</script>
@endsection
