<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    // ─── Show Login Page ────────────────────────────────────────────────────
    public function showLogin()
    {
        return view('pages.login');
    }

    // ─── Handle Login ───────────────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek admin hardcoded (Disamakan menggunakan 'is_admin' => true)
        if ($request->email === 'admin@primelaundry.com' && $request->password === 'Admin@Prime2026') {
            $admin = User::firstOrCreate(
                ['email' => 'admin@primelaundry.com'],
                ['name' => 'Admin Prime', 'password' => Hash::make('Admin@Prime2026'), 'is_admin' => true]
            );
            
            // Jaga-jaga jika data sudah ada tapi 'is_admin' masih false di database
            if (!$admin->is_admin) {
                $admin->update(['is_admin' => true]);
            }

            Auth::login($admin);
            return redirect()->route('admin.dashboard');
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('beranda'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // ─── Show Register Page ─────────────────────────────────────────────────
    public function showRegister()
    {
        return view('pages.register');
    }

    // ─── Handle Register ────────────────────────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'email'    => $request->email,
            'name'     => explode('@', $request->email)[0],
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        // Simpan ke Supabase juga
        $this->syncToSupabase('users', [
            'id'    => $user->id,
            'email' => $user->email,
            'name'  => $user->name,
        ]);

        Auth::login($user);
        return redirect()->route('beranda');
    }

    // ─── Logout ─────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }

    // ─── Social Login Redirect ──────────────────────────────────────────────
    public function socialRedirect($provider)
    {
        $supported = ['google', 'facebook', 'twitter', 'apple'];
        if (!in_array($provider, $supported)) {
            return redirect()->route('login')->withErrors(['msg' => 'Provider tidak didukung.']);
        }
        
        // Menggunakan driver khusus OAuth 2.0 jika mendeteksi 'twitter'
        if ($provider === 'twitter') {
            return Socialite::driver('twitter-oauth-2')->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    // ─── Social Login Callback ──────────────────────────────────────────────
    public function socialCallback($provider)
    {
        try {
            // Menggunakan driver khusus OAuth 2.0 jika mendeteksi 'twitter'
            if ($provider === 'twitter') {
                $socialUser = Socialite::driver('twitter-oauth-2')->user();
            } else {
                $socialUser = Socialite::driver($provider)->user();
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Login sosial gagal. Coba lagi.']);
        }

        // Cari atau buat user
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name'            => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'password'        => Hash::make(str()->random(24)),
                'social_provider' => $provider,
                'social_id'       => $socialUser->getId(),
                'avatar'          => $socialUser->getAvatar(),
            ]
        );

        Auth::login($user);
        return redirect()->route('beranda');
    }

    // ─── Show Profile (DENGAN INTEGRASI OTOMATIS MEMBERSHIP KADALUARSA) ───
    public function showProfile()
    {
        $user = Auth::user();
        $membership = null;

        // Tarik data pendaftaran member dari Supabase berdasarkan nama/identitas yang cocok
        $response = Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
        ])->get(config('supabase.url') . "/rest/v1/memberships?nama=eq.{$user->name}&status=eq.approved&order=created_at.desc");

        if ($response->successful() && count($response->json()) > 0) {
            $membership = $response->json()[0];
            
            // Hitung tanggal kadaluarsa otomatis (+30 hari setelah disetujui admin)
            $tanggalMulai = new \DateTime($membership['created_at']);
            $tanggalMasaTenggang = clone $tanggalMulai;
            $tanggalMasaTenggang->modify('+30 days'); 
            
            $membership['expired_at'] = $tanggalMasaTenggang->format('Y-m-d');
            
            // Logika otomatis berhenti jika waktu sekarang melewati masa tenggang
            $hariIni = new \DateTime();
            if ($hariIni > $tanggalMasaTenggang) {
                $membership['is_active'] = false;
            } else {
                $membership['is_active'] = true;
            }
        }

        return view('pages.profile', compact('user', 'membership'));
    }

    // ─── Update Profile ─────────────────────────────────────────────────────
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'phone', 'address', 'city', 'zip'));

        // Sync ke Supabase
        $this->syncToSupabase('users', [
            'id'    => $user->id,
            'name'  => $user->name,
            'phone' => $user->phone,
        ], 'PATCH');

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ─── Helper: Sync ke Supabase REST API ─────────────────────────────────
    private function syncToSupabase(string $table, array $data, string $method = 'POST')
    {
        $url = config('supabase.url') . "/rest/v1/{$table}";
        Http::withHeaders([
            'apikey'        => config('supabase.key'),
            'Authorization' => 'Bearer ' . config('supabase.key'),
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=minimal',
        ])->{strtolower($method)}($url, $data);
    }
}