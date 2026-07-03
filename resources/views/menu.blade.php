<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizzMap — Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylemenu.css') }}">
</head>
<body>
@include('partials.loading-screen')

{{-- TOPBAR --}}
<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-logo">
            <i class="fas fa-map-marked-alt" style="color:#fff;font-size:16px;"></i>
        </div>
        <span class="topbar-name">BizzMap</span>
    </div>
    <div class="topbar-right">
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'ar')
        <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Admin
        </a>
        @endif
        <a href="{{ route('logout') }}" class="btn-logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</div>

{{-- HERO SECTION --}}
<div class="hero">
    <div class="hero-bg"></div>
    <div class="hero-gradient"></div>
    <div class="hero-content">
        <p class="hero-eyebrow">Sistem Pemetaan Segmen Pelanggan</p>
        <h1 class="hero-title">Selamat datang di BizzMap</h1>
        <p class="hero-sub">PT Telkom Indonesia — Branch Jambi &nbsp;·&nbsp; Pilih halaman yang ingin dituju</p>

        <div class="cards-grid">
            {{-- Card Peta (hero/besar) --}}
            <a href="{{ url('/geo') }}" class="card-nav card-hero">
                {{-- Animasi SVG grid peta --}}
                <div class="card-anim card-anim-map" aria-hidden="true">
                    <svg viewBox="0 0 300 200" xmlns="http://www.w3.org/2000/svg"
                         width="100%" height="100%">
                        <line x1="0" y1="40" x2="300" y2="40" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="0" y1="80" x2="300" y2="80" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="0" y1="120" x2="300" y2="120" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="0" y1="160" x2="300" y2="160" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="60" y1="0" x2="60" y2="200" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="120" y1="0" x2="120" y2="200" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="180" y1="0" x2="180" y2="200" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <line x1="240" y1="0" x2="240" y2="200" stroke="rgba(192,32,22,0.4)" stroke-width="0.8"/>
                        <circle cx="120" cy="80" r="6" fill="rgba(192,32,22,0.7)"/>
                        <circle cx="120" cy="80" r="12" fill="none"
                                stroke="rgba(192,32,22,0.35)" stroke-width="1.5">
                            <animate attributeName="r" values="8;18;8"
                                     dur="2s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.5;0;0.5"
                                     dur="2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="210" cy="130" r="5" fill="rgba(192,32,22,0.5)"/>
                        <circle cx="70" cy="150" r="4" fill="rgba(192,32,22,0.4)"/>
                    </svg>
                </div>
                <div>
                    <div class="card-icon icon-red">
                        <i class="fas fa-map-marker-alt" style="color:#fff;font-size:20px;"></i>
                    </div>
                    <p class="card-title-big">Peta</p>
                    <p class="card-desc">Visualisasi interaktif lokasi pelanggan dan non-pelanggan Indibiz di 8 kecamatan Kota Jambi — lengkap dengan filter, heatmap, dan batas wilayah</p>
                </div>
                <div class="card-footer">
                    <div style="display:flex;gap:6px;">
                        <span class="badge-nav badge-red">Customer</span>
                        <span class="badge-nav badge-gray">Non-customer</span>
                    </div>
                    <div class="arrow-btn arrow-red">
                        <i class="fas fa-arrow-right" style="color:#fff;font-size:14px;"></i>
                    </div>
                </div>
            </a>

            {{-- 2 card kecil di kanan --}}
            <div class="card-right-col">
                <a href="{{ url('/demografi') }}" class="card-nav card-sm card-demo">
                    {{-- Animasi SVG bar chart --}}
                    <div class="card-anim card-anim-demo" aria-hidden="true">
                        <svg viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg"
                             width="100%" height="100%">
                            <rect x="20" y="60" width="22" height="0" fill="rgba(55,138,221,0.5)" rx="3">
                                <animate attributeName="height" values="0;55;0"
                                         dur="2.5s" repeatCount="indefinite" begin="0s"/>
                                <animate attributeName="y" values="120;65;120"
                                         dur="2.5s" repeatCount="indefinite" begin="0s"/>
                            </rect>
                            <rect x="55" y="80" width="22" height="0" fill="rgba(55,138,221,0.4)" rx="3">
                                <animate attributeName="height" values="0;35;0"
                                         dur="2.5s" repeatCount="indefinite" begin="0.3s"/>
                                <animate attributeName="y" values="120;85;120"
                                         dur="2.5s" repeatCount="indefinite" begin="0.3s"/>
                            </rect>
                            <rect x="90" y="40" width="22" height="0" fill="rgba(55,138,221,0.6)" rx="3">
                                <animate attributeName="height" values="0;75;0"
                                         dur="2.5s" repeatCount="indefinite" begin="0.6s"/>
                                <animate attributeName="y" values="120;45;120"
                                         dur="2.5s" repeatCount="indefinite" begin="0.6s"/>
                            </rect>
                            <rect x="125" y="55" width="22" height="0" fill="rgba(55,138,221,0.45)" rx="3">
                                <animate attributeName="height" values="0;60;0"
                                         dur="2.5s" repeatCount="indefinite" begin="0.9s"/>
                                <animate attributeName="y" values="120;60;120"
                                         dur="2.5s" repeatCount="indefinite" begin="0.9s"/>
                            </rect>
                            <rect x="160" y="70" width="22" height="0" fill="rgba(55,138,221,0.35)" rx="3">
                                <animate attributeName="height" values="0;45;0"
                                         dur="2.5s" repeatCount="indefinite" begin="1.2s"/>
                                <animate attributeName="y" values="120;75;120"
                                         dur="2.5s" repeatCount="indefinite" begin="1.2s"/>
                            </rect>
                        </svg>
                    </div>
                    <div>
                        <div class="card-icon icon-blue" style="width:38px;height:38px;border-radius:9px;margin-bottom:10px;">
                            <i class="fas fa-users" style="color:#7ab8f5;font-size:17px;"></i>
                        </div>
                        <p class="card-title-sm">Demografi</p>
                        <p class="card-desc">Distribusi segmen, omset, dan statistik pelanggan</p>
                    </div>
                    <div class="card-footer-sm">
                        <span class="badge-nav badge-gray">Chart &amp; stats</span>
                        <div class="arrow-btn arrow-btn-sm arrow-blue">
                            <i class="fas fa-arrow-right" style="color:#7ab8f5;font-size:12px;"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/analytics') }}" class="card-nav card-sm card-ana">
                    {{-- Animasi SVG line chart --}}
                    <div class="card-anim card-anim-ana" aria-hidden="true">
                        <svg viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg"
                             width="100%" height="100%">
                            <polyline points="10,100 50,75 90,85 130,45 170,30 200,20"
                                      fill="none" stroke="rgba(29,158,117,0.5)"
                                      stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-dasharray="300"
                                      stroke-dashoffset="300">
                                <animate attributeName="stroke-dashoffset"
                                         values="300;0;300" dur="3s"
                                         repeatCount="indefinite"/>
                            </polyline>
                            <polygon points="10,100 50,75 90,85 130,45 170,30 200,20 200,120 10,120"
                                     fill="rgba(29,158,117,0.08)"/>
                            <circle cx="130" cy="45" r="3" fill="rgba(29,158,117,0.7)"/>
                            <circle cx="170" cy="30" r="3" fill="rgba(29,158,117,0.7)"/>
                        </svg>
                    </div>
                    <div>
                        <div class="card-icon icon-teal" style="width:38px;height:38px;border-radius:9px;margin-bottom:10px;">
                            <i class="fas fa-chart-line" style="color:#5dcaa5;font-size:17px;"></i>
                        </div>
                        <p class="card-title-sm">Analytics</p>
                        <p class="card-desc">Rekomendasi otomatis &amp; analisis segmen potensial</p>
                    </div>
                    <div class="card-footer-sm">
                        <span class="badge-nav badge-gray">Rekomendasi</span>
                        <div class="arrow-btn arrow-btn-sm arrow-teal">
                            <i class="fas fa-arrow-right" style="color:#5dcaa5;font-size:12px;"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="infobar">
            <i class="fas fa-building" style="color:#ff8a80;font-size:15px;flex-shrink:0;"></i>
            <p class="infobar-text">PT Telkom Indonesia &nbsp;·&nbsp; Branch Jambi &nbsp;·&nbsp; Produk Indibiz untuk segmen UKM</p>
        </div>

        <div class="scroll-hint">
            <p>Scroll untuk info lebih</p>
            <div class="scroll-dot"></div>
        </div>
    </div>
</div>

<div class="section-divider"></div>

{{-- SECTION 1: INDIBIZ EKOSISTEM --}}
<div class="section">
    <span class="section-tag">Ekosistem</span>
    <h2 class="section-title">Mengenal Indibiz</h2>
    <p class="section-sub">Platform B2B dari Telkom Indonesia yang menghadirkan ragam solusi digital untuk bisnis — khususnya segmen UKM di seluruh Indonesia.</p>

    <div class="indibiz-hero">
        <div class="indibiz-logo-box">
            <img src="{{ asset('img/indibiz-logo.webp') }}"
                 alt="Logo Indibiz"
                 onerror="this.parentElement.innerHTML=
                 '<i class=\'fas fa-building-store\'
                  style=\'color:#C02016;font-size:28px\'></i>'">
        </div>
        <div class="indibiz-hero-text">
            <h3>Indibiz by Telkom Indonesia</h3>
            <p>Ekosistem solusi digital dunia usaha dari Telkom Indonesia yang membantu pebisnis menciptakan peluang dan mewujudkan harapannya — khususnya bagi pelaku UKM di berbagai daerah di Indonesia.</p>
            <p class="indibiz-tagline">Ciptakan peluang, wujudkan harapan</p>
        </div>
    </div>

    <p class="segments-label">4 Pilar strategis Indibiz</p>
    <div class="pillars-grid">
        <div class="pillar-card">
            <div class="pillar-num">1</div>
            <div>
                <p class="pillar-title">Platform &amp; layanan digital</p>
                <p class="pillar-desc">Solusi konektivitas dan digitalisasi operasional bisnis</p>
            </div>
        </div>
        <div class="pillar-card">
            <div class="pillar-num">2</div>
            <div>
                <p class="pillar-title">Kolaborasi startup &amp; developer</p>
                <p class="pillar-desc">Ekosistem inovasi bersama mitra teknologi untuk kemajuan UKM</p>
            </div>
        </div>
        <div class="pillar-card">
            <div class="pillar-num">3</div>
            <div>
                <p class="pillar-title">Solusi pembiayaan</p>
                <p class="pillar-desc">Kolaborasi dengan lembaga keuangan untuk akses modal UKM</p>
            </div>
        </div>
        <div class="pillar-card">
            <div class="pillar-num">4</div>
            <div>
                <p class="pillar-title">Komunitas dunia usaha</p>
                <p class="pillar-desc">Kolaborasi bersama komunitas bisnis untuk tingkatkan produktivitas</p>
            </div>
        </div>
    </div>

    <p class="segments-label" style="margin-top:8px;">Segmen yang dilayani</p>
    <div class="segments-grid">
        <div class="seg-chip">
            <i class="fas fa-school"></i>
            <p>Pendidikan</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-hotel"></i>
            <p>Perhotelan</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-utensils"></i>
            <p>Makanan &amp; Minuman</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-store"></i>
            <p>Pertokoan / Ruko</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-heartbeat"></i>
            <p>Kesehatan</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-bolt"></i>
            <p>Energi</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-truck"></i>
            <p>Ekspedisi</p>
        </div>
        <div class="seg-chip">
            <i class="fas fa-industry"></i>
            <p>Manufaktur</p>
        </div>
    </div>
</div>

<div class="section-divider"></div>

{{-- SECTION 2: FITUR BIZZMAP --}}
<div class="section">
    <span class="section-tag">Fitur</span>
    <h2 class="section-title">Apa yang bisa dilakukan BizzMap?</h2>
    <p class="section-sub">Platform GIS berbasis web untuk mendukung tim Sales dalam memetakan dan menganalisis potensi pelanggan Indibiz.</p>
    <div class="features-grid">
        <div class="feat-card">
            <div class="feat-icon"
                 style="background:rgba(192,32,22,.15);
                        border:1px solid rgba(192,32,22,.25)">
                <i class="fas fa-map-marker-alt"
                   style="color:#ff8a80;font-size:16px;"></i>
            </div>
            <p class="feat-title">Pemetaan lokasi</p>
            <p class="feat-desc">Tandai lokasi usaha sebagai customer atau non-customer langsung di peta interaktif</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon"
                 style="background:rgba(55,138,221,.15);
                        border:1px solid rgba(55,138,221,.25)">
                <i class="fas fa-crosshairs"
                   style="color:#7ab8f5;font-size:16px;"></i>
            </div>
            <p class="feat-title">GPS real-time</p>
            <p class="feat-desc">Ambil koordinat otomatis dari perangkat dengan akurasi radius yang ditampilkan di peta</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon"
                 style="background:rgba(29,158,117,.15);
                        border:1px solid rgba(29,158,117,.25)">
                <i class="fas fa-home"
                   style="color:#5dcaa5;font-size:16px;"></i>
            </div>
            <p class="feat-title">Alamat otomatis</p>
            <p class="feat-desc">Reverse geocoding via Nominatim OpenStreetMap — alamat terisi sendiri dari koordinat GPS</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon"
                 style="background:rgba(192,32,22,.15);
                        border:1px solid rgba(192,32,22,.25)">
                <i class="fas fa-chart-pie"
                   style="color:#ff8a80;font-size:16px;"></i>
            </div>
            <p class="feat-title">Analisis demografi</p>
            <p class="feat-desc">Chart distribusi omset, paket langganan, bidang bisnis, dan tren konversi pelanggan</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon"
                 style="background:rgba(55,138,221,.15);
                        border:1px solid rgba(55,138,221,.25)">
                <i class="fas fa-flag"
                   style="color:#7ab8f5;font-size:16px;"></i>
            </div>
            <p class="feat-title">Sistem flag kualitas</p>
            <p class="feat-desc">Deteksi otomatis data duplikat, nama tidak wajar, dan koordinat di luar wilayah Jambi</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon"
                 style="background:rgba(29,158,117,.15);
                        border:1px solid rgba(29,158,117,.25)">
                <i class="fas fa-lightbulb"
                   style="color:#5dcaa5;font-size:16px;"></i>
            </div>
            <p class="feat-title">Rekomendasi otomatis</p>
            <p class="feat-desc">Saran strategi penjualan per kecamatan berdasarkan jumlah non-customer potensial</p>
        </div>
    </div>
</div>

<div class="section-divider"></div>

{{-- SECTION 3: ALUR KERJA --}}
<div class="section">
    <span class="section-tag">Alur kerja</span>
    <h2 class="section-title">Bagaimana cara kerjanya?</h2>
    <p class="section-sub">Alur sederhana dari input data lapangan hingga keputusan strategis.</p>
    <div class="timeline">
        <div class="timeline-item">
            <div class="tl-dot">
                <i class="fas fa-map-marker-alt"
                   style="color:#ff8a80;font-size:13px;"></i>
            </div>
            <div class="tl-content">
                <p class="tl-title">SA input data lokasi usaha</p>
                <p class="tl-desc">Tandai koordinat di peta atau gunakan GPS otomatis, lengkap dengan nama, alamat, omset, dan paket langganan</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="tl-dot">
                <i class="fas fa-check"
                   style="color:#ff8a80;font-size:13px;"></i>
            </div>
            <div class="tl-content">
                <p class="tl-title">AR atau Admin verifikasi &amp; approve</p>
                <p class="tl-desc">Data pending ditinjau, flag kualitas diperiksa, lalu disetujui agar tampil di peta publik tim</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="tl-dot">
                <i class="fas fa-chart-bar"
                   style="color:#ff8a80;font-size:13px;"></i>
            </div>
            <div class="tl-content">
                <p class="tl-title">Data masuk ke Demografi &amp; Analytics</p>
                <p class="tl-desc">Chart dan statistik otomatis diperbarui — distribusi segmen, tren konversi, dan rekomendasi strategi</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="tl-dot">
                <i class="fas fa-lightbulb"
                   style="color:#ff8a80;font-size:13px;"></i>
            </div>
            <div class="tl-content">
                <p class="tl-title">Tim Sales ambil keputusan berbasis data</p>
                <p class="tl-desc">Prioritaskan kecamatan dengan potensi non-customer tertinggi untuk akuisisi pelanggan Indibiz baru</p>
            </div>
        </div>
    </div>
</div>

{{-- FOOTER --}}
<div class="footer-section">
    <div class="footer-left">
        <p>BizzMap — Sistem Pemetaan Segmen Pelanggan Indibiz<br>
           PT Telkom Indonesia Branch Jambi</p>
    </div>
    <div class="footer-brand">
        <img src="{{ asset('img/indibiz-logo.webp') }}"
             alt="Indibiz"
             class="footer-brand-logo"
             onerror="this.style.display='none'">
        <p class="footer-brand-sub">Ekosistem Solusi Dunia Usaha</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
