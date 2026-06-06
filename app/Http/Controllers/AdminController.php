<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    private function supabaseHeaders(): array
    {
        return [
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.service_key'), // service key untuk admin
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=minimal',
        ];
    }

    // ─── Admin Dashboard ─────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'orders');
        $base = config('supabase.url') . '/rest/v1/';

        $orders      = Http::withHeaders($this->supabaseHeaders())->get($base . 'orders?order=created_at.desc')->json();
        $contacts    = Http::withHeaders($this->supabaseHeaders())->get($base . 'contacts?order=created_at.desc')->json();
        $memberships = Http::withHeaders($this->supabaseHeaders())->get($base . 'memberships?order=created_at.desc')->json();
        $users       = Http::withHeaders($this->supabaseHeaders())->get($base . 'users?order=created_at.desc')->json();

        $stats = [
            ['label' => 'Total Pesanan',    'value' => count($orders),    'color' => '#00AEEF'],
            ['label' => 'Pesanan Aktif',    'value' => count(array_filter($orders, fn($o) => $o['status'] === 'still in process')), 'color' => '#f59e0b'],
            ['label' => 'Selesai',          'value' => count(array_filter($orders, fn($o) => $o['status'] === 'Completed')),        'color' => '#10b981'],
            ['label' => 'Belum Dibayar',    'value' => count(array_filter($orders, fn($o) => ($o['payment_status'] ?? '') === 'unpaid')), 'color' => '#ef4444'],
        ];

        return view('pages.admin.dashboard', compact('tab', 'orders', 'contacts', 'memberships', 'users', 'stats'));
    }

    // ─── Update Status Order ─────────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        Http::withHeaders($this->supabaseHeaders())
            ->patch(config('supabase.url') . "/rest/v1/orders?id=eq.{$id}", [
                'status' => $request->status,
            ]);

        return back()->with('success', 'Status diperbarui.');
    }

    // ─── Konfirmasi Pembayaran Manual oleh Admin ─────────────────────────────
    // Admin menekan tombol "Konfirmasi Lunas" setelah memverifikasi bukti transfer
    public function confirmPayment(Request $request, $id)
    {
        Http::withHeaders($this->supabaseHeaders())
            ->patch(config('supabase.url') . "/rest/v1/orders?id=eq.{$id}", [
                'payment_status' => 'paid',
                'paid_at'        => now()->toISOString(),
                'status'         => 'still in process',
            ]);

        return back()->with('success', 'Pembayaran dikonfirmasi. Pesanan mulai diproses.');
    }
}
