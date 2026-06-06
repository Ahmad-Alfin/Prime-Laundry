{{-- resources/views/components/navbar.blade.php --}}
<nav class="navbar">
    <a href="{{ route('beranda') }}" class="nav-logo">
        {{-- Penggantian logo inline SVG dengan format gambar --}}
        {{-- Pastikan Anda memiliki file logo.png di public/images/ --}}
        <img src="{{ asset('images/Group 26.png') }}" alt="Prime Laundry Logo" width="36" height="36">
        <span class="nav-brand">Prime Laundry</span>
    </a>

    <div class="nav-links">
        @foreach(['beranda' => 'Beranda', 'harga' => 'Harga', 'cek-status' => 'Cek Status', 'syarat' => 'Syarat Ketentuan', 'kontak' => 'Kontak'] as $route => $label)
            <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach

        @auth
            <div class="nav-user">
                <a href="{{ route('profile') }}" class="avatar-btn" title="{{ auth()->user()->name }}">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
        @endauth
    </div>

    {{-- Mobile Hamburger --}}
    <button class="hamburger" onclick="toggleMobileNav()" aria-label="Menu">☰</button>
</nav>

{{-- Mobile Nav Drawer --}}
<div id="mobile-nav" class="mobile-nav hidden">
    @foreach(['beranda' => 'Beranda', 'harga' => 'Harga', 'cek-status' => 'Cek Status', 'syarat' => 'Syarat Ketentuan', 'kontak' => 'Kontak'] as $route => $label)
        <a href="{{ route($route) }}" class="mobile-link">{{ $label }}</a>
    @endforeach
    @auth
        <a href="{{ route('profile') }}" class="mobile-link">Profil Saya</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="mobile-link w-full text-left">Keluar</button></form>
    @else
        <a href="{{ route('login') }}" class="mobile-link">Login</a>
    @endauth
</div>

<script>
function toggleMobileNav() {
    document.getElementById('mobile-nav').classList.toggle('hidden');
}
</script>