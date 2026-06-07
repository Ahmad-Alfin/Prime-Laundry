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
    <style>
        /* Tambahan styling agar icon align dengan teks */
        .flex-center { display: inline-flex; align-items: center; gap: 6px; }
        .sidebar-item-content { display: flex; align-items: center; gap: 10px; }
    </style>
</head>
<body>
<div class="admin-layout">

    {{-- ── Sidebar ─────────────────────────────────────────────────────── --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            {{-- Menggunakan Image Group 26.png --}}
            <img src="{{ asset('images/Group 26.png') }}" alt="Prime Laundry" style="width: 42px; height: auto; object-fit: contain;">
            <div>
                <p class="brand-name">Prime Laundry</p>
                <p class="brand-sub">Admin Dashboard</p>
            </div>
        </div>

        @foreach([
            [
                'tab'=>'orders', 
                'icon'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
                'label'=>'Pesanan',        
                'count'=>count($orders)
            ],
            [
                'tab'=>'payments',   
                'icon'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>',
                'label'=>'Pembayaran',     
                'count'=>count(array_filter($orders, fn($o)=>($o['payment_status']??'')!=='paid'))
            ],
            [
                'tab'=>'contacts',   
                'icon'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
                'label'=>'Pesan Masuk',    
                'count'=>count($contacts)
            ],
            [
                'tab'=>'memberships',
                'icon'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
                'label'=>'Pendaftaran',    
                'count'=>count($memberships)
            ],
            [
                'tab'=>'users',      
                'icon'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
                'label'=>'Pengguna',       
                'count'=>count($users)
            ],
        ] as $item)
        <a href="?tab={{ $item['tab'] }}"
           class="sidebar-item {{ $tab === $item['tab'] ? 'active' : '' }}">
            <span class="sidebar-item-content">
                {!! $item['icon'] !!}
                {{ $item['label'] }}
            </span>
            <span class="sidebar-badge">{{ $item['count'] }}</span>
        </a>
        @endforeach

        <form method="POST" action="{{ route('logout') }}" style="margin-top:auto">
            @csrf
            <button type="submit" class="sidebar-item sidebar-logout flex-center" style="width: 100%; border: none; cursor: pointer;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Keluar
            </button>
        </form>
    </aside>

    {{-- ── Main Content ────────────────────────────────────────────────── --}}
    <main class="admin-main">

        @if(session('success'))
            <div class="alert-success flex-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert-danger flex-center" style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: bold; border: 1px solid #fca5a5;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                {{ session('error') }}
            </div>
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
                            <span class="badge badge-success flex-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Lunas
                            </span>
                        @else
                            <span class="badge badge-warning flex-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Belum Bayar
                            </span>
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
        <p class="admin-desc flex-center" style="margin-bottom: 1.5rem; color: #b45309; background: #fef3c7; padding: 12px; border-radius: 8px; font-weight: 600;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            Konfirmasi pembayaran hanya setelah Anda memverifikasi dana sudah masuk ke rekening/QRIS Prime Laundry.
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
                            <span class="badge badge-success flex-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Lunas — {{ substr($o['paid_at']??'',0,16) }}
                            </span>
                        @else
                            <span class="badge badge-warning flex-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Menunggu
                            </span>
                        @endif
                    </td>
                    <td>{{ substr($o['created_at']??'',0,10) }}</td>
                    <td>
                        @if(($o['payment_status']??'unpaid') !== 'paid')
                        <form method="POST" action="{{ route('admin.payment.confirm', $o['id']) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary btn-confirm-swal flex-center"
                                    data-message="Konfirmasi Pembayaran {{ $o['code'] }}?"
                                    data-text="Pastikan saldo dana dari pelanggan benar-benar telah masuk ke rekening atau mutasi QRIS Prime Laundry!"
                                    data-btn-text="Ya, Konfirmasi Lunas">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Konfirmasi Lunas
                            </button>
                        </form>
                        @else
                            <span class="flex-center" style="color:#10b981; font-weight:700">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Terdikonfirmasi
                            </span>
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
                    <td>{{ $m['kota'] ?? '—' }}</td>
                    <td><span class="badge badge-info" style="text-transform: uppercase;">{{ $m['membership'] }}</span></td>
                    <td>{{ substr($m['created_at']??'',0,10) }}</td>
                    <td>
                        @if(($m['status'] ?? 'pending') === 'approved')
                            <span class="badge badge-success flex-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Approved
                            </span>
                        @else
                            <span class="badge badge-warning flex-center">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Pending
                            </span>
                        @endif
                    </td>
                    <td>
                        @if(($m['status'] ?? 'pending') !== 'approved')
                        <form method="POST" action="/admin/membership/approve/{{ $m['id'] }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary btn-confirm-swal flex-center" 
                                    style="padding: 0.3rem 0.6rem; font-size: 0.8rem; background: #10b981; border: none; color: #fff; border-radius: 4px; cursor: pointer;"
                                    data-message="Setujui Member Premium?" 
                                    data-text="Akun premium membership untuk sdr. {{ $m['nama'] }} akan langsung diaktifkan sepenuhnya."
                                    data-btn-text="Ya, Setujui!">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Setujui
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
                    <td>{!! $u['membership'] ? '<span class="badge badge-success flex-center"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> '.$u['membership'].'</span>' : '—' !!}</td>
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
        const confirmButtons = document.querySelectorAll('.btn-confirm-swal');

        confirmButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); 
                
                const form = this.closest('form');
                const titleMessage = this.getAttribute('data-message') || 'Apakah Anda yakin?';
                const textMessage = this.getAttribute('data-text') || 'Pastikan kembali tindakan Anda.';
                const confirmBtnText = this.getAttribute('data-btn-text') || 'Ya, Lanjutkan';

                Swal.fire({
                    title: titleMessage,
                    text: textMessage,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981', 
                    cancelButtonColor: '#6b7280',  
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: '#ffffff',
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Sedang menyimpan perubahan status ke database.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit(); 
                    }
                });
            });
        });
    });
</script>
</body>
</html>