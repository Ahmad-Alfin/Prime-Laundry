<?php
// app/Http/Controllers/StatusController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StatusController extends Controller
{
    private function headers(): array
    {
        return [
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ];
    }

    public function index()
    {
        $today    = now()->toDateString();
        $lastWeek = now()->subDays(7)->toDateString();

        $allOrders = Http::withHeaders($this->headers())
            ->get(config('supabase.url') . '/rest/v1/orders?order=created_at.desc&limit=50')
            ->json();

        $todayOrders    = array_filter($allOrders ?? [], fn($o) => isset($o['date']) && $o['date'] === $today);
        $lastWeekOrders = array_filter($allOrders ?? [], fn($o) => isset($o['date']) && $o['date'] !== $today);

        return view('pages.cek-status', [
            'today'    => array_values($todayOrders),
            'lastWeek' => array_values($lastWeekOrders),
        ]);
    }

    public function search(Request $request)
    {
        $code = trim($request->input('code', ''));

        $response = Http::withHeaders($this->headers())
            ->get(config('supabase.url') . "/rest/v1/orders?code=ilike.{$code}&limit=1");

        $result = $response->json()[0] ?? null;

        $today    = now()->toDateString();
        $allOrders = Http::withHeaders($this->headers())
            ->get(config('supabase.url') . '/rest/v1/orders?order=created_at.desc&limit=50')
            ->json();

        $todayOrders    = array_values(array_filter($allOrders ?? [], fn($o) => ($o['date'] ?? '') === $today));
        $lastWeekOrders = array_values(array_filter($allOrders ?? [], fn($o) => ($o['date'] ?? '') !== $today));

        return view('pages.cek-status', [
            'result'     => $result,
            'searchCode' => $code,
            'today'      => $todayOrders,
            'lastWeek'   => $lastWeekOrders,
        ]);
    }
}
