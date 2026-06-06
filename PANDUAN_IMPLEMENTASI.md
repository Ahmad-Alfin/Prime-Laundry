# 🚀 PANDUAN IMPLEMENTASI PRIME LAUNDRY
## Laravel + Supabase — Step by Step

---

## BAGIAN A — PERSIAPAN KOMPUTER (VSCode)

### A1. Install Software yang Dibutuhkan

**1. PHP 8.2+**
```bash
# Windows: Download dari https://windows.php.net/download/
# Atau pakai Laragon (direkomendasikan untuk Windows):
# https://laragon.org/download/

# macOS:
brew install php

# Ubuntu/Linux:
sudo apt install php8.2 php8.2-cli php8.2-pgsql php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip
```

**2. Composer**
```bash
# Download dari https://getcomposer.org/download/
# Verifikasi:
composer --version
```

**3. Node.js 18+ (untuk assets)**
```bash
# Download dari https://nodejs.org/
node --version   # harus 18+
npm --version
```

**4. Git**
```bash
# Download dari https://git-scm.com/
git --version
```

---

### A2. Setup Project Laravel Baru di VSCode

**Langkah 1 — Buat project Laravel baru:**
```bash
composer create-project laravel/laravel prime-laundry
cd prime-laundry
code .   # buka di VSCode
```

**Langkah 2 — Copy semua file yang sudah dibuat ke dalam project:**
```
Struktur yang perlu di-copy:
├── app/Http/Controllers/   → copy semua 6 file controller
├── app/Http/Middleware/     → copy AdminMiddleware.php
├── app/Models/              → copy User.php dan Order.php
├── config/                  → copy supabase.php & services.php
├── database/migrations/     → copy 2 file migration
├── resources/views/         → copy semua folder (layouts, components, pages)
├── routes/web.php           → replace isi file
├── public/css/app.css       → copy app.css
└── .env.example             → jadikan .env
```

**Langkah 3 — Install dependencies:**
```bash
composer require laravel/socialite guzzlehttp/guzzle
```

**Langkah 4 — Daftarkan Admin Middleware di bootstrap/app.php:**
```php
// Di dalam bootstrap/app.php, tambahkan:
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

**Langkah 5 — Setup file .env:**
```bash
cp .env.example .env
php artisan key:generate
```

---

## BAGIAN B — SETUP SUPABASE

### B1. Buat Akun & Project

1. Buka **https://supabase.com** → Sign Up (gratis)
2. Klik **"New Project"**
3. Isi:
   - **Name:** `prime-laundry`
   - **Database Password:** buat password kuat (simpan baik-baik!)
   - **Region:** Southeast Asia (Singapore)
4. Tunggu ~2 menit sampai project siap

---

### B2. Jalankan SQL Schema

1. Di dashboard Supabase → klik **"SQL Editor"** (ikon terminal di sidebar kiri)
2. Klik **"New Query"**
3. Copy-paste seluruh isi file `database/supabase_schema.sql`
4. Klik tombol **"Run"** (▶)
5. Pastikan muncul pesan **"Success. No rows returned"**

---

### B3. Ambil API Keys

1. Di dashboard Supabase → klik ikon **Settings** (⚙️) → **API**
2. Catat 3 hal penting:

```
Project URL:
  https://XXXXXXXXXXXXXXXX.supabase.co  ← ini SUPABASE_URL

Project API Keys:
  anon / public  → ini SUPABASE_KEY (untuk user biasa)
  service_role   → ini SUPABASE_SERVICE_KEY (untuk admin, JANGAN expose ke frontend!)
```

3. Buka juga **Settings → Database** → catat:
```
Host:      db.XXXXXXXXXXXXXXXX.supabase.co  ← DB_HOST
Port:      5432
Database:  postgres
Username:  postgres
Password:  [password yang dibuat tadi]
```

---

### B4. Isi File .env

Buka `.env` di VSCode, isi bagian-bagian ini:

```env
DB_CONNECTION=pgsql
DB_HOST=db.XXXXXXXXXXXXXXXX.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=password_supabase_anda

SUPABASE_URL=https://XXXXXXXXXXXXXXXX.supabase.co
SUPABASE_KEY=eyJ...anon_key...
SUPABASE_SERVICE_KEY=eyJ...service_role_key...
```

---

### B5. Jalankan Migrasi Laravel

```bash
php artisan migrate
```

> Ini akan membuat tabel di Supabase PostgreSQL Anda.
> Jika sudah menjalankan SQL manual tadi, bisa skip langkah ini.

---

## BAGIAN C — SETUP SOCIAL LOGIN

### C1. Google OAuth

1. Buka **https://console.cloud.google.com/**
2. Buat project baru → **"Prime Laundry"**
3. Kiri → **"APIs & Services"** → **"Credentials"**
4. Klik **"Create Credentials"** → **"OAuth Client ID"**
5. Application type: **Web Application**
6. Authorized redirect URIs: `http://localhost:8000/auth/google/callback`
7. Salin **Client ID** dan **Client Secret** ke `.env`:
```env
GOOGLE_CLIENT_ID=xxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxx
```

### C2. Facebook Login

1. Buka **https://developers.facebook.com/**
2. **My Apps** → **Create App** → pilih **"Consumer"**
3. Tambah produk **"Facebook Login"**
4. Settings → Basic → salin **App ID** dan **App Secret**
5. Facebook Login → Settings → Valid OAuth Redirect URIs:
   `http://localhost:8000/auth/facebook/callback`
```env
FACEBOOK_CLIENT_ID=xxxxx
FACEBOOK_CLIENT_SECRET=xxxxx
```

### C3. Twitter/X OAuth

1. Buka **https://developer.twitter.com/en/portal/dashboard**
2. Create new app → **"Prime Laundry"**
3. User authentication settings → OAuth 2.0
4. Callback URL: `http://localhost:8000/auth/twitter/callback`
```env
TWITTER_CLIENT_ID=xxxxx
TWITTER_CLIENT_SECRET=xxxxx
```

### C4. Apple Sign In

1. Buka **https://developer.apple.com/**
2. Daftar Apple Developer Program (bayar $99/tahun)
3. Certificates → Identifiers → Register App ID
4. Enable **"Sign In with Apple"**
5. Buat Service ID dan Private Key
```env
APPLE_CLIENT_ID=com.primelaundry.app
APPLE_CLIENT_SECRET=  # generate dari private key
```

> Catatan: Untuk development lokal, Google & Facebook sudah cukup.
> Apple Sign In hanya bisa ditest di domain HTTPS/production.

---

## BAGIAN D — SETUP QRIS PEMBAYARAN

### Opsi 1: QRIS Statis (Gratis, Manual Konfirmasi)

1. Daftar QRIS di bank/e-wallet Anda (BCA, Mandiri, GoPay Bisnis, dll)
2. Download file PNG QR Code dari aplikasi merchant
3. Taruh di: `public/images/qris-prime-laundry.png`
4. Admin konfirmasi manual via tombol "Konfirmasi Lunas" di dashboard

### Opsi 2: QRIS Dinamis via Midtrans (Direkomendasikan Produksi)

```bash
composer require midtrans/midtrans-php
```

Daftar di **https://midtrans.com** → ambil Server Key & Client Key:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_IS_PRODUCTION=false
```

---

## BAGIAN E — JALANKAN PROJECT

```bash
# Terminal 1: Laravel server
php artisan serve

# Buka browser: http://localhost:8000
```

---

## BAGIAN F — EKSTENSI VSCODE YANG DIREKOMENDASIKAN

Install ekstensi berikut di VSCode (`Ctrl+Shift+X`):

| Ekstensi | Kegunaan |
|---|---|
| **PHP Intelephense** | Autocomplete PHP |
| **Laravel Blade Snippets** | Syntax Blade |
| **Laravel Extra Intellisense** | Route & view hints |
| **Tailwind CSS IntelliSense** | (jika pakai Tailwind) |
| **GitLens** | Version control |
| **Thunder Client** | Test API langsung di VSCode |
| **DotENV** | Highlight file .env |

---

## BAGIAN G — CHECKLIST SEBELUM PRODUCTION

- [ ] Set `APP_ENV=production` dan `APP_DEBUG=false`
- [ ] Set `APP_URL` ke domain asli
- [ ] Ganti `DB_PASSWORD` dengan password kuat
- [ ] Upload QRIS PNG asli ke `public/images/`
- [ ] Update redirect URI di Google/Facebook ke domain production
- [ ] Aktifkan HTTPS (SSL)
- [ ] Jalankan `php artisan config:cache`
- [ ] Jalankan `php artisan route:cache`

---

## RINGKASAN STRUKTUR FILE FINAL

```
prime-laundry/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       ← Login, Register, Social Login
│   │   │   ├── PickupController.php     ← Order + Harga per item
│   │   │   ├── PaymentController.php    ← QRIS + Cek bayar
│   │   │   ├── StatusController.php     ← Cek status laundry
│   │   │   ├── KontakController.php     ← Form kontak
│   │   │   ├── MembershipController.php ← Daftar membership
│   │   │   └── AdminController.php      ← Dashboard admin
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       └── Order.php
├── config/
│   ├── supabase.php
│   └── services.php                     ← Social login config
├── database/
│   ├── migrations/                      ← Laravel migrations
│   └── supabase_schema.sql              ← SQL untuk Supabase
├── resources/views/
│   ├── layouts/app.blade.php            ← Layout utama
│   ├── components/
│   │   ├── navbar.blade.php
│   │   ├── footer.blade.php
│   │   └── splash.blade.php             ← Animasi loading
│   └── pages/
│       ├── beranda.blade.php            ← Home + Pickup Modal
│       ├── harga.blade.php              ← Daftar harga
│       ├── cek-status.blade.php         ← Cek status laundry
│       ├── syarat.blade.php             ← Syarat & Ketentuan
│       ├── kontak.blade.php             ← Form kontak
│       ├── login.blade.php              ← Login + Social icons
│       ├── register.blade.php           ← Register
│       ├── profile.blade.php            ← Profil user
│       ├── payment.blade.php            ← QRIS Payment
│       ├── payment-success.blade.php    ← Sukses bayar
│       └── admin/
│           └── dashboard.blade.php      ← Admin panel
├── routes/web.php                       ← Semua routing
├── public/
│   ├── css/app.css                      ← Semua styling
│   └── images/qris-prime-laundry.png   ← Upload QRIS Anda
└── .env                                 ← Konfigurasi (dari .env.example)
```
