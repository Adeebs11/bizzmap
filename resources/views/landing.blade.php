<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizzMap — Platform GIS Indibiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylelanding.css') }}">
    {{-- Lottie Player --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body>

{{-- SPLIT BACKGROUNDS --}}
<div class="split-left"></div>
<div class="split-right"></div>
<div class="split-accent"></div>
<div class="bg-map-img"></div>

{{-- NAVBAR --}}
<nav class="navbar-custom">
    <div class="nav-logo">
        <div class="nav-icon">
            <i class="fas fa-map-marked-alt"></i>
        </div>
        <span class="nav-name">BizzMap</span>
    </div>
    <div class="nav-links">
        <a href="#fitur" class="nav-link">Fitur</a>
        <a href="#tentang" class="nav-link">Tentang</a>
    </div>
    <a href="{{ url('/login') }}" class="nav-cta">
        Masuk <i class="fas fa-arrow-right" style="font-size:11px"></i>
    </a>
</nav>

{{-- HERO --}}
<div class="hero-wrap">

    {{-- LEFT: TEXT --}}
    <div class="hero-left">
        <div class="hero-eyebrow">
            <span class="eyebrow-dot"></span>
            <span class="eyebrow-text">PT Telkom Indonesia — Branch Jambi</span>
        </div>
        <h1 class="hero-title">Peta</h1>
        <h1 class="hero-title-italic">Cerdas</h1>
        <h1 class="hero-title-light">Indibiz</h1>
        <div class="hero-divider"></div>
        <p class="hero-desc">
            Platform GIS interaktif untuk memetakan dan menganalisis
            potensi pelanggan Indibiz di seluruh Kota Jambi.
        </p>
        <a href="{{ url('/login') }}" class="btn-cta">
            Mulai sekarang
            <i class="fas fa-arrow-right"></i>
        </a>
        <div class="scroll-ind">
            <div class="scroll-dot"></div>
            <div class="scroll-line"></div>
            <p>Scroll</p>
        </div>
    </div>

    {{-- RIGHT: LOTTIE ANIMATION --}}
    <div class="hero-right">

        {{-- Pulsing rings behind lottie --}}
        <div class="pulse-ring" style="width:560px;height:560px;"></div>
        <div class="pulse-ring" style="width:440px;height:440px;"></div>
        <div class="pulse-ring" style="width:320px;height:320px;"></div>

        {{-- Floating coordinate texts --}}
        <span class="coord-float" style="top:15%;left:8%;">-1.6101° S</span>
        <span class="coord-float" style="top:22%;left:8%;">103.6131° E</span>
        <span class="coord-float" style="bottom:20%;right:5%;">Kota Jambi</span>
        <span class="coord-float" style="bottom:28%;right:5%;">8 Kecamatan</span>

        {{-- Lottie Animation --}}
        <div class="lottie-wrap">
            <lottie-player
                src="{{ asset('animations/map-pin-location.json') }}"
                background="transparent"
                speed="1"
                loop
                autoplay>
            </lottie-player>
        </div>

        {{-- Floating data cards --}}
        <div class="deco-card deco-card-top">
            <div class="deco-card-label">Total lokasi</div>
            <div class="deco-card-value" id="counter-lokasi">0</div>
            <div class="deco-card-sub">↑ Terpetakan di Jambi</div>
        </div>
        <div class="deco-card deco-card-bottom">
            <div class="deco-card-label">Potensi non-customer</div>
            <div class="deco-card-value" id="counter-potential">0</div>
            <div class="deco-card-sub-red">● Siap diakuisisi</div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* Smooth scroll untuk nav links */
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth' });
    });
});

/* Counter animasi naik untuk data cards */
function animateCounter(id, target, duration) {
    const el = document.getElementById(id);
    if (!el) return;
    let start = 0;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        start += step;
        if (start >= target) { el.textContent = target; clearInterval(timer); return; }
        el.textContent = Math.floor(start);
    }, 16);
}

/* Jalankan counter setelah halaman load */
window.addEventListener('load', () => {
    setTimeout(() => {
        animateCounter('counter-lokasi', 36, 1500);
        animateCounter('counter-potential', 23, 1800);
    }, 600);
});
</script>
</body>
</html>
