{{-- resources/views/pages/payment-success.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Pembayaran Berhasil — Prime Laundry')

@section('content')
<section class="section" style="max-width: 540px; margin: 3rem auto; text-align: center; padding: 0 1rem;">
    <div class="success-card" style="background: #fff; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
        
        {{-- Success Icon (Menggantikan Emoji Centang) --}}
        <div class="success-icon" style="background: #dcfce7; color: #10b981; width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1 class="success-title" style="color: #1e3a5f; font-weight: 800; font-size: 1.75rem; margin-bottom: 0.5rem;">Pembayaran Berhasil!</h1>
        <p class="success-sub" style="color: #475569; font-size: 1.05rem; margin-bottom: 0.5rem;">Terima kasih, <strong style="color: #1e3a5f;">{{ $order['customer'] }}</strong>!</p>
        <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2rem;">Pesanan Anda telah kami terima dan akan segera diproses.</p>

        {{-- Detail Transaksi --}}
        <div class="success-details" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.25rem 1.5rem; text-align: left; margin-bottom: 1.5rem;">
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: #64748b;">Kode Order</span>
                <strong style="color: #334155;">{{ $order['code'] }}</strong>
            </div>
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: #64748b;">Layanan</span>
                <strong style="color: #334155;">{{ $order['service'] }}</strong>
            </div>
            <div class="detail-row" style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem; align-items: center;">
                <span style="color: #64748b;">Total Bayar</span>
                <strong style="color: #00AEEF; font-size: 1.15rem;">Rp{{ number_format($order['total'], 0, ',', '.') }}</strong>
            </div>
            <hr style="border: 0; border-top: 1px dashed #cbd5e1; margin: 1rem 0;">
            <div class="detail-row" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.95rem;">
                <span style="color: #64748b;">Status</span>
                <span class="badge badge-process" style="background: #fef08a; color: #854d0e; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Sedang Diproses</span>
            </div>
        </div>

        {{-- Info Note (Menggantikan Emoji HP) --}}
        <div class="success-note" style="display: flex; align-items: flex-start; gap: 12px; background: #f0f9ff; padding: 1rem 1.25rem; border-radius: 10px; text-align: left; margin-bottom: 2.5rem; border: 1px solid #bae6fd;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
                <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12 18h.01"></path>
            </svg>
            <p style="margin: 0; color: #0369a1; font-size: 0.9rem; line-height: 1.5;">
                Tim kami akan menghubungi Anda via WhatsApp di nomor <strong style="color: #075985;">{{ $order['phone'] }}</strong> untuk konfirmasi pengambilan.
            </p>
        </div>

        {{-- Tombol Aksi (Menggantikan Emoji Kaca Pembesar & Rumah) --}}
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('cek-status') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #00AEEF; color: #fff; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; transition: background 0.2s; box-shadow: 0 4px 12px rgba(0, 174, 239, 0.2); flex: 1; min-width: 200px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                Cek Status Laundry
            </a>
            
            <a href="{{ route('beranda') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #fff; color: #64748b; border: 2px solid #e2e8f0; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; transition: all 0.2s; flex: 1; min-width: 200px;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.color='#334155'; this.style.background='#f8fafc'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'; this.style.background='#fff'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
        
    </div>
</section>
@endsection