# 🔐 PANDUAN SETUP SOCIAL LOGIN — Prime Laundry
## Google · Facebook · Twitter/X · Apple

---

## CARA KERJA (Singkat)

```
User klik "Login Google"
    → Browser buka halaman Google pilih akun
    → User pilih akun Google miliknya
    → Google kirim data (nama, email, foto) ke website kita
    → Website buat/update akun user secara otomatis
    → User langsung masuk ke beranda ✅
```

Proses ini disebut **OAuth 2.0** — user TIDAK perlu buat password baru.

---

## LANGKAH 0 — Install Socialite di Laravel

```bash
cd prime-laundry
composer require laravel/socialite
```

Kemudian daftarkan di `bootstrap/app.php`:
```php
// Tidak perlu tambah apa-apa, Socialite auto-load via composer
```

---

## ══════════════════════════════════════════════════
## PROVIDER 1 — GOOGLE LOGIN
## ══════════════════════════════════════════════════

### Langkah 1 — Buat Project Google Cloud

1. Buka **https://console.cloud.google.com/**
2. Login dengan akun Google Anda
3. Klik dropdown project (pojok kiri atas) → **"New Project"**
4. Isi:
   - Project name: `Prime Laundry`
   - Klik **"Create"**

### Langkah 2 — Aktifkan Google+ API

1. Kiri → **"APIs & Services"** → **"Library"**
2. Cari **"Google+ API"** → Klik → **"Enable"**
3. Cari juga **"Google People API"** → Klik → **"Enable"**

### Langkah 3 — Buat OAuth Credentials

1. Kiri → **"APIs & Services"** → **"Credentials"**
2. Klik **"+ Create Credentials"** → **"OAuth Client ID"**
3. Jika muncul "Configure consent screen" → klik itu dulu:
   - User Type: **External** → Create
   - App name: `Prime Laundry`
   - User support email: email Anda
   - Developer contact: email Anda
   - Klik **"Save and Continue"** (3x) → **"Back to Dashboard"**
4. Kembali buat credentials:
   - Application type: **Web application**
   - Name: `Prime Laundry Web`
   - Authorized redirect URIs → Klik **"+ Add URI"**:
     - Development: `http://localhost:8000/auth/google/callback`
     - Production (nanti): `https://domainanda.com/auth/google/callback`
5. Klik **"Create"**
6. Muncul popup → salin **Client ID** dan **Client Secret**

### Langkah 4 — Isi .env

```env
GOOGLE_CLIENT_ID=123456789-abcdefghij.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxxxxxxxxxxxxxxxxxxxxxx
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Langkah 5 — Test

```bash
php artisan serve
# Buka: http://localhost:8000/login
# Klik tombol "Google" → pilih akun Google Anda → langsung masuk!
```

---

## ══════════════════════════════════════════════════
## PROVIDER 2 — FACEBOOK LOGIN
## ══════════════════════════════════════════════════

### Langkah 1 — Buat App di Meta Developers

1. Buka **https://developers.facebook.com/**
2. Login dengan akun Facebook Anda
3. Klik **"My Apps"** → **"Create App"**
4. Pilih use case: **"Authenticate and request data from users with Facebook Login"**
5. Klik **Next**
6. Isi:
   - App name: `Prime Laundry`
   - App contact email: email Anda
7. Klik **"Create App"**

### Langkah 2 — Setup Facebook Login

1. Di dashboard app → Kiri: **"Add Product"**
2. Temukan **"Facebook Login"** → Klik **"Set Up"**
3. Pilih: **"Web"**
4. Site URL: `http://localhost:8000`
5. Klik **Save**

### Langkah 3 — Tambah Redirect URI

1. Kiri → **Facebook Login** → **Settings**
2. Valid OAuth Redirect URIs → tambahkan:
   ```
   http://localhost:8000/auth/facebook/callback
   ```
3. Klik **"Save Changes"**

### Langkah 4 — Ambil Credentials

1. Kiri atas → **Settings** → **Basic**
2. Salin **App ID** dan **App Secret** (klik "Show" untuk Secret)

### Langkah 5 — Isi .env

```env
FACEBOOK_CLIENT_ID=1234567890123456
FACEBOOK_CLIENT_SECRET=abcdef1234567890abcdef1234567890
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

> ⚠️ **Catatan:** Untuk testing, Anda harus tambahkan akun tester di:
> App Roles → Testers → Add Testers (masukkan email Facebook Anda)

---

## ══════════════════════════════════════════════════
## PROVIDER 3 — TWITTER / X LOGIN
## ══════════════════════════════════════════════════

### Langkah 1 — Daftar Twitter Developer

1. Buka **https://developer.twitter.com/en/portal/dashboard**
2. Login dengan akun Twitter/X Anda
3. Klik **"Sign up for Free Account"** (jika belum punya dev account)
4. Isi form — jelaskan penggunaan: "Login dengan Twitter untuk aplikasi laundry"
5. Setujui terms → Submit

### Langkah 2 — Buat App

1. Dashboard → **"Projects & Apps"** → **"+ Create App"**
2. Pilih environment: **Development**
3. App name: `PrimeLaundry`
4. Klik **"Next"** → salin **API Key** dan **API Secret** yang muncul
   (SIMPAN BAIK-BAIK, hanya muncul sekali!)

### Langkah 3 — Setup OAuth 2.0

1. Klik nama app Anda → **"Settings"**
2. **"User authentication settings"** → klik **"Set up"**
3. Isi:
   - OAuth 2.0: **ON**
   - App permissions: **Read**
   - Type of App: **Web App**
   - Callback URI: `http://localhost:8000/auth/twitter/callback`
   - Website URL: `http://localhost:8000`
4. Klik **"Save"**
5. Salin **Client ID** dan **Client Secret** yang muncul

### Langkah 4 — Isi .env

```env
TWITTER_CLIENT_ID=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWITTER_CLIENT_SECRET=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWITTER_REDIRECT_URI=http://localhost:8000/auth/twitter/callback
```

> ⚠️ **Catatan:** Twitter free tier tidak selalu membagikan email user.
> Aplikasi kita sudah menangani ini — jika tidak ada email,
> dibuat email placeholder otomatis.

---

## ══════════════════════════════════════════════════
## PROVIDER 4 — APPLE SIGN IN
## ══════════════════════════════════════════════════

> ⚠️ **Apple membutuhkan:**
> - Apple Developer Program ($99/tahun)
> - Domain HTTPS (tidak bisa di localhost)
> - Sertifikat SSL

### Langkah 1 — Daftar Apple Developer

1. Buka **https://developer.apple.com/**
2. Daftar Apple Developer Program ($99/tahun)
3. Tunggu approval (biasanya 1-2 hari)

### Langkah 2 — Register App ID

1. **Certificates, Identifiers & Profiles** → **Identifiers**
2. Klik **"+"** → pilih **"App IDs"** → Continue
3. Pilih type: **"App"** → Continue
4. Description: `Prime Laundry`
5. Bundle ID: `com.primelaundry.web` (bisa custom)
6. Scroll ke bawah → centang **"Sign In with Apple"**
7. Klik **"Continue"** → **"Register"**

### Langkah 3 — Buat Service ID

1. **Identifiers** → **"+"** → **"Service IDs"** → Continue
2. Description: `Prime Laundry Web`
3. Identifier: `com.primelaundry.web.service`
4. Register → Klik Service ID yang baru dibuat
5. Centang **"Sign In with Apple"** → **Configure**
6. Primary App ID: pilih yang tadi dibuat
7. Domains: `domainanda.com`
8. Return URLs: `https://domainanda.com/auth/apple/callback`
9. **Save** → **Continue** → **Register**

### Langkah 4 — Buat Private Key

1. **Keys** → **"+"**
2. Key name: `Prime Laundry Sign In Key`
3. Centang **"Sign In with Apple"** → Configure
4. Primary App ID: pilih app Anda → **Save**
5. **Continue** → **Register**
6. **Download** file .p8 (SEKALI SAJA, simpan baik-baik!)

### Langkah 5 — Generate Client Secret (JWT)

Install socialite apple driver:
```bash
composer require patrickbrouwers/laravel-socialite-apple
```

Isi .env:
```env
APPLE_CLIENT_ID=com.primelaundry.web.service
APPLE_CLIENT_SECRET=   # kosongkan dulu
APPLE_REDIRECT_URI=https://domainanda.com/auth/apple/callback
APPLE_KEY_ID=XXXXXXXXXX          # dari Key detail page
APPLE_TEAM_ID=XXXXXXXXXX         # dari Account → Membership
APPLE_PRIVATE_KEY_PATH=/path/to/AuthKey_XXXXXXXXXX.p8
```

> 💡 **Rekomendasi:** Aktifkan Apple Sign In terakhir, setelah Google & Facebook
> sudah berjalan. Apple lebih rumit dan butuh domain production.

---

## KONFIGURASI LENGKAP .env

```env
# Google
GOOGLE_CLIENT_ID=xxxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxx
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Facebook
FACEBOOK_CLIENT_ID=xxxxx
FACEBOOK_CLIENT_SECRET=xxxxx
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback

# Twitter/X
TWITTER_CLIENT_ID=xxxxx
TWITTER_CLIENT_SECRET=xxxxx
TWITTER_REDIRECT_URI=http://localhost:8000/auth/twitter/callback

# Apple (production only)
APPLE_CLIENT_ID=com.primelaundry.web.service
APPLE_CLIENT_SECRET=xxxxx
APPLE_REDIRECT_URI=https://domainanda.com/auth/apple/callback
```

---

## KONFIGURASI config/services.php

```php
<?php
return [
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],
    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT_URI'),
    ],
    'twitter-oauth-2' => [          // ← HARUS 'twitter-oauth-2' bukan 'twitter'
        'client_id'     => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect'      => env('TWITTER_REDIRECT_URI'),
    ],
    'apple' => [
        'client_id'     => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect'      => env('APPLE_REDIRECT_URI'),
    ],
];
```

---

## URUTAN IMPLEMENTASI YANG DISARANKAN

```
Minggu 1: ✅ Google Login   (paling mudah, paling banyak dipakai)
Minggu 1: ✅ Facebook Login (mudah, banyak user Indonesia)
Minggu 2: ✅ Twitter Login  (sedang, perlu verifikasi developer)
Bulan 2:  ✅ Apple Login    (perlu domain HTTPS & $99/tahun)
```

---

## TROUBLESHOOTING UMUM

| Error | Penyebab | Solusi |
|---|---|---|
| `redirect_uri_mismatch` | URI di console ≠ di .env | Samakan persis, termasuk http/https |
| `invalid_client` | Client ID/Secret salah | Salin ulang dari console |
| `InvalidStateException` | Session expired | Hapus cookies browser, coba lagi |
| Twitter tidak dapat email | Twitter tidak wajib beri email | Sudah ditangani otomatis di kode |
| Apple hanya bisa HTTPS | Apple butuh SSL | Test di production, bukan localhost |
