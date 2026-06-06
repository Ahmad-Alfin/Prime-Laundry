{{-- resources/views/components/splash.blade.php --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

<div id="splash-screen" class="splash-container">
    <div class="studio-light-sweep"></div>
    <div class="ambient-glow"></div>

    <div class="splash-content">
        <div class="logo-viewport-wrapper">
            
            <div class="inner-logo-canvas">
                {{-- Pastikan file logo-prime.png ada di folder public/images/ --}}
                <img src="{{ asset('images/Group 26.png') }}" alt="Prime Laundry Logo" class="droplet-image-logo">
            </div>

        </div>

        <h1 class="splash-title">Prime Laundry</h1>
        <p class="splash-subtitle">Perawatan Premium untuk Pakaian Anda</p>
    </div>
</div>

<style>
    /* ─── KONTANER UTAMA ─── */
    .splash-container {
        position: fixed;
        inset: 0;
        background: #00AEEF; /* Warna biru background */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        opacity: 1;
        transition: opacity 0.9s cubic-bezier(0.25, 1, 0.5, 1), transform 0.9s cubic-bezier(0.25, 1, 0.5, 1);
        animation: cameraPan 4s cubic-bezier(0.1, 0.8, 0.2, 1) forwards;
    }

    .splash-content {
        position: relative;
        z-index: 10;
        text-align: center;
        font-family: 'Inter', sans-serif;
    }

    /* ─── EFEK CAHAYA ─── */
    .studio-light-sweep {
        position: absolute;
        inset: -50%;
        background: linear-gradient(45deg, transparent 40%, rgba(255, 255, 255, 0.16) 50%, transparent 60%);
        transform: translateX(-100%) rotate(15deg);
        animation: lightSweep 2.8s cubic-bezier(0.3, 0.1, 0.2, 1) 0.5s forwards;
        pointer-events: none;
    }

    .ambient-glow {
        position: absolute;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(255,255,255,0.25) 0%, transparent 70%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.5);
        opacity: 0;
        animation: ambientFadeIn 2s ease-out 0.3s forwards;
        pointer-events: none;
    }

    /* ─── BUNGKUSAN LOGO ─── */
    .logo-viewport-wrapper {
        position: relative;
        width: 150px; /* Ukuran frame logo diperbesar sedikit agar proporsional */
        height: 150px;
        margin: 0 auto 1.5rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Animasi Kemunculan Gambar Logo */
    .inner-logo-canvas {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%; 
        height: 100%;
        transform: scale(0) rotate(-15deg);
        opacity: 0;
        animation: logoReveal 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards;
    }

    .droplet-image-logo {
        width: 100%;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.15));
    }

    /* ─── TYPOGRAPHY ─── */
    .splash-title {
        color: #ffffff;
        font-size: 2.8rem;
        font-weight: 900; 
        margin: 0;
        letter-spacing: -0.8px;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        opacity: 0;
        transform: translateY(20px);
        animation: textReveal 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.6s forwards;
    }

    .splash-subtitle {
        color: rgba(255, 255, 255, 0.88);
        font-size: 1.1rem;
        margin-top: 10px;
        margin-bottom: 0;
        font-weight: 700;
        letter-spacing: 0.2px;
        opacity: 0;
        transform: translateY(15px);
        animation: textReveal 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.9s forwards;
    }

    /* ─── ANIMASI ─── */
    @keyframes logoReveal {
        to { transform: scale(1) rotate(0deg); opacity: 1; }
    }

    @keyframes lightSweep {
        to { transform: translateX(100%) rotate(15deg); }
    }

    @keyframes ambientFadeIn {
        to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
    }

    @keyframes textReveal {
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes cameraPan {
        0% { transform: scale(1.06); }
        100% { transform: scale(1); }
    }
</style>

<script>
    (function() {
        const splash = document.getElementById('splash-screen');
        
        // Hapus tanda kutip pada baris bawah jika ingin animasi muncul 1x saja per sesi
        // if (sessionStorage.getItem('splashDone')) { if (splash) splash.remove(); return; }

        setTimeout(() => {
            if (splash) {
                splash.style.opacity = '0';
                splash.style.transform = 'scale(1.04)'; 
            }
        }, 3600);

        setTimeout(() => {
            if (splash) {
                splash.remove();
                // sessionStorage.setItem('splashDone', '1');
            }
        }, 4500);
    })();
</script>