<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MembershipController extends Controller
{
    // =========================================================================
    // ─── ALUR PELANGGAN (CUSTOMER FLOW) ──────────────────────────────────────
    // =========================================================================

    // 1. Menyimpan pendaftaran awal & mengarahkan langsung ke halaman QRIS berbasis ID transaksi
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'whatsapp'   => 'required|string|max:20',
            'membership' => 'required|string|in:silver,gold,platinum',
            'agree'      => 'required|accepted',
        ]);

        $payload = [
            'nama'       => $request->nama,
            'whatsapp'   => $request->whatsapp,
            'membership' => $request->membership,
            'status'     => 'pending' 
        ];

        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=representation',
        ])->post(config('supabase.url') . '/rest/v1/memberships', $payload);

        if ($response->failed()) {
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? $errorData['hint'] ?? 'Terjadi kesalahan internal pada Supabase.';
            return redirect('/harga')->with('error', 'Gagal memproses database: ' . $errorMessage);
        }

        $data = $response->json();
        $membershipId = $data[0]['id'] ?? null;

        if (!$membershipId) {
            return redirect('/harga')->with('error', 'Gagal memproses pembuatan akun membership. ID Transaksi tidak dikembalikan oleh database.');
        }

        return redirect('/membership/payment/' . $membershipId);
    }

    // 2. Menampilkan gambar QRIS sesuai paket yang dipilih
    public function paymentPage($id)
    {
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/memberships?id=eq.{$id}");

        $data = $response->json();
        $membership = $data[0] ?? null;

        if (!$membership) {
            return redirect('/harga')->with('error', 'Data invoice transaksi tidak ditemukan.');
        }

        $package    = $membership['membership'];
        $nama       = $membership['nama'];
        $whatsapp   = $membership['whatsapp'];
        $status     = $membership['status'] ?? 'pending';

        $prices     = ['silver' => 300000, 'gold' => 500000, 'platinum' => 900000];
        $names      = ['silver' => 'Paket Silver', 'gold' => 'Paket Gold', 'platinum' => 'Paket Platinum'];
        $harga      = $prices[$package] ?? 0;
        $nama_paket = $names[$package] ?? $package;

        return view('pages.membership-payment', compact('id', 'package', 'nama', 'whatsapp', 'harga', 'nama_paket', 'status'));
    }

    // 3. API Pengecekan realtime latar belakang oleh JavaScript halaman web
    public function checkStatus($id)
    {
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/memberships?id=eq.{$id}");

        $data = $response->json();
        $status = $data[0]['status'] ?? 'pending';

        return response()->json(['status' => $status]);
    }

    // 4. Mengeksekusi tombol ketika konfirmasi selesai diklik oleh user (Setelah disetujui admin)
    public function confirmPayment(Request $request, $id)
    {
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/memberships?id=eq.{$id}");

        $data = $response->json();
        $status = $data[0]['status'] ?? 'pending';

        if ($status !== 'approved') {
            return redirect()->back()->with('error', 'Akses ditolak! Pembayaran belum diverifikasi admin.');
        }

        return redirect('/harga')->with('membership_success', 'Selamat! Akun premium membership Anda telah aktif sepenuhnya! 🎉');
    }

    // =========================================================================
    // ─── ALUR ADMIN (ADMIN FLOW - BARU) ──────────────────────────────────────
    // =========================================================================

    // 5. Fungsi Eksekusi Persetujuan Admin dari Dashboard
    public function approve($id)
    {
        // Mengubah kolom status menjadi 'approved' berdasarkan ID pendaftaran di Supabase
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
            'Content-Type'  => 'application/json',
        ])->patch(config('supabase.url') . "/rest/v1/memberships?id=eq.{$id}", [
            'status' => 'approved'
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Gagal memperbarui status membership di database.');
        }

        // Kembali ke dashboard admin pada tab pendaftaran dengan notifikasi sukses
        return redirect('/admin?tab=memberships')->with('success', 'Berhasil menyetujui pendaftaran member premium! 🎉');
    }
}