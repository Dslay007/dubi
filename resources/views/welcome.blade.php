@extends('layouts.modern_landing')

@section('content')

<!-- Hero Section -->
<section style="position: relative; padding: 6rem 1rem; overflow: hidden;">
    <!-- Abstract Background Blob -->
    <div style="position: absolute; top: -10%; right: -5%; width: 50%; height: 80%; background: radial-gradient(circle, rgba(235,240,255,1) 0%, rgba(255,255,255,0) 70%); z-index: -1; pointer-events: none;"></div>
    
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
        <div>
            <span style="color: hsl(var(--primary)); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; display: block; margin-bottom: 1.5rem;">Komunitas Literasi & Lapak Baca</span>
            <h1 style="font-size: 4rem; line-height: 1.1; margin-bottom: 1.5rem; color: #0f172a; font-weight: 800; letter-spacing: -0.03em;">
                Lebih dari sekadar <br>
                <span style="background: linear-gradient(120deg, hsl(var(--primary)), hsl(var(--accent))); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">tempat membaca.</span>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 2.5rem; line-height: 1.6; max-width: 90%;">
                Duduk Baca menciptakan ruang publik yang inklusif untuk meresapi pengetahuan dan berbagi cerita di tengah hiruk pikuk Kota Malang.
            </p>
            
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('opac.index') }}" class="btn" style="padding: 1rem 2rem; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                    Cari Buku di OPAC &rarr;
                </a>
                <button onclick="document.getElementById('tentang').scrollIntoView({behavior: 'smooth'})" style="padding: 1rem 2rem; font-size: 1.1rem; background: white; border: 1px solid #e2e8f0; border-radius: 99px; font-weight: 600; color: #475569; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    Tentang Kami
                </button>
            </div>
        </div>
        
        <div style="position: relative;">
            <div style="border-radius: 2rem; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); transform: rotate(-2deg); transition: 0.3s;" onmouseover="this.style.transform='rotate(0deg) scale(1.02)'" onmouseout="this.style.transform='rotate(-2deg) scale(1)'">
                <img src="{{ asset('images/landing-hero.jpg') }}" alt="Suasana Lapak Baca" style="width: 100%; height: auto; display: block;">
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section style="background: white; padding: 4rem 1rem; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; text-align: center;">
        <div>
            <div style="font-size: 3.5rem; font-weight: 800; color: hsl(var(--primary)); margin-bottom: 0.5rem;" id="stat-borrowings">0</div>
            <div style="font-size: 1rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Peminjaman</div>
        </div>
        <div style="border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0;">
            <div style="font-size: 3.5rem; font-weight: 800; color: hsl(var(--accent)); margin-bottom: 0.5rem;" id="stat-members">0</div>
            <div style="font-size: 1rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Bacawan Terdaftar</div>
        </div>
        <div>
            <div style="font-size: 3.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;" id="stat-books">0</div>
            <div style="font-size: 1rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Koleksi Buku</div>
        </div>
    </div>
</section>

<!-- Visi Misi -->
<section style="padding: 6rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">Membangun Budaya Literasi</h2>
            <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Kami hadir untuk memastikan akses buku yang merata dan menciptakan ekosistem membaca yang menyenangkan.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            <div style="background: white; padding: 3rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                <div style="width: 50px; height: 50px; background: hsl(var(--primary-light)); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="hsl(var(--primary))" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #0f172a;">Visi Kami</h3>
                <p style="color: #475569; line-height: 1.7; font-size: 1.1rem;">
                    Menyebarluaskan budaya membaca di tempat umum dan meningkatkan minat literasi masyarakat secara berkelanjutan, menjadikan membaca sebagai gaya hidup yang keren dan inklusif.
                </p>
            </div>

            <div style="background: white; padding: 3rem; border-radius: 1.5rem; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                <div style="width: 50px; height: 50px; background: #ffe4e6; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="hsl(var(--accent))" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16 10h4"/><path d="M16 14h4"/><path d="M10 16.5c-2.5 0-4.5-2-6.5-2H2v-4h1.5c2 0 4 2 6.5 2 .5 0 1-.5 1-1V5c0-1.5 1-3 1.5-3 .5 0 1 .5 1.5 1l2.5 2.5"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #0f172a;">Misi Kami</h3>
                <ul style="color: #475569; line-height: 1.7; padding-left: 1.5rem; list-style-type: disc;">
                    <li style="margin-bottom: 0.5rem;">Menyediakan akses buku gratis melalui lapak baca mingguan.</li>
                    <li style="margin-bottom: 0.5rem;">Menciptakan ruang publik yang inklusif untuk diskusi literasi.</li>
                    <li>Mendokumentasikan dan membagikan rangkuman buku berkualitas.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Agenda Section -->
<section style="background: hsl(var(--bg)); padding: 6rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
         <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
            <div>
                 <span style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Jadwal Kegiatan</span>
                 <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a;">Agenda Komunitas</h2>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
            <!-- Upcoming -->
            <div>
                 <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #0f172a; display: flex; align-items: center;">
                    <span style="width: 8px; height: 8px; background: hsl(var(--primary)); border-radius: 50%; display: inline-block; margin-right: 0.75rem;"></span>
                    Akan Datang
                </h3>
                <div id="agenda-mendatang" style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($upcomingEvents as $event)
                    <div style="padding: 1.5rem; background: white; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                        <div style="font-size: 0.85rem; font-weight: 700; color: hsl(var(--primary)); margin-bottom: 0.25rem;">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMM YYYY') }}</div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">{{ $event->title }}</h4>
                        <p style="color: #64748b; font-size: 0.95rem;">{{ $event->location ?? 'Lokasi belum ditentukan' }}</p>
                    </div>
                    @empty
                    <p style="color: #94a3b8; font-style: italic;">Belum ada agenda terdekat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Past -->
            <div>
                 <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #64748b; display: flex; align-items: center;">
                    <span style="width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%; display: inline-block; margin-right: 0.75rem;"></span>
                    Riwayat Kegiatan
                </h3>
                <div id="agenda-berlalu" style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($pastEvents as $event)
                    <div style="padding: 1.5rem; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(5px); border-radius: 1rem; border: 1px dashed #cbd5e1; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; margin-bottom: 0.25rem;">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMM YYYY') }}</div>
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem;">{{ $event->title }}</h4>
                        <p style="color: #64748b; font-size: 0.9rem;">{{ $event->location }}</p>
                    </div>
                    @empty
                    <p style="color: #94a3b8; font-style: italic;">Belum ada riwayat kegiatan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Volunteer / Campaign Section -->
@if($campaign)
<section style="padding: 6rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto; background: #0f172a; border-radius: 2rem; overflow: hidden; color: white;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; align-items: stretch; min-height: 500px;">
            <!-- Image / Carousel Side -->
            <div style="position: relative; background: #1e293b; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                @php
                    $photos = $campaign->photos ? json_decode($campaign->photos, true) : [];
                @endphp

                @if(!empty($photos))
                    <div id="campaign-carousel" style="position: absolute; inset: 0; width: 100%; height: 100%;">
                        @foreach($photos as $index => $photo)
                        <div class="campaign-slide" style="position: absolute; inset: 0; opacity: {{ $index === 0 ? 1 : 0 }}; transition: opacity 0.8s ease-in-out; background-image: url('{{ asset('uploads/acara/' . $photo) }}'); background-size: cover; background-position: center;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 2rem; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);"></div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if(count($photos) > 1)
                    <!-- Carousel Controls -->
                    <button onclick="changeCampaignSlide(-1)" style="position: absolute; top: 50%; left: 1.5rem; transform: translateY(-50%); background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border: none; color: white; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i data-lucide="chevron-left" style="width: 1.25rem; height: 1.25rem;"></i>
                    </button>
                    <button onclick="changeCampaignSlide(1)" style="position: absolute; top: 50%; right: 1.5rem; transform: translateY(-50%); background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border: none; color: white; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i data-lucide="chevron-right" style="width: 1.25rem; height: 1.25rem;"></i>
                    </button>
                    
                    <script>
                        let currentCampaignSlide = 0;
                        function changeCampaignSlide(n) {
                            const slides = document.querySelectorAll('.campaign-slide');
                            if (slides.length <= 1) return;
                            
                            slides[currentCampaignSlide].style.opacity = 0;
                            currentCampaignSlide = (currentCampaignSlide + n + slides.length) % slides.length;
                            slides[currentCampaignSlide].style.opacity = 1;
                        }
                        
                        setInterval(() => {
                            changeCampaignSlide(1);
                        }, 4000);
                    </script>
                    @endif
                @else
                    <!-- Fallback if no photo -->
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #475569; width: 100%; height: 100%;">
                        <i data-lucide="image" style="width: 4rem; height: 4rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <span>Tidak ada foto acara</span>
                    </div>
                @endif
            </div>

            <!-- Content Side -->
            <div style="padding: 4rem; display: flex; flex-direction: column; justify-content: center;">
                <span style="color: hsl(var(--accent)); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; display: block; margin-bottom: 1rem;">Bergabung Bersama Kami</span>
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">{{ $campaign->title }}</h2>
                
                <div style="color: #cbd5e1; font-size: 1.1rem; margin-bottom: 2.5rem; line-height: 1.7; white-space: pre-line;">
                    {!! nl2br(e($campaign->description)) !!}
                </div>

                @if($campaign->registration_link)
                <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.1); display: inline-block;">
                    <p style="font-size: 0.95rem; margin-bottom: 1rem;">
                        <span style="color: #ecfeff; font-weight: 600;">👋 Daftar Sekarang!</span><br>
                        Klik tombol di bawah ini untuk mendaftar.
                    </p>
                    <a href="{{ route('kegiatan.daftar', $campaign->id) }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.5rem; background: hsl(var(--accent)); text-shadow: none;" target="_blank">
                        Isi Formulir Pendaftaran
                        <i data-lucide="external-link" style="width: 1.1rem; height: 1.1rem;"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- About Section -->
<section id="tentang" style="background: white; padding: 6rem 1rem;">
    <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
         <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 3rem;">Tentang Duduk Baca</h2>
         
         <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; text-align: left;">
             <div>
                 <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: hsl(var(--primary));">Filosofi</h3>
                 <p style="color: #475569; line-height: 1.8; margin-bottom: 1.5rem;">
                     Kami percaya bahwa membaca adalah hak semua orang. <strong>"Duduk Baca"</strong> bukan hanya tentang membaca buku, tetapi tentang menciptakan momen tenang untuk meresapi pengetahuan di ruang publik.
                 </p>
                 <p style="color: #475569; line-height: 1.8;">
                     Kami menyebut para penggemar dan peminjam buku kami sebagai <span style="font-weight: 700; color: #0f172a;">"BACAWAN"</span>.
                 </p>
             </div>
             <div>
                  <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: hsl(var(--primary));">Kegiatan</h3>
                  <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                      <div style="display: flex; gap: 1rem;">
                          <div style="font-size: 1.5rem;">📚</div>
                          <div>
                              <h4 style="font-weight: 700; color: #0f172a;">Lapak Baca Publik</h4>
                              <p style="font-size: 0.9rem; color: #64748b;">Setiap Minggu di Alun-Alun Malang.</p>
                          </div>
                      </div>
                      <div style="display: flex; gap: 1rem;">
                          <div style="font-size: 1.5rem;">💻</div>
                          <div>
                              <h4 style="font-weight: 700; color: #0f172a;">Peminjaman Online</h4>
                              <p style="font-size: 0.9rem; color: #64748b;">Booking buku fisik via website ini.</p>
                          </div>
                      </div>
                  </div>
             </div>
         </div>
    </div>
</section>

<!-- Jurnal Lapak Section -->
<section style="background: #f8fafc; padding: 6rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
         <div style="text-align: center; margin-bottom: 4rem;">
             <span style="color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Jurnal Lapak</span>
             <h2 style="font-size: 2.5rem; font-weight: 800; color: #0f172a;">Cerita & Kabar Terbaru</h2>
         </div>

         <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
             @forelse($jurnals as $jurnal)
             <div style="background: white; border-radius: 1.5rem; overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                 @if($jurnal->cover_image)
                 <div style="height: 200px; overflow: hidden;">
                     <img src="{{ asset('uploads/jurnal/' . $jurnal->cover_image) }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                 </div>
                 @else
                 <div style="height: 200px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                     <i data-lucide="image" style="width: 3rem; height: 3rem;"></i>
                 </div>
                 @endif
                 
                 <div style="padding: 2rem;">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                         <span style="background: rgba(14, 165, 233, 0.1); color: #0284c7; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">{{ $jurnal->category ?? 'Berita' }}</span>
                         <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">
                             {{ $jurnal->created_at->format('d M Y') }}
                         </span>
                     </div>
                     <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem; line-height: 1.4;">
                         {{ $jurnal->title }}
                     </h3>
                     <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                         {{ Str::limit(strip_tags($jurnal->content), 120) }}
                     </p>
                     
                     <a href="#" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #0f172a; font-weight: 700; text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='hsl(var(--primary))'" onmouseout="this.style.color='#0f172a'">
                         Baca Selengkapnya
                         <i data-lucide="arrow-right" style="width: 1rem; height: 1rem;"></i>
                     </a>
                 </div>
             </div>
             @empty
             <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 3rem;">
                 <i data-lucide="newspaper" style="width: 3rem; height: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                 <p>Belum ada cerita atau jurnal terbaru.</p>
             </div>
             @endforelse
         </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', () => {


        // --- STATS ---
        const animateValue = (id, start, end, duration) => {
            const obj = document.getElementById(id);
            if (!obj) return;
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString('id-ID');
                if (progress < 1) window.requestAnimationFrame(step);
            };
            window.requestAnimationFrame(step);
        };

        animateValue("stat-borrowings", 0, {{ $stats['borrowings'] }}, 2000);
        animateValue("stat-members", 0, {{ $stats['members'] }}, 2000);
        animateValue("stat-books", 0, {{ $stats['books'] }}, 2000);
    });
</script>
@endsection