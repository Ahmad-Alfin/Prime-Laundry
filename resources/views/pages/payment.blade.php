{{-- resources/views/pages/payment.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Pembayaran QRIS — Prime Laundry')

@section('content')
<section class="section" style="max-width: 600px; margin: 0 auto; padding: 2rem 1rem;">

    <div class="payment-card" style="background: #fff; border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); padding: 2rem; border: 1px solid #f1f5f9;">
        
        {{-- Header --}}
        <div class="payment-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <h2 style="display: flex; align-items: center; gap: 10px; color: #1e3a5f; font-weight: 800; font-size: 1.5rem; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                Pembayaran QRIS
            </h2>
            <span class="order-code" style="background: #f1f5f9; padding: 6px 14px; border-radius: 8px; font-weight: 700; color: #475569; letter-spacing: 0.5px;">{{ $order['code'] }}</span>
        </div>

        {{-- Status Badge --}}
        <div id="payment-status-banner" class="status-banner status-unpaid" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: #fef9c3; color: #a16207; padding: 12px; border-radius: 10px; font-weight: 700; margin-bottom: 2rem; border: 1px solid #fef08a;">
            <span id="status-icon" style="display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 15 15"></polyline>
                </svg>
            </span>
            <span id="status-text">Menunggu Pembayaran</span>
        </div>

        {{-- Ringkasan Order --}}
        <div class="payment-summary" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
            <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: #64748b;">Layanan</span>
                <strong style="color: #334155;">{{ $order['service'] }}</strong>
            </div>
            <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: #64748b;">Customer</span>
                <strong style="color: #334155;">{{ $order['customer'] }}</strong>
            </div>
            <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: #64748b;">Pickup</span>
                <strong style="color: #334155;">{{ $order['pickup_date'] }} pukul {{ $order['pickup_time'] }}</strong>
            </div>
            @php
                $items = is_string($order['items']) ? json_decode($order['items'], true) : $order['items'];
            @endphp
            @if($items)
                <div class="summary-items" style="margin-top: 1rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;">
                    @foreach($items as $item)
                    <div class="summary-row item-row" style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem; color: #475569;">
                        <span>{{ $item['item'] }} × {{ $item['qty'] }}</span>
                        <span style="font-weight: 600;">Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            @endif
            <hr style="border: 0; border-top: 1px dashed #cbd5e1; margin: 1rem 0;">
            <div class="summary-total" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #334155; font-weight: 700;">Total Pembayaran</span>
                <strong class="total-amount" style="color: #00AEEF; font-size: 1.25rem; font-weight: 900;">Rp{{ number_format($order['total'], 0, ',', '.') }}</strong>
            </div>
        </div>

        {{-- QRIS Code --}}
        <div class="qris-section" style="text-align: center; margin-bottom: 2.5rem;">
            <p class="qris-label" style="font-size: 0.95rem; color: #475569; margin-bottom: 1rem;">Scan QR Code di bawah menggunakan aplikasi e-wallet / m-banking:</p>
            <div class="qris-wrapper" style="display: inline-block; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 16px; background: #fff; margin-bottom: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <img src="{{ $qrisImageUrl }}" alt="QRIS Prime Laundry" class="qris-image" id="qris-img" style="width: 250px; height: 250px; display: block; margin: 0 auto; object-fit: contain;">
                
                {{-- Fallback jika gambar QRIS belum ada --}}
                <div class="qris-placeholder" id="qris-placeholder" style="width: 250px; height: 250px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; border-radius: 12px; display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 10px;">
                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line>
                    </svg>
                    <p style="font-weight: 700; color: #94a3b8; margin: 0;">QRIS Belum Tersedia</p>
                    <p style="font-size: 0.75rem; color: #cbd5e1; margin-top: 0.5rem; text-align: center; padding: 0 10px;">
                        Pastikan file:<br><code>public/images/qris-prime-laundry.png</code><br>sudah diupload.
                    </p>
                </div>
            </div>

            <div class="qris-apps">
                <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 0.8rem;">Bisa dibayar via:</p>
                <div class="app-badges" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 6px;">
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">GoPay</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">OVO</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">Dana</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">ShopeePay</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">BCA Mobile</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">Mandiri</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">BRI</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">BNI</span>
                    <span class="app-badge" style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; color: #475569;">& semua e-wallet</span>
                </div>
            </div>
        </div>

        {{-- Timer & Instruksi --}}
        <div class="payment-instructions" style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
            <p style="display: flex; align-items: center; gap: 8px; color: #166534; font-weight: 700; margin-bottom: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="13" r="8"></circle><polyline points="12 9 12 13 14 15"></polyline><line x1="12" y1="2" x2="12" y2="5"></line>
                </svg>
                Selesaikan pembayaran dalam: <strong id="countdown" style="color: #15803d; font-size: 1.1rem; margin-left: 4px;">15:00</strong>
            </p>
            <ol class="instruction-list" style="margin: 0; padding-left: 1.25rem; color: #166534; font-size: 0.9rem; line-height: 1.6;">
                <li>Buka aplikasi e-wallet atau m-banking Anda</li>
                <li>Pilih menu Scan QR / QRIS</li>
                <li>Arahkan kamera ke kode QR di atas</li>
                <li>Pastikan nominal <strong>Rp{{ number_format($order['total'], 0, ',', '.') }}</strong> sudah benar</li>
                <li>Konfirmasi & selesaikan pembayaran</li>
                <li>Halaman ini akan otomatis terupdate saat pembayaran diterima</li>
            </ol>
        </div>

        {{-- Tombol Cek Manual --}}
        <button id="check-btn" class="btn btn-primary btn-block" onclick="checkPayment()" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; background: #00AEEF; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0, 174, 239, 0.2); margin-bottom: 1.5rem;">
            <svg id="check-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
            </svg>
            <span id="check-text">Cek Status Pembayaran</span>
        </button>

        <p class="payment-note" style="display: flex; align-items: flex-start; gap: 10px; background: #fffbeb; border: 1px solid #fde68a; padding: 1rem; border-radius: 10px; font-size: 0.85rem; color: #92400e; margin: 0; line-height: 1.5;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            <span><strong>Penting:</strong> Jangan tutup halaman ini sebelum pembayaran terkonfirmasi. Admin akan memverifikasi pembayaran Anda. Pesanan akan mulai diproses setelah konfirmasi.</span>
        </p>
    </div>

</section>
@endsection

@push('scripts')
<script>
const ORDER_ID  = {{ $order['id'] }};
const CHECK_URL = "{{ route('payment.check', $order['id']) }}";
const SUCCESS_URL = "{{ route('payment.success', $order['id']) }}";
const CSRF_TOKEN = document.querySelector('meta[name=csrf-token]').getAttribute('content');

// Definisi Icon SVG untuk Javascript
const svgWaiting = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 15 15"></polyline></svg>`;
const svgSuccess = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`;
const svgError   = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`;

// ─── Cek gambar QRIS (sembunyikan placeholder jika gambar ada) ───────────
const qrisImg = document.getElementById('qris-img');
const qrisPlaceholder = document.getElementById('qris-placeholder');
qrisImg.onload  = () => { qrisImg.style.display='block'; qrisPlaceholder.style.display='none'; };
qrisImg.onerror = () => { qrisImg.style.display='none';  qrisPlaceholder.style.display='flex'; };

// ─── Countdown Timer 15 menit ────────────────────────────────────────────
let seconds = 15 * 60;
const countdownEl = document.getElementById('countdown');
const timerInterval = setInterval(() => {
    seconds--;
    if (seconds <= 0) {
        clearInterval(timerInterval);
        countdownEl.textContent = 'KADALUWARSA';
        countdownEl.style.color = '#ef4444';
        
        const btn = document.getElementById('check-btn');
        btn.disabled = true;
        btn.style.background = '#94a3b8';
        btn.style.boxShadow = 'none';
        
        setBanner('expired', svgError, 'Waktu pembayaran habis', '#fef2f2', '#b91c1c', '#fca5a5');
        return;
    }
    const m = String(Math.floor(seconds/60)).padStart(2,'0');
    const s = String(seconds % 60).padStart(2,'0');
    countdownEl.textContent = `${m}:${s}`;
    if (seconds < 60) countdownEl.style.color = '#ef4444';
}, 1000);

// ─── Auto polling setiap 10 detik ────────────────────────────────────────
const pollInterval = setInterval(checkPayment, 10000);

async function checkPayment() {
    const btn = document.getElementById('check-btn');
    const btnText = document.getElementById('check-text');
    const btnIcon = document.getElementById('check-icon');
    
    btnText.textContent = 'Mengecek...';
    btnIcon.innerHTML = `<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 15 15"></polyline>`;
    btn.disabled = true;

    try {
        const res = await fetch(CHECK_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
            },
        });
        const data = await res.json();

        if (data.status === 'paid') {
            clearInterval(pollInterval);
            clearInterval(timerInterval);
            
            setBanner('paid', svgSuccess, `Pembayaran Berhasil! Diterima: ${data.paid_at?.slice(0,16).replace('T',' ') || ''}`, '#dcfce7', '#15803d', '#86efac');
            
            btnText.textContent = 'Dibayar!';
            btnIcon.innerHTML = `<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>`;
            btn.style.background = '#10b981';
            btn.style.boxShadow = '0 4px 12px rgba(16, 185, 129, 0.3)';
            
            setTimeout(() => { window.location.href = SUCCESS_URL; }, 2000);

        } else if (data.status === 'expired') {
            clearInterval(pollInterval);
            setBanner('expired', svgError, 'Pembayaran kadaluwarsa', '#fef2f2', '#b91c1c', '#fca5a5');
            
            btnText.textContent = 'Kadaluwarsa';
            btnIcon.innerHTML = `<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>`;
            btn.style.background = '#94a3b8';
            btn.style.boxShadow = 'none';
            btn.disabled = true;

        } else {
            // masih unpaid
            setBanner('unpaid', svgWaiting, 'Menunggu Pembayaran...', '#fef9c3', '#a16207', '#fef08a');
            btnText.textContent = 'Cek Status Pembayaran';
            btnIcon.innerHTML = `<path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>`;
            btn.disabled = false;
        }
    } catch(e) {
        btnText.textContent = 'Cek Status Pembayaran';
        btnIcon.innerHTML = `<path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>`;
        btn.disabled = false;
    }
}

function setBanner(type, svgIcon, text, bgColor, textColor, borderColor) {
    const banner = document.getElementById('payment-status-banner');
    banner.className = 'status-banner status-' + type;
    
    // Update styling dynamically
    if(bgColor) banner.style.background = bgColor;
    if(textColor) banner.style.color = textColor;
    if(borderColor) banner.style.borderColor = borderColor;
    
    document.getElementById('status-icon').innerHTML = svgIcon;
    document.getElementById('status-text').textContent = text;
}
</script>
@endpush