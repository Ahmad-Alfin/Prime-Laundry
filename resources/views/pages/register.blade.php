{{-- resources/views/pages/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Prime Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="auth-layout">
    <div class="auth-brand">
        {{-- Mengganti SVG dengan Image --}}
        <img src="{{ asset('images/Group 26.png') }}" alt="Prime Laundry Logo" style="width: 140px; height: auto; margin-bottom: 1rem;">
        <h2>Prime Laundry</h2>
        <p>Buat Akun Baru Anda</p>
    </div>

    <div class="auth-form-panel">
        <div class="auth-form-wrap">
            <h1 class="auth-title">Register</h1>
            <p class="auth-sub" style="color:#00AEEF">Daftar sekarang dan nikmati layanan premium</p>

            @if($errors->any())
                <div class="alert-error" style="display: flex; gap: 8px; background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #fca5a5;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <div>
                        @foreach($errors->all() as $err)<p style="margin: 0; font-size: 0.9rem;">{{ $err }}</p>@endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="input" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="input" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" class="input" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" style="margin-top:.5rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line>
                    </svg>
                    Daftar Sekarang
                </button>
            </form>

            <div class="divider"><span>atau daftar dengan</span></div>
            <div class="social-login-grid">
                <a href="{{ route('auth.social', 'google') }}"   class="social-login-btn social-google">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </a>
                <a href="{{ route('auth.social', 'facebook') }}" class="social-login-btn social-facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                    Facebook
                </a>
                <a href="{{ route('auth.social', 'twitter') }}"  class="social-login-btn social-twitter">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    Twitter / X
                </a>
                <a href="{{ route('auth.social', 'apple') }}"    class="social-login-btn social-apple">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                    Apple
                </a>
            </div>

            <p class="auth-footer-link" style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                Sudah punya akun? 
                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 700; text-decoration: none; color: #00AEEF;">
                    Login
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </p>
        </div>
    </div>
</div>
</body>
</html>