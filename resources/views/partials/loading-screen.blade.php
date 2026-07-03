{{-- Loading Screen Overlay --}}
<div id="loading-screen" aria-hidden="true">
    <div class="loading-content">
        <div class="loading-logo">
            <img src="{{ asset('img/indibiz-logo.webp') }}"
                 alt="Indibiz"
                 onerror="this.style.display='none';
                          document.querySelector('.loading-fallback')
                          .style.display='flex'">
            <div class="loading-fallback">
                <i class="fas fa-map-marked-alt"></i>
                <span>BizzMap</span>
            </div>
        </div>
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring spinner-ring-2"></div>
        </div>
    </div>
</div>

<style>
#loading-screen {
    position: fixed;
    inset: 0;
    background: #0a0f1e;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    transition: opacity 0.4s ease;
    pointer-events: all;
}
#loading-screen.fade-out {
    opacity: 0;
    pointer-events: none;
}
#loading-screen.hidden {
    display: none;
}
.loading-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 24px;
}
.loading-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 48px;
}
.loading-logo img {
    height: 40px;
    width: auto;
    object-fit: contain;
    filter: brightness(0) invert(1);
}
.loading-fallback {
    display: none;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
}
.loading-fallback i {
    color: #C02016;
    font-size: 24px;
}
.loading-spinner {
    position: relative;
    width: 48px;
    height: 48px;
}
.spinner-ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2.5px solid transparent;
    border-top-color: #C02016;
    animation: spinnerRotate 0.9s linear infinite;
}
.spinner-ring-2 {
    inset: 6px;
    border-top-color: rgba(192,32,22,0.35);
    animation-duration: 1.4s;
    animation-direction: reverse;
}
@keyframes spinnerRotate {
    to { transform: rotate(360deg); }
}
</style>

<script>
(function() {
    var screen = document.getElementById('loading-screen');
    if (!screen) return;

    /* Sembunyikan loading screen setelah halaman selesai load */
    function hideLoader() {
        screen.classList.add('fade-out');
        setTimeout(function() {
            screen.classList.add('hidden');
        }, 400);
    }

    if (document.readyState === 'complete') {
        setTimeout(hideLoader, 300);
    } else {
        window.addEventListener('load', function() {
            setTimeout(hideLoader, 300);
        });
    }

    /* Tampilkan loading screen saat klik link navigasi */
    document.addEventListener('click', function(e) {
        var link = e.target.closest('a[href]');
        if (!link) return;

        var href = link.getAttribute('href');

        /* Skip: link eksternal, anchor (#), javascript:,
           tombol logout (punya form submit sendiri),
           link yang buka tab baru */
        if (!href ||
            href.startsWith('#') ||
            href.startsWith('javascript') ||
            href.startsWith('http') ||
            link.getAttribute('target') === '_blank' ||
            link.closest('form') ||
            link.classList.contains('no-loading')) {
            return;
        }

        /* Tampilkan loading screen */
        screen.classList.remove('hidden', 'fade-out');
        screen.style.opacity = '1';
        screen.style.pointerEvents = 'all';
    });
})();
</script>
