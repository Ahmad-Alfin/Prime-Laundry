{{-- resources/views/pages/profile.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Profil Saya — Prime Laundry')
@section('content')

<div class="hero-section" style="background: #00AEEF; padding: 2.5rem 1rem; text-align: center; margin-bottom: -2rem;">
    <h1 style="color: #fff; font-size: 1.75rem; font-weight: 900; margin: 0;">Profil Saya</h1>
</div>

<section class="section" style="max-width: 700px; margin: 3rem auto; padding: 0 1rem; font-family: 'Nunito', sans-serif;">

    {{-- Info Styling Tambahan Khusus Tampilan Keterangan & Kartu Membership --}}
    <style>
        /* Desain Kolom Mode Keterangan (Non-Aktif) */
        .info-value-text { font-size: 0.95rem; font-weight: 600; color: #1f2937; padding: 0.4rem 0; width: 100%; display: block; }
        .info-value-text.empty { color: #9ca3af; font-style: italic; font-weight: 400; }
        
        /* Input Form (Sembunyikan secara default, muncul saat edit) */
        .edit-mode-input { display: none; width: 100%; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.9rem; transition: all 0.2s; }
        .edit-mode-input:focus { border-color: #00AEEF; outline: none; box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.15); }
        
        /* Tombol Aksi */
        .btn-action-container { margin-top: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .btn-edit-trigger { display: inline-flex; align-items: center; gap: 6px; background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 0.9rem; }
        .btn-edit-trigger:hover { background: #e5e7eb; color: #1f2937; }
        .btn-save-submit { display: none; background: #00AEEF; color: #fff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.9rem; transition: 0.2s; }
        .btn-save-submit:hover { background: #008ecc; }
        .btn-cancel-trigger { display: none; background: transparent; color: #6b7280; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.9rem; transition: 0.2s; }
        .btn-cancel-trigger:hover { background: #f9fafb; color: #1f2937; }

        /* Styling Premium Membership Card */
        .membership-card { background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: #ffffff; border-radius: 16px; padding: 25px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); margin-top: 2rem; border: none; }
        .membership-card.silver { background: linear-gradient(135deg, #708090 0%, #3a4454 100%); }
        .membership-card.gold { background: linear-gradient(135deg, #d4af37 0%, #856404 100%); }
        .membership-card.platinum { background: linear-gradient(135deg, #1e40af 0%, #1e1b4b 100%); }
        .membership-card.expired { background: linear-gradient(135deg, #9ca3af 0%, #4b5563 100%); }

        .card-header-premium { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        .card-badge-premium { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #fff; }
        .card-status-active { background: #10b981; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;}
        .card-status-expired { background: #ef4444; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;}
        
        .card-body-premium h3 { margin: 0 0 8px 0; font-size: 22px; letter-spacing: 0.5px; color: #fff; font-weight: 900; }
        .card-body-premium p { margin: 0; color: #e5e7eb; font-size: 14px; line-height: 1.5; }
        .card-footer-premium { margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; display: flex; justify-content: space-between; font-size: 13px; color: #d1d5db; }
        .info-label-premium { display: block; font-size: 11px; text-transform: uppercase; color: #9ca3af; margin-bottom: 4px; font-weight: 700;}
        
        .no-membership { border: 2px dashed #d1d5db; border-radius: 12px; padding: 30px; text-align: center; background: #fff; margin-top: 2rem; }
        .btn-buy-premium { display: inline-block; background: #00AEEF; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; margin-top: 15px; transition: 0.2s; box-shadow: 0 4px 12px rgba(0, 174, 239, 0.2); }
        .btn-buy-premium:hover { background: #008ecc; text-decoration: none; color: #fff; transform: translateY(-1px); }
    </style>

    @if(session('success'))
        <div class="alert-success" style="display: flex; align-items: center; gap: 8px; background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Card Informasi Data Diri Pelanggan --}}
    <div class="card" style="background: #fff; border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); padding: 2rem; border: 1px solid #f1f5f9; margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
            <div class="avatar-lg" style="width: 64px; height: 64px; border-radius: 50%; background: #00AEEF; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; flex-shrink: 0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-weight: 900; font-size: 1.4rem; margin: 0 0 4px 0; color: #1e3a5f;">{{ auth()->user()->name }}</h2>
                <p style="color: #64748b; margin: 0; font-size: 0.95rem;">{{ auth()->user()->email }}</p>
                @if(auth()->user()->social_provider)
                    <p style="font-size: 0.8rem; color: #00AEEF; margin: 4px 0 0 0; font-weight: 700;">Login via {{ ucfirst(auth()->user()->social_provider) }}</p>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
            @csrf
            @foreach([
                ['label'=>'Nama Lengkap', 'field'=>'name',    'type'=>'text'],
                ['label'=>'Email',        'field'=>'email',   'type'=>'email'],
                ['label'=>'No. Telepon',  'field'=>'phone',   'type'=>'text'],
                ['label'=>'Alamat',       'field'=>'address', 'type'=>'text'],
                ['label'=>'Kota',         'field'=>'city',    'type'=>'text'],
                ['label'=>'Kode Pos',     'field'=>'zip',     'type'=>'text'],
            ] as $f)
            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                <span style="color: #64748b; width: 140px; font-size: 0.9rem; flex-shrink: 0; font-weight: 600;">{{ $f['label'] }}</span>
                
                <div style="flex: 1;">
                    {{-- 1. Mode Teks Keterangan (Hanya Baca, Muncul di Awal) --}}
                    @if(auth()->user()->{$f['field']})
                        <span class="info-view-mode info-value-text">{{ auth()->user()->{$f['field']} }}</span>
                    @else
                        <span class="info-view-mode info-value-text empty">Belum diisi</span>
                    @endif

                    {{-- 2. Mode Input (Tersembunyi, Muncul saat klik tombol Edit) --}}
                    <input type="{{ $f['type'] }}" name="{{ $f['field'] }}"
                           class="edit-mode-input"
                           value="{{ old($f['field'], auth()->user()->{$f['field']}) }}"
                           {{ $f['field']==='email' ? 'readonly style=background:#f8fafc;color:#94a3b8;cursor:not-allowed;' : '' }}>
                </div>
            </div>
            @endforeach
            
            {{-- Kontrol Navigasi Tombol --}}
            <div class="btn-action-container">
                <button type="button" class="btn-edit-trigger" id="btnEdit" onclick="enableEditMode()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                    Edit Profil
                </button>
                <button type="submit" class="btn-save-submit" id="btnSave">Simpan Perubahan</button>
                <button type="button" class="btn-cancel-trigger" id="btnCancel" onclick="disableEditMode()">Batal</button>
            </div>
        </form>
    </div>

    {{-- SEKSI OTOMATIS: KARTU PREMIUM MEMBERSHIP --}}
    @if($membership)
        @if($membership['is_active'])
            <div class="membership-card {{ strtolower($membership['membership']) }}">
                <div class="card-header-premium">
                    <span class="card-badge-premium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"></path>
                        </svg>
                        Prime Member
                    </span>
                    <span class="card-status-active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        Aktif
                    </span>
                </div>
                <div class="card-body-premium">
                    <h3>Paket {{ ucfirst($membership['membership']) }}</h3>
                    <p>Atas Nama: <strong style="color: #fff;">{{ $membership['nama'] }}</strong></p>
                </div>
                <div class="card-footer-premium">
                    <div>
                        <span class="info-label-premium">Masa Berlaku S/D</span>
                        <strong style="color: #fff;">{{ \Carbon\Carbon::parse($membership['expired_at'])->translatedFormat('d F Y') }}</strong>
                    </div>
                    <div style="text-align: right;">
                        <span class="info-label-premium">Sistem Perpanjangan</span>
                        <span style="display: inline-flex; align-items: center; gap: 4px; color: #fca5a5; font-weight: 700;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            Otomatis Berhenti
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="membership-card expired">
                <div class="card-header-premium">
                    <span class="card-badge-premium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Member Selesai
                    </span>
                    <span class="card-status-expired">Habis Masa Berlaku</span>
                </div>
                <div class="card-body-premium">
                    <h3>Paket {{ ucfirst($membership['membership']) }} (Berhenti)</h3>
                    <p>Langganan Anda telah dihentikan otomatis oleh sistem karena telah melewati batas masa tenggang 30 hari.</p>
                </div>
                <div class="card-footer-premium">
                    <div>
                        <span class="info-label-premium">Berakhir Pada</span>
                        <strong style="color: #fff;">{{ \Carbon\Carbon::parse($membership['expired_at'])->translatedFormat('d F Y') }}</strong>
                    </div>
                    <div style="text-align: right; display: flex; align-items: flex-end;">
                        <a href="/harga" style="color: #fff; text-decoration: none; font-weight: 700; border-bottom: 1px solid #fff; padding-bottom: 2px;">Beli Paket Baru</a>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="no-membership">
            <div style="margin-bottom: 1rem; color: #94a3b8; display: flex; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5Z"></path><path d="m2 17 10 5 10-5"></path><path d="m2 12 10 5 10-5"></path>
                </svg>
            </div>
            <p style="margin: 0; font-size: 1.1rem; color: #1e3a5f; font-weight: 800;">Anda belum bergabung menjadi Prime Member.</p>
            <p style="margin: 8px 0 15px 0; font-size: 0.95rem; color: #64748b; line-height: 1.5;">Nikmati diskon eksklusif pengerjaan kilat dan hemat biaya laundry bulanan Anda!</p>
            <a href="/harga" class="btn-buy-premium">Lihat Paket Membership</a>
        </div>
    @endif

</section>

{{-- JAVASCRIPT INTERAKTIF PERPINDAHAN MODE EDIT PROFIL --}}
<script>
    function enableEditMode() {
        // Sembunyikan teks keterangan statis
        document.querySelectorAll('.info-view-mode').forEach(el => el.style.display = 'none');
        
        // Munculkan kolom input pengisian data
        document.querySelectorAll('.edit-mode-input').forEach(el => el.style.display = 'block');
        
        // Tukar visibilitas tombol kontrol
        document.getElementById('btnEdit').style.display = 'none';
        document.getElementById('btnSave').style.display = 'block';
        document.getElementById('btnCancel').style.display = 'block';
        
        // Fokuskan pada input pertama
        const firstInput = document.querySelector('.edit-mode-input:not([readonly])');
        if(firstInput) firstInput.focus();
    }

    function disableEditMode() {
        // Munculkan kembali teks keterangan statis
        document.querySelectorAll('.info-view-mode').forEach(el => el.style.display = 'block');
        
        // Sembunyikan kolom input pengisian data
        document.querySelectorAll('.edit-mode-input').forEach(el => el.style.display = 'none');
        
        // Kembalikan posisi tombol utama
        document.getElementById('btnEdit').style.display = 'inline-flex';
        document.getElementById('btnSave').style.display = 'none';
        document.getElementById('btnCancel').style.display = 'none';
    }
</script>

@endsection