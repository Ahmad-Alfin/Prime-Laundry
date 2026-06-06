{{-- resources/views/pages/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Prime Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="admin-layout">

    {{-- ── Sidebar ─────────────────────────────────────────────────────── --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <svg width="32" height="32" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" fill="none" stroke="#fff" stroke-width="6"/>
                <path d="M35 30 Q50 20 55 40 Q60 55 45 60 Q55 62 50 75" fill="#fff"/>
                <circle cx="42" cy="28" r="5" fill="#fff"/>
            </svg>
            <div>
                <p class="brand-name">Prime Laundry</p>
                <p class="brand-sub">Admin Dashboard</p>
            </div>
        </div>

        @foreach([
            ['tab'=>'orders',      'label'=>'📋 Pesanan',        'count'=>count($orders)],
            ['tab'=>'payments',    'label'=>'💳 Pembayaran',    'count'=>count(array_filter($orders, fn($o)=>($o['payment_status']??'')!=='paid'))],
            ['tab'=>'contacts',    'label'=>'✉️ Pesan Masuk',   'count'=>count($contacts)],
            ['tab'=>'memberships', 'label'=>'🏷️ Pendaftaran',  'count'=>count($memberships)],
            ['tab'=>'users',       'label'=>'👥 Pengguna',      'count'=>count($users)],
        ] as $item)
        <a href="?tab={{ $item['tab'] }}"
           class="sidebar-item {{ $tab === $item['tab'] ? 'active' : '' }}">
            <span>{{ $item['label'] }}</span>
            <span class="sidebar-badge">{{ $item['count'] }}</span>
        </a>
        @endforeach

        <form method="POST" action="{{ route('logout') }}" style="margin-top:auto">
            @csrf
            <button type="submit" class="sidebar-item sidebar-logout">🚪 Keluar</button>
        </form>
    </aside>

    {{-- ── Main Content ────────────────────────────────────────────────── --}}
    <main class="admin-main">

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert-danger" style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: bold; border: 1px solid #fca5a5;">❌ {{ session('error') }}</div>
        @endif

        {{-- Stats Cards --}}
        @if($tab === 'orders' || $tab === 'payments')
        <div class="stats-grid">
            @foreach($stats as $s)
            <div class="stat-card" style="border-top-color:{{ $s['color'] }}">
                <p class="stat-label">{{ $s['label'] }}</p>
                <p class="stat-value" style="color:{{ $s['color'] }}">{{ $s['value'] }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- ── Tab: Pesanan ─────────────────────────────────────────── --}}
        @if($tab === 'orders')
        <h1 class="admin-page-title">Manajemen Pesanan</h1>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr>
                    <th>Kode</th><th>Customer</th><th>Layanan</th>
                    <th>Total</th><th>Pembayaran</th><th>Status</th>
                    <th>Tanggal</th><th>Telepon</th><th>Aksi</th>
                </tr></thead>
                <tbody>
                @foreach($orders as $i => $o)
                <tr class="{{ $i%2?'row-alt':'' }}">
                    <td><strong>{{ $o['code'] }}</strong></td>
                    <td>{{ $o['customer'] }}</td>
                    <td>{{ $o['service'] }}</td>
                    <td>Rp{{ number_format($o['total']??0,0,',','.') }}</td>
                    <td>
                        @if(($o['payment_status']??'unpaid') === 'paid')
                            <span class="badge badge-success">✅ Lunas</span>
                        @else
                            <span class="badge badge-warning">⏳ Belum Bayar</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $o['status']==='Completed'?'success':($o['status']==='Cancelled'?'danger':'warning') }}">{{ $o['status'] }}</span></td>
                    <td>{{ $o['date']??$o['created_at']??'-' }}</td>
                    <td>{{ $o['phone'] }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.order.status', $o['id']) }}" style="display:inline">
                            @csrf
                            <select name="status" class="select-sm" onchange="this.form.submit()">
                                @foreach(['still in process','Completed','Cancelled'] as $st)
                                <option {{ $o['status']===$st?'selected':'' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── Tab: Pembayaran ──────────────────────────────────────── --}}
        @elseif($tab === 'payments')
        <h1 class="admin-page-title">Verifikasi Pembayaran</h1>
        <p class="admin-desc">
            ⚠️ Konfirmasi pembayaran hanya setelah Anda memverifikasi dana sudah masuk ke rekening/QRIS Prime Laundry.
        </p>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr>
                    <th>Kode</th><th>Customer</th><th>Layanan</th>
                    <th>Total</th><th>Status Bayar</th><th>Tanggal</th><th>Aksi</th>
                </tr></thead>
                <tbody>
                @foreach($orders as $i => $o)
                <tr class="{{ $i%2?'row-alt':'' }}">
                    <td><strong>{{ $o['code'] }}</strong></td>
                    <td>{{ $o['customer'] }}</td>
                    <td>{{ $o['service'] }}</td>
                    <td><strong style="color:#00AEEF">Rp{{ number_format($o['total']??0,0,',','.') }}</strong></td>
                    <td>
                        @if(($o['payment_status']??'unpaid') === 'paid')
                            <span class="badge badge-success">✅ Lunas — {{ substr($o['paid_at']??'',0,16) }}</span>
                        @else
                            <span class="badge badge-warning">⏳ Menunggu</span>
                        @endif
                    </td>
                    <td>{{ substr($o['created_at']??'',0,10) }}</td>
                    <td>
                        @if(($o['payment_status']??'unpaid') !== 'paid')
                        <form method="POST" action="{{ route('admin.payment.confirm', $o['id']) }}">
                            @csrf
                            {{-- Modernized Button with SweetAlert2 data attrs --}}
                            <button type="submit" class="btn btn-sm btn-primary btn-confirm-swal"
                                    data-message="Konfirmasi Pembayaran {{ $o['code'] }}?"
                                    data-text="Pastikan saldo dana dari pelanggan benar-benar telah masuk ke rekening atau mutasi QRIS Prime Laundry!"
                                    data-btn-text="Ya, Konfirmasi Lunas">
                                ✅ Konfirmasi Lunas
                            </button>
                        </form>
                        @else
                            <span style="color:#10b981; font-weight:700">Sudah dikonfirmasi</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── Tab: Pesan Masuk ─────────────────────────────────────── --}}
        @elseif($tab === 'contacts')
        <h1 class="admin-page-title">Pesan Masuk</h1>
        <div class="table-wrap">
            @if(count($contacts) === 0)
                <div class="empty-state">Belum ada pesan masuk.</div>
            @else
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Email</th><th>Pesan</th><th>Waktu</th></tr></thead>
                <tbody>
                @foreach($contacts as $i => $c)
                <tr class="{{ $i%2?'row-alt':'' }}">
                    <td><strong>{{ $c['nama'] }}</strong></td>
                    <td>{{ $c['email'] }}</td>
                    <td>{{ $c['pesan'] }}</td>
                    <td>{{ substr($c['created_at']??'',0,16) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- ── Tab: Pendaftaran Membership ──────────────────────────── --}}
        @elseif($tab === 'memberships')
        <h1 class="admin-page-title">Pendaftaran Membership</h1>
        <div class="table-wrap">
            @if(count($memberships) === 0)
                <div class="empty-state">Belum ada pendaftaran membership.</div>
            @else
            <table class="data-table">
                <thead><tr><th>Nama</th><th>WhatsApp</th><th>Kota</th><th>Paket</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($memberships as $i => $m)
                <tr class="{{ $i%2?'row-alt':'' }}">
                    <td><strong>{{ $m['nama'] }}</strong></td>
                    <td>{{ $m['whatsapp'] }}</td>
                    {{-- Safe fallback for database consistency --}}
                    <td>{{ $m['kota'] ?? '—' }}</td>
                    <td><span class="badge badge-info" style="text-transform: uppercase;">{{ $m['membership'] }}</span></td>
                    <td>{{ substr($m['created_at']??'',0,10) }}</td>
                    <td>
                        @if(($m['status'] ?? 'pending') === 'approved')
                            <span class="badge badge-success">✅ Approved</span>
                        @else
                            <span class="badge badge-warning">⏳ Pending</span>
                        @endif
                    </td>
                    <td>
                        @if(($m['status'] ?? 'pending') !== 'approved')
                        <form method="POST" action="/admin/membership/approve/{{ $m['id'] }}" style="display:inline;">
                            @csrf
                            {{-- Modernized Button with SweetAlert2 data attrs --}}
                            <button type="submit" class="btn btn-sm btn-primary btn-confirm-swal" 
                                    style="padding: 0.2rem 0.5rem; font-size: 0.8rem; background: #10b981; border: none; color: #fff; border-radius: 4px; cursor: pointer;"
                                    data-message="Setujui Member Premium?" 
                                    data-text="Akun premium membership untuk sdr. {{ $m['nama'] }} akan langsung diaktifkan sepenuhnya."
                                    data-btn-text="Ya, Setujui!">
                                Setujui Member
                            </button>
                        </form>
                        @else
                            <span style="color:#10b981; font-size: 0.85rem; font-weight:700">Aktif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- ── Tab: Pengguna ────────────────────────────────────────── --}}
        @elseif($tab === 'users')
        <h1 class="admin-page-title">Data Pengguna</h1>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Kota</th><th>Login Via</th><th>Membership</th></tr></thead>
                <tbody>
                @foreach($users as $i => $u)
                <tr class="{{ $i%2?'row-alt':'' }}">
                    <td><strong>{{ $u['name'] }}</strong></td>
                    <td>{{ $u['email'] }}</td>
                    <td>{{ $u['phone'] ?? '—' }}</td>
                    <td>{{ $u['city'] ?? '—' }}</td>
                    <td>{{ $u['social_provider'] ?? 'Email' }}</td>
                    <td>{!! $u['membership'] ? '<span class="badge badge-success">'.$u['membership'].'</span>' : '—' !!}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </main>
</div>

{{-- ── SCRIPT MODERN POP-UP CONFIRMATION (SWEETALERT2) ────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mendeteksi semua tombol dengan kelas .btn-confirm-swal
        const confirmButtons = document.querySelectorAll('.btn-confirm-swal');

        confirmButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mengunci submit form HTML bawaan browser
                
                const form = this.closest('form');
                const titleMessage = this.getAttribute('data-message') || 'Apakah Anda yakin?';
                const textMessage = this.getAttribute('data-text') || 'Pastikan kembali tindakan Anda.';
                const confirmBtnText = this.getAttribute('data-btn-text') || 'Ya, Lanjutkan';

                // Membuat Pop-up Dialog Premium dan Elegan
                Swal.fire({
                    title: titleMessage,
                    text: textMessage,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981', // Emerald Green UI
                    cancelButtonColor: '#6b7280',  // Muted Gray UI
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: '#ffffff',
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Animasi loading screen estetik saat data dikirim ke server
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Sedang menyimpan perubahan status ke database.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit(); // Submit form asli
                    }
                });
            });
        });
    });
</script>
</body>
</html>