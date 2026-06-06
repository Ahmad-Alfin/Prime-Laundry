<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // ─── Tampilkan Halaman QRIS ─────────────────────────────────────────────
    public function show($orderId)
    {
        // Ambil data order dari Supabase
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/orders?id=eq.{$orderId}&select=*");

        $order = $response->json()[0] ?? null;

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        // QRIS statis Prime Laundry (ganti dengan QR asli/dinamis dari payment gateway)
        // Untuk produksi: gunakan Midtrans / Xendit / Duitku untuk QRIS dinamis per transaksi
        $qrisImageUrl = asset('images/qris-prime-laundry.png'); // taruh di public/images/
        $qrisNumber   = '000201010212...'; // Nomor QRIS statis (isi sesuai dari bank/aggregator)

        return view('pages.payment', compact('order', 'qrisImageUrl', 'qrisNumber'));
    }

    // ─── Cek Status Pembayaran (polling dari admin atau Midtrans webhook) ───
    public function check(Request $request, $orderId)
    {
        // Ambil order dari Supabase
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/orders?id=eq.{$orderId}&select=payment_status,paid_at");

        $order = $response->json()[0] ?? null;

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        return response()->json([
            'status'     => $order['payment_status'],  // 'unpaid' | 'paid' | 'expired'
            'paid_at'    => $order['paid_at'] ?? null,
        ]);
    }

    // ─── Halaman Sukses Pembayaran ──────────────────────────────────────────
    public function success($orderId)
    {
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/orders?id=eq.{$orderId}&select=*");

        $order = $response->json()[0] ?? null;

        if (!$order || $order['payment_status'] !== 'paid') {
            return redirect()->route('payment.show', $orderId)
                ->withErrors(['msg' => 'Pembayaran belum terkonfirmasi.']);
        }

        // Kirim notif WhatsApp ke admin
        $waMsg = "✅ *Pembayaran Masuk!*\n"
               . "Kode: {$order['code']}\n"
               . "Customer: {$order['customer']}\n"
               . "Layanan: {$order['service']}\n"
               . "Total: Rp" . number_format($order['total'], 0, ',', '.') . "\n"
               . "Waktu: " . now()->format('d M Y H:i');
        @file_get_contents("https://wa.me/6289562111246?text=" . urlencode($waMsg));

        return view('pages.payment-success', compact('order'));
    }
}
