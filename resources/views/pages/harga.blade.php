{{-- resources/views/pages/harga.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Daftar Harga & Paket Membership — Prime Laundry')
@section('content')

<div class="hero-section" style="background: linear-gradient(135deg, #00AEEF 0%, #1e3a5f 100%); padding: 3rem 2rem; text-align: center; margin-bottom: 2rem; border-radius: 0 0 24px 24px;">
    <h1 style="color:#fff; font-size:2.2rem; font-weight:900; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.15);">Daftar Harga Layanan</h1>
    <p style="color: rgba(255,255,255,0.85); margin-top: 0.5rem; font-size: 1rem;">Layanan cuci premium terbaik dengan harga terjangkau dan transparan</p>
</div>

{{-- Penangkap Notifikasi Sukses Pendaftaran Membership --}}
@if(session('membership_success'))
    {{-- Rubah emoji menjadi icon SVG selaras dengan display:flex --}}
    <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin: 1rem 2rem; font-weight: bold; border: 1px solid #a7f3d0; box-shadow: 0 4px 12px rgba(34,197,94,0.1); display: flex; align-items: center; justify-content: center; gap: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><polyline points="20 6 9 17 4 12"></polyline></svg>
        <span>{{ session('membership_success') }}</span>
    </div>
@endif

@if(session('error'))
    {{-- Rubah emoji menjadi icon SVG selaras dengan display:flex --}}
    <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin: 1rem 2rem; font-weight: bold; border: 1px solid #fca5a5; display: flex; align-items: center; justify-content: center; gap: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

<section class="section" style="padding: 0 1.5rem 3rem 1.5rem; max-width: 1200px; margin: 0 auto;">
    
    {{-- Paket Membership --}}
    <h2 class="section-title" style="text-align: center; color: #1e3a5f; font-weight: 800; font-size: 1.8rem; margin-bottom: 0.5rem;">Paket Membership</h2>
    <p style="text-align:center; color:#6b7280; margin-bottom:2.5rem; font-size: 0.95rem;">Daftar membership sekarang dan nikmati hemat hingga Rp 100.000 setiap bulannya!</p>
    
    <div class="membership-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
        @foreach([
            ['key'=>'silver',   'name'=>'Paket Silver',   'price'=>'300.000', 'bg'=>'#9ca3af', 'text'=>'#1f2937'],
            ['key'=>'gold',     'name'=>'Paket Gold',     'price'=>'500.000', 'bg'=>'#f59e0b', 'text'=>'#78350f'],
            ['key'=>'platinum', 'name'=>'Paket Platinum', 'price'=>'900.000', 'bg'=>'#1e3a5f', 'text'=>'#ffffff'],
        ] as $pkg)
        <div class="membership-card" style="background:{{ $pkg['bg'] }}; padding: 2.5rem 1.5rem; border-radius: 16px; text-align: center; color: {{ $pkg['text'] }}; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
            <h3 style="color:{{ $pkg['text'] }}; font-weight:800; font-size: 1.4rem; margin-top: 0; text-transform: uppercase; letter-spacing: 0.5px;">{{ $pkg['name'] }}</h3>
            <div style="color:{{ $pkg['text'] }}; margin:1.5rem 0">
                <span style="font-size:1rem; font-weight: 600;">Rp</span>
                <span style="font-size:2.5rem; font-weight:900; line-height: 1;">{{ $pkg['price'] }}</span>
                <span style="font-size:0.9rem; opacity: 0.85;">/bulan</span>
            </div>
            
            <button class="btn btn-block" onclick="openMemberModal('{{ $pkg['key'] }}', '{{ $pkg['name'] }}')" 
                    style="background: #fff; color: #1e3a5f; font-weight: bold; border: none; padding: 0.8rem 1.5rem; width: 100%; border-radius: 8px; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-size: 0.95rem; transition: all 0.2s;">
                Pilih Paket
            </button>
        </div>
        @endforeach
    </div>

    {{-- Tabel Harga Layanan Laundry --}}
    @php
        $tables = [
            ['title'=>'Daily Kiloan (Layanan Rumahan Ekonomis)', 'hasQuick'=>true, 'data'=>[
                ['item'=>'Cuci Kering Lipat (Min. 3 Kg)','reg'=>'Rp5.000','one'=>'Rp8.000','exp'=>'Rp10.000','quick'=>'Rp15.000'],
                ['item'=>'Cuci Kering Gosok (Min. 3 Kg)','reg'=>'Rp8.000','one'=>'Rp12.000','exp'=>'Rp16.000','quick'=>'Rp25.000'],
                ['item'=>'Setrika Kiloan (Min. 3 Kg)',   'reg'=>'Rp5.000','one'=>'Rp10.000','exp'=>'Rp12.000','quick'=>'Rp15.000'],
            ]],
            ['title'=>'Premium Satuan (Pakaian & Jas Jas Eksklusif)', 'hasQuick'=>false, 'data'=>[
                ['item'=>'Kemeja / Blouse / Batik',    'reg'=>'Rp15.000','one'=>'Rp25.000','exp'=>'Rp30.000'],
                ['item'=>'Celana / Rok / Shorts',      'reg'=>'Rp20.000','one'=>'Rp30.000','exp'=>'Rp40.000'],
                ['item'=>'Mukena / Sarung / Sajadah',  'reg'=>'Rp10.000','one'=>'Rp15.000','exp'=>'Rp20.000'],
                ['item'=>'Jaket / Blazer / Jas',       'reg'=>'Rp30.000','one'=>'Rp45.000','exp'=>'Rp60.000'],
                ['item'=>'Jaket Jeans / Hoodie',       'reg'=>'Rp30.000','one'=>'Rp45.000','exp'=>'Rp60.000'],
                ['item'=>'Dress / Gamis / Long Dress', 'reg'=>'Rp30.000','one'=>'Rp45.000','exp'=>'Rp65.000'],
                ['item'=>'Gown / Gaun Pesta',          'reg'=>'Rp70.000','one'=>'—','exp'=>'—'],
                ['item'=>'Coat / Matel / Jaket Tebal', 'reg'=>'Rp80.000','one'=>'—','exp'=>'—'],
            ]],
            ['title'=>'Spesialis Sepatu & Tas', 'hasQuick'=>false, 'data'=>[
                ['item'=>'Nylon, Canvas & Rubber',  'reg'=>'Rp40.000','one'=>'Rp60.000','exp'=>'Rp75.000'],
                ['item'=>'Suede & Leather',         'reg'=>'Rp50.000','one'=>'Rp70.000','exp'=>'Rp80.000'],
                ['item'=>'Tas Non Leather (Kecil)', 'reg'=>'Rp50.000','one'=>'Rp75.000','exp'=>'Rp100.000'],
                ['item'=>'Tas Non Leather (Besar)', 'reg'=>'Rp70.000','one'=>'Rp105.000','exp'=>'Rp140.000'],
            ]],
            ['title'=>'Bed Cover & Linen Rumah Tangga', 'hasQuick'=>false, 'data'=>[
                ['item'=>'Bed Cover Single',         'reg'=>'Rp25.000','one'=>'Rp40.000','exp'=>'Rp50.000'],
                ['item'=>'Bed Cover Double',         'reg'=>'Rp40.000','one'=>'Rp60.000','exp'=>'Rp80.000'],
                ['item'=>'Sarung Bantal / Guling',   'reg'=>'Rp5.000', 'one'=>'Rp7.000', 'exp'=>'Rp10.000'],
                ['item'=>'Bantal / Guling',          'reg'=>'Rp30.000','one'=>'Rp45.000','exp'=>'Rp60.000'],
                ['item'=>'Selimut',                  'reg'=>'Rp20.000','one'=>'Rp30.000','exp'=>'Rp40.000'],
                ['item'=>'Sprei',                    'reg'=>'Rp15.000','one'=>'Rp25.000','exp'=>'Rp30.000'],
            ]],
        ];
    @endphp

    @foreach($tables as $tbl)
    <div style="margin-bottom: 3rem; background: #fff; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
        <h3 style="color:#00AEEF; font-size:1.25rem; font-weight:800; margin-top:0; margin-bottom:1.2rem; border-left: 4px solid #00AEEF; padding-left: 0.6rem;">
            {{ $tbl['title'] }}
        </h3>
        <div class="table-wrap" style="overflow-x: auto;">
            <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 0.8rem; color: #334155; font-weight: 700;">Nama Item / Layanan</th>
                        <th style="padding: 0.8rem; color: #334155; font-weight: 700;">Reguler (3 Hari)</th>
                        <th style="padding: 0.8rem; color: #334155; font-weight: 700;">One Day (24 Jam)</th>
                        <th style="padding: 0.8rem; color: #334155; font-weight: 700;">Express (12 Jam)</th>
                        @if($tbl['hasQuick'])
                            <th style="padding: 0.8rem; color: #334155; font-weight: 700;">Quick (3 Jam)</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($tbl['data'] as $i => $row)
                    <tr style="border-bottom: 1px solid #f1f5f9; background: {{ $i % 2 ? '#f8fafc' : '#ffffff' }};">
                        <td style="padding: 0.9rem 0.8rem; font-weight:600; color: #1e293b;">{{ $row['item'] }}</td>
                        <td style="padding: 0.9rem 0.8rem; color: #475569;">{{ $row['reg'] }}</td>
                        <td style="padding: 0.9rem 0.8rem; color: #475569;">{{ $row['one'] }}</td>
                        <td style="padding: 0.9rem 0.8rem; color: #475569;">{{ $row['exp'] }}</td>
                        @if($tbl['hasQuick'])
                            <td style="padding: 0.9rem 0.8rem; color: #00AEEF; font-weight: 700;">{{ $row['quick'] ?? '—' }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</section>

{{-- ─── MODAL POP-UP REGISTER MEMBERSHIP ─── --}}
<div id="memberModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center; backdrop-filter: blur(3px);">
    <div style="background-color: #fff; padding: 2.2rem; border-radius: 16px; width: 90%; max-width: 460px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); position: relative; animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <span onclick="closeMemberModal()" style="position: absolute; right: 1.5rem; top: 1.2rem; font-size: 1.8rem; cursor: pointer; color: #9ca3af; font-weight: 300; transition: color 0.2s;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#9ca3af'">&times;</span>
        
        <h3 style="margin-top: 0; color: #1e3a5f; font-weight: 800; font-size: 1.5rem; margin-bottom: 0.3rem;">Pendaftaran Membership</h3>
        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1.8rem;">Kamu memilih paket: <strong id="selectedPackageText" style="color: #00AEEF; text-transform: uppercase; letter-spacing: 0.5px;">-</strong></p>
        
        <form action="{{ route('membership.store') }}" method="POST">
            @csrf
            
            {{-- Input Hidden Kunci Paket --}}
            <input type="hidden" name="membership" id="packageKeyInput">
            
            <div style="margin-bottom: 1.2rem;">
                <label style="display:block; font-size:.85rem; font-weight:700; margin-bottom:.4rem; color:#374151">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ auth()->check() ? auth()->user()->name : '' }}" required 
                       style="width:100%; padding:.7rem; border:1px solid #cbd5e1; border-radius:8px; font-size: 0.95rem; box-sizing: border-box;" placeholder="Masukkan nama lengkap Anda">
            </div>
            
            <div style="margin-bottom: 1.4rem;">
                <label style="display:block; font-size:.85rem; font-weight:700; margin-bottom:.4rem; color:#374151">Nomor WhatsApp Aktif</label>
                <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx" required 
                       style="width:100%; padding:.7rem; border:1px solid #cbd5e1; border-radius:8px; font-size: 0.95rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.6rem;">
                <input type="checkbox" name="agree" id="agreeCheckbox" value="1" required checked style="margin-top: 0.2rem; cursor: pointer;">
                <label for="agreeCheckbox" style="font-size: 0.8rem; color: #4b5563; cursor: pointer; user-select: none; line-height: 1.3;">Saya menyatakan setuju dengan seluruh aturan, syarat, dan ketentuan premium member Prime Laundry.</label>
            </div>
            
            <button type="submit" style="background:#00AEEF; color:#fff; font-weight:700; padding:.8rem; width:100%; border:none; border-radius:8px; cursor:pointer; font-size: 1rem; box-shadow: 0 4px 10px rgba(0, 174, 239, 0.25); transition: background 0.2s;">
                Konfirmasi & Bayar via QRIS
            </button>
        </form>
    </div>
</div>

<style>
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .membership-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@push('scripts')
<script>
    function openMemberModal(packageKey, packageName) {
        console.log("Membuka modal pendaftaran: " + packageKey);
        
        const packageText = document.getElementById('selectedPackageText');
        if (packageText) {
            packageText.innerText = packageName;
        }

        const packageInput = document.getElementById('packageKeyInput');
        if (packageInput) {
            packageInput.value = packageKey;
        }
        
        const modal = document.getElementById('memberModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closeMemberModal() {
        const modal = document.getElementById('memberModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Klik di area luar modal otomatis menutup modal pendaftaran
    window.onclick = function(event) {
        const modal = document.getElementById('memberModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endpush