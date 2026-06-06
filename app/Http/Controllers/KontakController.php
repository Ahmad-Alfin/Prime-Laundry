<?php
// app/Http/Controllers/KontakController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KontakController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email',
            'pesan' => 'required|string|max:2000',
        ]);

        Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=minimal',
        ])->post(config('supabase.url') . '/rest/v1/contacts', [
            'nama'  => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return redirect()->route('kontak')->with('sent', true);
    }
}
