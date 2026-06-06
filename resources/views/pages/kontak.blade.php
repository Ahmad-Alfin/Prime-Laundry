{{-- resources/views/pages/kontak.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Kontak — Prime Laundry')
@section('content')

<div class="hero-section" style="background: linear-gradient(135deg, #00AEEF 0%, #1e3a5f 100%); padding: 4rem 2rem; text-align: center; border-radius: 0 0 24px 24px;">
    <h1 style="color:#fff; font-size: 2.2rem; font-weight: 900; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.15);">Kontak Prime Laundry</h1>
    <p style="color: rgba(255,255,255,0.85); margin-top: 0.5rem; font-size: 1rem;">Hubungi kami kapan saja, tim kami siap melayani dan membantu kebutuhan Anda</p>
</div>

<section class="section" style="padding: 3rem 1.5rem; max-width: 1200px; margin: 0 auto;">
    
    {{-- Grid Info Kontak Informasi dengan Custom SVG --}}
    <div class="kontak-info-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3.5rem;">
        
        {{-- Card Telepon --}}
        <div class="card text-center" style="background: #fff; padding: 2rem 1.5rem; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; display: flex; flex-direction: column; align-items: center;">
            <div style="background: rgba(0, 174, 239, 0.1); color: #00AEEF; padding: 12px; border-radius: 50%; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
            <h3 style="color: #1e3a5f; font-weight: 800; font-size: 1.2rem; margin-top: 0; margin-bottom: 0.75rem;">Telepon & WhatsApp</h3>
            <p style="color: #475569; font-weight: 600; margin: 4px 0; font-size: 0.95rem;">0895621112467</p>
            <p style="color: #475569; font-weight: 600; margin: 4px 0; font-size: 0.95rem;">085895440744</p>
        </div>

        {{-- Card Email --}}
        <div class="card text-center" style="background: #fff; padding: 2rem 1.5rem; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; display: flex; flex-direction: column; align-items: center;">
            <div style="background: rgba(0, 174, 239, 0.1); color: #00AEEF; padding: 12px; border-radius: 50%; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
            </div>
            <h3 style="color: #1e3a5f; font-weight: 800; font-size: 1.2rem; margin-top: 0; margin-bottom: 0.75rem;">Email Resmi</h3>
            <p style="color: #475569; font-weight: 600; margin: 4px 0; font-size: 0.95rem;">PrimeLaundry@gmail.com</p>
        </div>

        {{-- Card Alamat --}}
        <div class="card text-center" style="background: #fff; padding: 2rem 1.5rem; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; display: flex; flex-direction: column; align-items: center;">
            <div style="background: rgba(0, 174, 239, 0.1); color: #00AEEF; padding: 12px; border-radius: 50%; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <h3 style="color: #1e3a5f; font-weight: 800; font-size: 1.2rem; margin-top: 0; margin-bottom: 0.75rem;">Alamat Workshop</h3>
            <p style="color: #475569; font-weight: 500; margin: 4px 0; font-size: 0.9rem; line-height: 1.5; text-align: center;">
                Jl Margo Basuki Gg 1<br>Jetis, Mulyoagung,<br>Kec. Dau, Kab. Malang
            </p>
        </div>
    </div>

    {{-- Alert Notifikasi Sukses --}}
    @if(session('sent'))
        <div class="alert-success" style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 2.5rem; font-weight: bold; text-align: center; border: 1px solid #a7f3d0; box-shadow: 0 4px 12px rgba(34,197,94,0.08); display: flex; align-items: center; justify-content: center; gap: 8px; max-width: 600px; margin-left: auto; margin-right: auto;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Pesan berhasil dikirim! Tim kami akan menghubungi Anda segera.</span>
        </div>
    @endif

    {{-- Form Hubungi Kami --}}
    <form method="POST" action="{{ route('kontak.send') }}" style="max-width: 600px; margin: 0 auto; background: #fff; padding: 2.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
        @csrf
        <h3 style="margin-top: 0; color: #1e3a5f; font-weight: 800; font-size: 1.4rem; margin-bottom: 1.5rem; text-align: center;">Kirim Pesan Langsung</h3>
        
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.5rem; color: #334155;">Nama Lengkap</label>
            <input type="text" name="nama" class="input" placeholder="Nama Anda" value="{{ old('nama') }}" required style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem;">
        </div>
        
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.5rem; color: #334155;">Alamat Email</label>
            <input type="email" name="email" class="input" placeholder="email@contoh.com" value="{{ old('email') }}" required style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem;">
        </div>
        
        <div class="form-group" style="margin-bottom: 1.75rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.5rem; color: #334155;">Isi Pesan</label>
            <textarea name="pesan" class="input" rows="5" placeholder="Tulis pesan atau pertanyaan Anda di sini..." required style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 0.95rem; font-family: inherit; resize: vertical;">{{ old('pesan') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block" style="padding: 14px; font-size: 1rem; border-radius: 8px; font-weight: 700; background: #00AEEF; color: #fff; border: none; cursor: pointer; width: 100%; box-shadow: 0 4px 12px rgba(0, 174, 239, 0.2); transition: all 0.2s;">
            Kirim Pesan Ke Tim Kami
        </button>
    </form>
</section>

@endsection