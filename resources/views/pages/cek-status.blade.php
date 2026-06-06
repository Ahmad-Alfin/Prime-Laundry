{{-- resources/views/pages/cek-status.blade.php ── Optimized Version --}}
@extends('layouts.app')
@section('title', 'Cek Status Laundry — Prime Laundry')
@section('content')

<div style="background: var(--blue); padding: 3rem 2rem; box-shadow: inset 0 -10px 20px rgba(0,0,0,0.02);">
    <div style="max-width: 600px; margin: 0 auto; text-align: center;">
        <h2 style="color: #fff; font-weight: 800; font-size: 2rem; letter-spacing: -0.02em; margin-bottom: 1.25rem;">Cek Status Laundry</h2>
        <form method="POST" action="{{ route('cek-status.search') }}">
            @csrf
            <input type="text" name="code" class="input" placeholder="Masukkan Kode Laundry (contoh: PL-001)"
                   value="{{ old('code', $searchCode ?? '') }}" style="text-align: center; margin-bottom: 0.85rem; padding: 14px; border-radius: 10px; font-weight: 600;">
            <button type="submit" class="btn btn-dark btn-block" style="padding: 14px; border-radius: 10px; font-weight: 700;">Cari Pesanan</button>
        </form>
    </div>
</div>

<section class="section">
    {{-- Alert Section dengan Custom SVG Icon --}}
    @if(isset($result))
        @if($result)
            <div class="alert-success" style="display: flex; align-items: center; gap: 8px; margin: 0 0 2rem 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>
                    Ditemukan: <strong>{{ $result['customer'] }}</strong> — {{ $result['service'] }} — 
                    <span class="badge badge-{{ $result['status']==='Completed'?'success':'warning' }}">{{ $result['status'] }}</span>
                </span>
            </div>
        @else
            <div class="alert-error" style="display: flex; align-items: center; gap: 8px; margin: 0 0 2rem 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>Kode laundry tidak ditemukan. Silakan periksa kembali.</span>
            </div>
        @endif
    @endif

    <h2 style="font-weight: 800; font-size: 1.5rem; letter-spacing: -0.01em; margin-bottom: 1.5rem; color: var(--text)">Active Orders</h2>

    @foreach([['Hari Ini', $today ?? []], ['Minggu Lalu', $lastWeek ?? []]] as [$label, $list])
    <h3 style="color: var(--gray); font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.85rem; margin-top: 1.5rem;">{{ $label }}</h3>
    
    @forelse($list as $o)
    <div class="order-card" style="padding: 1rem 1.5rem; border-radius: 14px; transition: all 0.2s ease;">
        <div style="display: flex; align-items: center; gap: 1rem">
            {{-- Icon Keranjang Laundry SVG menggantikan emoji keranjang --}}
            <div class="order-avatar" style="margin-right: 0; flex-shrink: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8H3l1.12 10.06a2 2 0 0 0 2 1.94h11.76a2 2 0 0 0 2-1.94L21 8Z"></path><path d="M16 8V5a3 3 0 0 0-6 0v3"></path><path d="M12 12v4"></path><path d="M8 12v4"></path><path d="M16 12v4"></path></svg>
            </div>
            <div>
                <p style="font-weight: 700; color: var(--text); font-size: 0.95rem; margin-bottom: 2px;">Order No: {{ $o['id'] ?? '#' }}</p>
                <p style="font-size: 0.85rem; color: var(--gray); display: flex; align-items: center; gap: 6px;">
                    {{ $o['service'] }}
                    <span style="display: inline-block; width: 3px; height: 3px; background: var(--gray); border-radius: 50%;"></span>
                    <span class="badge badge-{{ ($o['status']??'')==='Completed'?'success':'warning' }}">{{ $o['status'] ?? '-' }}</span>
                </p>
            </div>
        </div>
        <div style="text-align: right">
            <p style="font-size: 0.8rem; color: var(--gray); font-weight: 500; margin-bottom: 0.5rem;">{{ $o['date'] ?? $o['created_at'] ?? '' }}</p>
            <button class="btn btn-primary btn-sm" style="border-radius: 6px; font-weight: 600;" onclick="openDetail({{ json_encode($o) }})">Detail</button>
        </div>
    </div>
    @empty
        <p style="color: var(--gray); font-size: 0.9rem; margin-bottom: 1rem; italic; padding-left: 4px;">Tidak ada riwayat order pada periode ini.</p>
    @endforelse
    @endforeach
</section>

{{-- Detail Modal ── Tetap mempertahankan struktur CSS global --}}
<div id="detail-modal" class="modal-overlay hidden" onclick="this.classList.add('hidden')">
    <div class="modal-box" onclick="event.stopPropagation()" id="detail-content" style="border-radius: 20px; padding: 2.25rem 2rem;"></div>
</div>

@endsection
@push('scripts')
<script>
function openDetail(order) {
    const fields = [
        ['Kode Pesanan', order.code], 
        ['Nama Customer', order.customer], 
        ['Jenis Layanan', order.service],
        ['Status Proses', order.status], 
        ['Tanggal Masuk', order.date || order.created_at], 
        ['No. Telepon', order.phone], 
        ['Alamat Kirim', order.address]
    ];
    
    let html = `<h2 style="color: var(--blue); font-weight: 800; font-size: 1.35rem; letter-spacing: -0.01em; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        Detail Rincian Pesanan
    </h2>`;
    
    fields.forEach(([k,v]) => {
        html += `<div style="display: flex; justify-content: space-between; padding: 11px 0; border-bottom: 1px solid var(--gray-lt)">
            <span style="color: var(--gray); font-weight: 500; font-size: 0.9rem;">${k}</span>
            <span style="font-weight: 700; color: var(--text); font-size: 0.95rem;">${v || '—'}</span>
        </div>`;
    });
    
    html += '<button class="btn btn-primary btn-block" style="margin-top: 1.75rem; padding: 12px; border-radius: 10px; font-weight: 700;" onclick="document.getElementById(\'detail-modal\').classList.add(\'hidden\')">Tutup Jendela</button>';
    
    document.getElementById('detail-content').innerHTML = html;
    document.getElementById('detail-modal').classList.remove('hidden');
}
</script>
@endpush