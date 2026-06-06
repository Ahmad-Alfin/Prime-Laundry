<?php
// app/Http/Controllers/PickupController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class PickupController extends Controller
{
    // ─── Data Harga per Kategori ────────────────────────────────────────────
    public static function getServiceItems(): array
    {
        return [
            'Daily Kiloan' => [
                ['item' => 'Cuci Kering Lipat (Min. 3 Kg)',  'regular' => 5000,  'one_day' => 8000,  'express' => 10000, 'quick' => 15000, 'unit' => 'kg'],
                ['item' => 'Cuci Kering Gosok (Min. 3 Kg)',  'regular' => 8000,  'one_day' => 12000, 'express' => 16000, 'quick' => 25000, 'unit' => 'kg'],
                ['item' => 'Setrika Kiloan (Min. 3 Kg)',     'regular' => 5000,  'one_day' => 10000, 'express' => 12000, 'quick' => 15000, 'unit' => 'kg'],
            ],
            'Cuci dan Setrika' => [
                ['item' => 'Kemeja / Blouse / Batik',        'regular' => 15000, 'one_day' => 25000, 'express' => 30000, 'unit' => 'pcs'],
                ['item' => 'Celana / Rok / Shorts',          'regular' => 20000, 'one_day' => 30000, 'express' => 40000, 'unit' => 'pcs'],
                ['item' => 'Jaket / Blazer / Jas',           'regular' => 30000, 'one_day' => 45000, 'express' => 60000, 'unit' => 'pcs'],
                ['item' => 'Jaket Jeans / Hoodie / Sweater', 'regular' => 30000, 'one_day' => 45000, 'express' => 60000, 'unit' => 'pcs'],
                ['item' => 'Dress / Gamis / Long Dress',     'regular' => 30000, 'one_day' => 45000, 'express' => 65000, 'unit' => 'pcs'],
                ['item' => 'Mukena / Sarung / Sajadah',      'regular' => 10000, 'one_day' => 15000, 'express' => 20000, 'unit' => 'pcs'],
            ],
            'Dry Cleaning' => [
                ['item' => 'Gown / Gaun Pesta',              'regular' => 70000, 'one_day' => null,  'express' => null,  'unit' => 'pcs'],
                ['item' => 'Coat / Matel / Jaket Tebal',     'regular' => 80000, 'one_day' => null,  'express' => null,  'unit' => 'pcs'],
                ['item' => 'Jas Lengkap (2 pcs)',            'regular' => 90000, 'one_day' => null,  'express' => null,  'unit' => 'set'],
            ],
            'Setrika' => [
                ['item' => 'Kemeja / Blouse',                'regular' => 5000,  'one_day' => 7000,  'express' => 10000, 'unit' => 'pcs'],
                ['item' => 'Celana / Rok',                   'regular' => 5000,  'one_day' => 7000,  'express' => 10000, 'unit' => 'pcs'],
                ['item' => 'Jaket / Blazer',                 'regular' => 8000,  'one_day' => 12000, 'express' => 15000, 'unit' => 'pcs'],
            ],
            'Green Dry Cleaning' => [
                ['item' => 'Kemeja / Blouse (Eco)',          'regular' => 18000, 'one_day' => 28000, 'express' => 35000, 'unit' => 'pcs'],
                ['item' => 'Celana / Rok (Eco)',             'regular' => 22000, 'one_day' => 32000, 'express' => 45000, 'unit' => 'pcs'],
                ['item' => 'Dress / Gamis (Eco)',            'regular' => 35000, 'one_day' => 50000, 'express' => 70000, 'unit' => 'pcs'],
            ],
            'Laundry Sepatu' => [
                ['item' => 'Nylon, Canvas & Rubber',         'regular' => 40000, 'one_day' => 60000, 'express' => 75000, 'unit' => 'pasang'],
                ['item' => 'Suede & Leather',                'regular' => 50000, 'one_day' => 70000, 'express' => 80000, 'unit' => 'pasang'],
                ['item' => 'Sneakers Premium',               'regular' => 60000, 'one_day' => 85000, 'express' => 100000,'unit' => 'pasang'],
            ],
            'Laundry Tas' => [
                ['item' => 'Tas Non Leather (Kecil)',        'regular' => 50000, 'one_day' => 75000, 'express' => 100000,'unit' => 'pcs'],
                ['item' => 'Tas Non Leather (Besar)',        'regular' => 70000, 'one_day' => 105000,'express' => 140000,'unit' => 'pcs'],
                ['item' => 'Tas Leather (Kecil)',            'regular' => 80000, 'one_day' => 120000,'express' => 160000,'unit' => 'pcs'],
                ['item' => 'Tas Leather (Besar)',            'regular' => 100000,'one_day' => 150000,'express' => 200000,'unit' => 'pcs'],
            ],
            'Laundry Karpet' => [
                ['item' => 'Karpet Kecil (s/d 2m²)',        'regular' => 30000, 'one_day' => 45000, 'express' => 60000, 'unit' => 'pcs'],
                ['item' => 'Karpet Sedang (2–5m²)',         'regular' => 50000, 'one_day' => 75000, 'express' => 100000,'unit' => 'pcs'],
                ['item' => 'Karpet Besar (>5m²)',           'regular' => 80000, 'one_day' => 120000,'express' => 160000,'unit' => 'pcs'],
            ],
            'Laundry Gorden' => [
                ['item' => 'Gorden Tipis (per meter)',       'regular' => 15000, 'one_day' => 22000, 'express' => 30000, 'unit' => 'meter'],
                ['item' => 'Gorden Tebal (per meter)',       'regular' => 25000, 'one_day' => 38000, 'express' => 50000, 'unit' => 'meter'],
                ['item' => 'Vitrage / Kain Renda (per m)',  'regular' => 12000, 'one_day' => 18000, 'express' => 25000, 'unit' => 'meter'],
            ],
        ];
    }

    // ─── Show Pickup Page ───────────────────────────────────────────────────
    public function index()
    {
        $services     = array_keys(self::getServiceItems());
        $serviceItems = self::getServiceItems();
        return view('pages.beranda', compact('services', 'serviceItems'));
    }

    // ─── Store Order ─────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'alamat'      => 'required|string',
            'whatsapp'    => 'required|string|max:20',
            'service'     => 'required|string',
            'tanggal'     => 'required|date',
            'jam'         => 'required|string',
            'items'       => 'required|array|min:1',
            'items.*.item'     => 'required|string',
            'items.*.speed'    => 'required|string',
            'items.*.qty'      => 'required|numeric|min:1',
            'items.*.price'    => 'required|numeric|min:0',
            'total'       => 'required|numeric|min:0',
        ]);

        $code = 'PL-' . str_pad(Order::count() + 1, 3, '0', STR_PAD_LEFT);

        // Simpan ke Supabase
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=representation',
        ])->post(config('supabase.url') . '/rest/v1/orders', [
            'code'          => $code,
            'user_id'       => Auth::id(),
            'customer'      => $request->nama,
            'phone'         => $request->whatsapp,
            'address'       => $request->alamat,
            'service'       => $request->service,
            'items'         => json_encode($request->items),
            'total'         => $request->total,
            'pickup_date'   => $request->tanggal,
            'pickup_time'   => $request->jam,
            'status'        => 'Menunggu Pembayaran',
            'payment_status'=> 'unpaid',
        ]);

        $order = $response->json()[0] ?? null;

        if (!$order) {
            return back()->withErrors(['msg' => 'Gagal membuat pesanan. Coba lagi.']);
        }

        return redirect()->route('payment.show', $order['id']);
    }
}
