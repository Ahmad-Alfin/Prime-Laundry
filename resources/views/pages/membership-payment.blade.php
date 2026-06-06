{{-- resources/views/pages/membership-payment.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Menunggu Verifikasi QRIS — Prime Laundry')
@section('content')

<div style="max-width: 600px; margin: 3rem auto; padding: 2rem; background: #fff; border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); text-align: center; font-family: sans-serif;">
    
    {{-- Status Badge Pending --}}
    <div style="margin-bottom: 1.5rem;">
        <span id="status-badge" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #fef3c7; color: #d97706; padding: .5rem 1rem; border-radius: 20px; font-size: .85rem; font-weight: bold; text-transform: uppercase;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 22h14"></path><path d="M5 2h14"></path><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"></path><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"></path>
            </svg>
            Menunggu Konfirmasi Pembayaran Admin
        </span>
    </div>

    <h2 style="color: #1e3a5f; font-weight: 800; margin-bottom: .5rem; font-size: 1.6rem;">Invoice Pembayaran QRIS</h2>
    <p style="color: #6b7280; font-size: .9rem; margin-bottom: 2rem;">Silakan lakukan scan QRIS dan tunggu hingga admin mengonfirmasi dana masuk.</p>

    {{-- Detail Invoice --}}
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem 1.5rem; text-align: left; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; margin-bottom: .6rem; font-size: .95rem;">
            <span style="color: #6b7280;">Nama Pelanggan:</span>
            <strong style="color: #334155;">{{ $nama }}</strong>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: .6rem; font-size: .95rem;">
            <span style="color: #6b7280;">No. WhatsApp:</span>
            <strong style="color: #334155;">{{ $whatsapp }}</strong>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: .6rem; font-size: .95rem;">
            <span style="color: #6b7280;">Paket Terpilih:</span>
            <strong style="color: #00AEEF; text-transform: uppercase;">{{ $nama_paket }}</strong>
        </div>
        <hr style="border: 0; border-top: 1px dashed #cbd5e1; margin: .8rem 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 1.1rem;">
            <span style="color: #334155; font-weight: bold;">Total Tagihan:</span>
            <strong style="color: #dc2626; font-size: 1.2rem; font-weight: 900;">Rp {{ number_format($harga, 0, ',', '.') }}</strong>
        </div>
    </div>

    {{-- Scan QRIS Code --}}
    <div style="margin-bottom: 2rem; display: inline-block; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; background: #fff;">
        <img src="{{ asset('images/qris-prime-laundry.png') }}" 
             alt="QRIS Prime Laundry" style="width: 250px; height: 250px; display: block; margin: 0 auto; object-fit: contain;">
        <div style="margin-top: .8rem; font-weight: bold; color: #1e3a5f; font-size: .9rem;">PRIME LAUNDRY QRIS GPN</div>
    </div>

    {{-- Live System Indicator Loader --}}
    <div id="loading-container" style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 2rem; color: #4b5563; font-size: .9rem; background: #f3f4f6; padding: .8rem; border-radius: 8px;">
        <div class="spinner" style="width: 18px; height: 18px; border: 3px solid #d1d5db; border-top-color: #00AEEF; border-radius: 50%; animation: spin 1s linear infinite;"></div>
        <span id="loading-text">Sistem mendeteksi transfer otomatis, mohon selesaikan transaksi...</span>
    </div>

    {{-- Form Submit Konfirmasi Selesai (Default Terkunci / Disabled jika pending) --}}
    <form action="{{ route('membership.confirm', ['id' => $id]) }}" method="POST">
        @csrf
        <button type="submit" id="btn-submit" disabled 
                style="display: flex; align-items: center; justify-content: center; gap: 8px; background: #9ca3af; color: #fff; font-weight: bold; font-size: 1rem; padding: 1rem 2rem; width: 100%; border: none; border-radius: 8px; cursor: not-allowed; box-shadow: none; transition: all 0.3s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span>Menunggu Verifikasi Admin</span>
        </button>
    </form>

    {{-- Link Batalkan --}}
    <a href="/harga" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; margin-top: 1.2rem; color: #9ca3af; font-size: .85rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#9ca3af'">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        Batalkan Transaksi
    </a>
</div>

<style>
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

{{-- JAVASCRIPT LIVE TRACKER AUTO UNLOCK BUTTON --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const idMembership = "{{ $id }}";
        const btnSubmit = document.getElementById("btn-submit");
        const statusBadge = document.getElementById("status-badge");
        const loadingContainer = document.getElementById("loading-container");
        const loadingText = document.getElementById("loading-text");

        // Fungsi melakukan hit API Laravel diam-diam tiap 5 detik
        function checkPaymentStatus() {
            fetch(`/membership/check-status/${idMembership}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'approved') {
                        // 1. Aktifkan & Ubah Gaya Tombol Konfirmasi Selesai
                        btnSubmit.removeAttribute("disabled");
                        btnSubmit.style.background = "#22c55e";
                        btnSubmit.style.cursor = "pointer";
                        btnSubmit.style.boxShadow = "0 4px 12px rgba(34, 197, 94, 0.3)";
                        btnSubmit.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Pembayaran Terverifikasi! Selesaikan Pendaftaran</span>
                        `;

                        // 2. Ubah Atribut Badge Informasi Status Atas
                        statusBadge.style.background = "#dcfce7";
                        statusBadge.style.color = "#15803d";
                        statusBadge.style.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="m9 12 2 2 4-4"></path>
                            </svg>
                            Pembayaran Sukses Dikonfirmasi!
                        `;

                        // 3. Sembunyikan Animasi Loading Putar
                        loadingContainer.style.background = "#f0fdf4";
                        loadingContainer.style.color = "#16a34a";
                        loadingText.innerHTML = "Dana telah diverifikasi admin. Silakan klik tombol hijau di atas.";
                        document.querySelector(".spinner").style.display = "none";

                        // Hentikan pengecekan berulang karena sudah sukses
                        clearInterval(statusInterval);
                    }
                })
                .catch(error => console.error("Gagal memeriksa status:", error));
        }

        // Jalankan pengecekan otomatis tiap 5000 mili detik (5 detik)
        const statusInterval = setInterval(checkPaymentStatus, 5000);
        
        // Jalankan sekali di awal untuk antisipasi jika user melakukan reload manual
        checkPaymentStatus();
    });
</script>
@endsection