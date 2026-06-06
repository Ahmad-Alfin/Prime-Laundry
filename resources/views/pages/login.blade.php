{{-- resources/views/pages/login.blade.php ── Optimized Version --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Prime Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="auth-layout">

    {{-- Panel Kiri: Branding --}}
    <div class="auth-brand">
        {{-- Logo SVG lama diganti menjadi Image --}}
        <img src="{{ asset('images/Group 26.png') }}" alt="Prime Laundry Logo" style="width: 140px; height: auto; margin-bottom: 1.5rem; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
        <h2>Prime Laundry</h2>
        <p>Perawatan Premium untuk Pakaian Anda</p>
    </div>

    {{-- Panel Kanan: Form Login --}}
    <div class="auth-form-panel">
        <div class="auth-form-wrap">
            <h1 class="auth-title">Login</h1>
            <p class="auth-sub" style="color:#00AEEF; font-weight: 700;">Masuk ke Akun Prime Laundry</p>

            {{-- Alert Error dengan SVG Icon --}}
            @if($errors->any())
                <div class="alert-error" style="display: flex; align-items: flex-start; gap: 10px; background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #fca5a5; box-shadow: 0 4px 12px rgba(153, 27, 27, 0.05);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        @foreach($errors->all() as $err)
                            <span style="font-size: 0.9rem; font-weight: 600;">{{ $err }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.5rem; color: #334155;">Email</label>
                    <input type="email" name="email" class="input" placeholder="email@contoh.com"
                           value="{{ old('email') }}" required autofocus style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem;">
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.5rem; color: #334155;">Password</label>
                    <div class="input-wrap" style="position: relative; display: flex; align-items: center;">
                        <input type="password" name="password" id="pwd-input" class="input" placeholder="••••••••" required style="width: 100%; padding: 12px 45px 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem;">
                        
                        {{-- Tombol Toggle Password menggunakan SVG Icon --}}
                        <button type="button" class="pwd-toggle" onclick="togglePwd()" style="position: absolute; right: 12px; background: transparent; border: none; cursor: pointer; color: #64748b; display: flex; align-items: center; justify-content: center; padding: 0; transition: color 0.2s;" onmouseover="this.style.color='#00AEEF'" onmouseout="this.style.color='#64748b'">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 0.5rem; padding: 14px; font-size: 1rem; border-radius: 8px; font-weight: 700; background: #00AEEF; color: #fff; border: none; cursor: pointer; width: 100%; box-shadow: 0 4px 12px rgba(0, 174, 239, 0.2); transition: all 0.2s;">
                    Login Sekarang
                </button>
            </form>

            <div class="divider"><span>atau masuk dengan</span></div>

            {{-- Social Login Buttons --}}
            <div class="social-login-grid">

                {{-- Google --}}
                <a href="{{ route('auth.social', 'google') }}" class="social-login-btn social-google">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </a>

                {{-- Facebook --}}
                <a href="{{ route('auth.social', 'facebook') }}" class="social-login-btn social-facebook">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#1877F2">
                        <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
                    </svg>
                    Facebook
                </a>

                {{-- Twitter / X --}}
                <a href="{{ route('auth.social', 'twitter') }}" class="social-login-btn social-twitter">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    Twitter / X
                </a>

                {{-- Apple --}}
                <a href="{{ route('auth.social', 'apple') }}" class="social-login-btn social-apple">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                    </svg>
                    Apple
                </a>

            </div>

            <p class="auth-footer-link" style="text-align: center; margin-top: 1.5rem; font-size: 0.95rem; color: #475569;">
                Belum punya akun?
                <a href="{{ route('register') }}" style="color: #00AEEF; font-weight: 700; text-decoration: none;">Daftar sekarang</a>
            </p>

            <p class="hint-text" style="text-align: center; margin-top: 2rem; font-size: 0.8rem; color: #94a3b8; background: #f8fafc; padding: 8px; border-radius: 6px;">
                Admin: admin@primelaundry.com / Admin@Prime2026
            </p>
        </div>
    </div>
</div>

<script>
// Fungsi toggle password dengan perubahan icon SVG
function togglePwd() {
    const inp = document.getElementById('pwd-input');
    const icon = document.getElementById('eye-icon');
    
    if (inp.type === 'password') {
        inp.type = 'text';
        // Ubah icon menjadi "Eye-Off" (Mata dicoret)
        icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path><line x1="2" x2="22" y1="2" y2="22"></line>';
        icon.style.color = '#00AEEF';
    } else {
        inp.type = 'password';
        // Kembalikan ke icon "Eye" biasa
        icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>';
        icon.style.color = 'currentColor';
    }
}
</script>
</body>
</html>