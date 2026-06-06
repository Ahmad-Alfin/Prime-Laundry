{{-- resources/views/pages/beranda.blade.php --}}
@extends('layouts.app')
@section('title', 'Beranda — Prime Laundry')

{{-- Tambahkan sedikit CSS custom untuk merapikan tampilan icon baru --}}
@push('styles')
<style>
    /* Memastikan icon di service card ukurannya pas dan warnanya selaras */
    .services-grid .service-icon i {
        font-size: 3rem; /* Ukuran icon layanan */
        color: var(--blue); /* Warna biru utama sesuai CSS Anda */
        display: block;
        line-height: 1;
    }

    /* Styling icon van di tombol pickup */
    .btn i {
        margin-right: 8px;
        font-size: 1.1em;
        vertical-align: -2px;
    }

    /* Styling icon besar di modal login prompt */
    .login-prompt .prompt-icon i {
        font-size: 4rem;
        color: var(--gray);
        opacity: 0.5;
        display: block;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')

{{-- ── Hero Section ──────────────────────────────────────────────────── --}}
<section class="hero-section" style="padding: 4rem 0;">
    {{-- Menambahkan Flexbox agar teks dan ikon berjejer kiri-kanan --}}
    <div class="hero-inner" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
        
        {{-- Kolom Kiri: Teks dan Tombol --}}
        <div style="flex: 1; min-width: 300px;">
            <h1 class="hero-title">Perawatan Premium<br>untuk Pakaian Anda</h1>
            <p class="hero-sub" style="margin-bottom: 1.5rem;">Layanan laundry terpercaya di Malang</p>
            <button class="btn btn-primary btn-lg" onclick="openPickupModal()">
                <i class="ri-truck-fill"></i> Pickup Now
            </button>
        </div>

        {{-- Kolom Kanan: Ikon Hero Besar --}}
        <div class="hero-icon" style="flex: 1; display: flex; justify-content: center; align-items: center; color: #00b0ff;">
            {{-- Menggunakan ikon mesin cuci dengan ukuran yang jauh lebih besar (15rem) agar proporsional --}}
            <i class="ri-washing-machine-line" style="font-size: 15rem; opacity: 0.9;"></i>
        </div>

    </div>
</section>

{{-- ── Layanan Grid ───────────────────────────────────────────────────── --}}
<section class="section">
    <h2 class="section-title">Layanan Prime Laundry</h2>
    <div class="services-grid">
        @foreach([
            // Pembacaan array diubah untuk menampung class icon
            ['name'=>'Daily Kiloan',      'icon'=>'ri-handbag-line'],    // Tas belanja/laundry bag
            ['name'=>'Cuci dan Setrika',  'icon'=>'ri-t-shirt-2-line'],  // Kaos rapi
            ['name'=>'Dry Cleaning',      'icon'=>'ri-shirt-line'],      // Kemeja formal
            ['name'=>'Setrika',           'icon'=>'ri-ink-bottle-line'], // Representasi uap/cairan setrika (Remix tidak punya icon setrika spesifik yang bagus di versi free, ini alternatif visual yang bersih, atau bisa gunakan ri-pantis-line untuk pakaian halus)
            ['name'=>'Green Dry Cleaning','icon'=>'ri-leaf-line'],       // Daun untuk ramah lingkungan
            ['name'=>'Laundry Sepatu',    'icon'=>'ri-footprint-line'], // Jejak kaki/sepatu
            ['name'=>'Laundry Tas',       'icon'=>'ri-luggage-cart-line'],// Koper/Tas
            ['name'=>'Laundry Karpet',    'icon'=>'ri-home-gear-line'],  // Item rumah tangga
            ['name'=>'Laundry Gorden',    'icon'=>'ri-layout-grid-line'], // Representasi tekstur/kotak gorden
        ] as $s)
        <div class="service-card" onclick="openPickupModal('{{ $s['name'] }}')">
            {{-- Render Icon SVG Line Art --}}
            <div class="service-icon"><i class="{{ $s['icon'] }}"></i></div>
            <p class="service-name">{{ $s['name'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── About Section ──────────────────────────────────────────────────── --}}
<section class="about-section">
    <div class="about-inner">
        <div class="about-visual">
            {{-- Ganti Emoji 🧺 dengan Icon keranjang belanja/pakaian modern --}}
            <div style="font-size:3.5rem; margin-bottom:.5rem">
                <i class="ri-shopping-basket-2-line"></i>
            </div>
            Wash, Fold, Deliver
        </div>
        <div class="about-text">
            <p>PRIME LAUNDRY merupakan usaha laundry yang berada di kawasan Dau, Kabupaten Malang, tepatnya di sekitar area Mulyoagung yang dekat dengan lingkungan kampus dan kos mahasiswa.</p>
            <a href="{{ route('kontak') }}" class="btn btn-primary" style="margin-top:1rem; display:inline-block">
                Gak ada waktu buat cuci baju? Prime Laundry hadir memenuhi kebutuhan anda →
            </a>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════════════════════
     PICKUP MODAL — Pilih Layanan, Item, Jumlah, Kecepatan → Total Harga
     ══════════════════════════════════════════════════════════════════════ --}}
<div id="pickup-modal" class="modal-overlay hidden" onclick="closePickupModal(event)">
  <div class="modal-box modal-xl" onclick="event.stopPropagation()">
    <div class="modal-header">
        {{-- Ganti Emoji 🚐 dengan Icon Van Truck --}}
        <h2 class="modal-title"><i class="ri-truck-line" style="margin-right:10px; color:var(--blue)"></i>Pickup & Order</h2>
        <button class="modal-close" onclick="closePickupModal()">✕</button>
    </div>

    @auth
    {{-- ... content form auth tidak berubah ... --}}
    <form method="POST" action="{{ route('pickup.store') }}" id="pickup-form">
        @csrf

        {{-- Step 1: Info Pelanggan --}}
        <div class="pickup-step" id="step-1">
            <h3 class="step-title">Langkah 1 — Informasi Pickup</h3>
            <div class="form-grid-3">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="input" placeholder="Nama" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label>Nomor WhatsApp *</label>
                    <input type="text" name="whatsapp" class="input" placeholder="08xxxx" value="{{ auth()->user()->phone ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label>Alamat Pickup *</label>
                    <input type="text" name="alamat" class="input" placeholder="Jl. ..." value="{{ auth()->user()->address ?? '' }}" required>
                </div>
            </div>
            <div class="form-grid-3" style="margin-top:.75rem">
                <div class="form-group">
                    <label>Kategori Layanan *</label>
                    <select name="service" id="service-select" class="input" onchange="loadServiceItems(this.value)" required>
                        @foreach(array_keys($serviceItems) as $svc)
                            <option value="{{ $svc }}">{{ $svc }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Pickup *</label>
                    <input type="date" name="tanggal" class="input" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Jam Pickup *</label>
                    <input type="time" name="jam" class="input" required>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-block" style="margin-top:1rem" onclick="goStep(2)">
                Lanjut Pilih Item →
            </button>
        </div>

        {{-- Step 2: Pilih Item & Jumlah --}}
        <div class="pickup-step hidden" id="step-2">
            <h3 class="step-title">Langkah 2 — Pilih Item & Jumlah</h3>

            <div class="speed-tabs">
                @foreach(['regular'=>'Regular','one_day'=>'One Day (+3rb)','express'=>'Express (+6rb)','quick'=>'Quick (+10rb)'] as $key=>$label)
                <button type="button" class="speed-tab {{ $key==='regular'?'active':'' }}"
                        data-speed="{{ $key }}" onclick="setSpeed('{{ $key }}')">{{ $label }}</button>
                @endforeach
            </div>
            <input type="hidden" name="speed_mode" id="speed-mode" value="regular">

            <div id="items-table-wrap" class="items-wrap"></div>

            <div class="summary-bar">
                <span>Total Estimasi:</span>
                <strong id="total-display">Rp 0</strong>
            </div>

            {{-- Hidden inputs untuk items dan total --}}
            <div id="hidden-items"></div>
            <input type="hidden" name="total" id="total-input" value="0">

            <div style="display:flex; gap:.75rem; margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="goStep(1)">← Kembali</button>
                <button type="button" class="btn btn-primary flex-1" onclick="goStep(3)">Lanjut Review →</button>
            </div>
        </div>

        {{-- Step 3: Review & Konfirmasi --}}
        <div class="pickup-step hidden" id="step-3">
            <h3 class="step-title">Langkah 3 — Review Pesanan</h3>
            <div id="review-content" class="review-box"></div>
            <div class="total-final">
                <span>Total Pembayaran:</span>
                <strong id="total-final-display">Rp 0</strong>
            </div>
            <p class="info-note">
                💡 Setelah submit, Anda akan diarahkan ke halaman pembayaran QRIS.
                Pesanan diproses setelah pembayaran terkonfirmasi oleh admin.
            </p>
            <div style="display:flex; gap:.75rem; margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="goStep(2)">← Kembali</button>
                <button type="submit" class="btn btn-primary flex-1">
                    ✅ Konfirmasi & Bayar
                </button>
            </div>
        </div>

    </form>
    @else
    {{-- Belum login --}}
    <div class="login-prompt">
        {{-- Ganti Emoji 🔐 dengan Icon Lock Line Art yang besar --}}
        <div class="prompt-icon">
            <i class="ri-lock-password-line"></i>
        </div>
        <h3>Login untuk melakukan pickup</h3>
        <p>Anda perlu login terlebih dahulu untuk memesan layanan laundry.</p>
        <a href="{{ route('login') }}" class="btn btn-primary" style="margin-top:1rem">Login Sekarang</a>
    </div>
    @endauth
  </div>
</div>

@endsection

{{-- Bagian Scripts tidak ada perubahan, tetap berfungsi sama --}}
@push('scripts')
<script>
// ─── Data Harga dari PHP (dikirim ke JS) ─────────────────────────────────
const SERVICE_ITEMS = @json($serviceItems);
const SPEED_LABELS  = { regular:'Regular', one_day:'One Day', express:'Express', quick:'Quick' };

let currentSpeed = 'regular';
let quantities   = {};   // { itemIndex: qty }

// ─── Buka / Tutup Modal ──────────────────────────────────────────────────
function openPickupModal(service = null) {
    if (service) {
        document.getElementById('service-select').value = service;
    }
    document.getElementById('pickup-modal').classList.remove('hidden');
    loadServiceItems(document.getElementById('service-select').value);
    goStep(1);
}
function closePickupModal(e) {
    if (!e || e.target.id === 'pickup-modal') {
        document.getElementById('pickup-modal').classList.add('hidden');
    }
}

// ─── Navigasi Step ────────────────────────────────────────────────────────
function goStep(n) {
    if (n === 3) {
        if (!buildHiddenInputs()) return; // validasi minimal 1 item
        buildReview();
    }
    document.querySelectorAll('.pickup-step').forEach((el,i) => {
        el.classList.toggle('hidden', i+1 !== n);
    });
}

// ─── Load Items Tabel ─────────────────────────────────────────────────────
function loadServiceItems(service) {
    const items = SERVICE_ITEMS[service] || [];
    quantities = {};
    renderItemsTable(items);
}

function renderItemsTable(items) {
    const speed = currentSpeed;
    let html = `<table class="price-table">
        <thead><tr>
            <th>Item</th>
            <th>Harga / ${speed.replace('_',' ')}</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr></thead><tbody>`;

    items.forEach((item, i) => {
        const price = item[speed] ?? item['regular'] ?? 0;
        const priceStr = price ? 'Rp' + price.toLocaleString('id-ID') : '—';
        const qty = quantities[i] || 0;
        html += `<tr>
            <td>${item.item}<br><small style="color:#6b7280">${item.unit}</small></td>
            <td class="price-cell">${priceStr}</td>
            <td>
                <div class="qty-control">
                    <button type="button" onclick="changeQty(${i}, -1)">−</button>
                    <span id="qty-${i}">${qty}</span>
                    <button type="button" onclick="changeQty(${i}, 1)">+</button>
                </div>
            </td>
            <td id="sub-${i}" class="price-cell">${qty > 0 ? 'Rp'+(price*qty).toLocaleString('id-ID') : '—'}</td>
        </tr>`;
    });
    html += `</tbody></table>`;
    document.getElementById('items-table-wrap').innerHTML = html;
    updateTotal();
}

function changeQty(idx, delta) {
    const service = document.getElementById('service-select').value;
    const items   = SERVICE_ITEMS[service] || [];
    const item    = items[idx];
    const price   = item[currentSpeed] ?? item['regular'] ?? 0;

    quantities[idx] = Math.max(0, (quantities[idx] || 0) + delta);
    document.getElementById('qty-'+idx).textContent = quantities[idx];
    const sub = quantities[idx] * price;
    document.getElementById('sub-'+idx).textContent = quantities[idx] > 0 ? 'Rp'+sub.toLocaleString('id-ID') : '—';
    updateTotal();
}

function updateTotal() {
    const service = document.getElementById('service-select').value;
    const items   = SERVICE_ITEMS[service] || [];
    let total = 0;
    items.forEach((item, i) => {
        const price = item[currentSpeed] ?? item['regular'] ?? 0;
        total += (quantities[i] || 0) * price;
    });
    document.getElementById('total-display').textContent = 'Rp' + total.toLocaleString('id-ID');
    document.getElementById('total-final-display').textContent = 'Rp' + total.toLocaleString('id-ID');
    document.getElementById('total-input').value = total;
}

function setSpeed(speed) {
    currentSpeed = speed;
    document.getElementById('speed-mode').value = speed;
    document.querySelectorAll('.speed-tab').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.speed === speed);
    });
    const service = document.getElementById('service-select').value;
    loadServiceItems(service);
    // Pertahankan quantities
    const items = SERVICE_ITEMS[service] || [];
    renderItemsTable(items);
}

// ─── Build Hidden Inputs untuk Form Submit ────────────────────────────────
function buildHiddenInputs() {
    const service = document.getElementById('service-select').value;
    const items   = SERVICE_ITEMS[service] || [];
    const wrap    = document.getElementById('hidden-items');
    wrap.innerHTML = '';

    let hasItem = false;
    items.forEach((item, i) => {
        if ((quantities[i] || 0) < 1) return;
        hasItem = true;
        const price = item[currentSpeed] ?? item['regular'] ?? 0;
        wrap.innerHTML += `
            <input type="hidden" name="items[${i}][item]"  value="${item.item}">
            <input type="hidden" name="items[${i}][speed]" value="${currentSpeed}">
            <input type="hidden" name="items[${i}][qty]"   value="${quantities[i]}">
            <input type="hidden" name="items[${i}][price]" value="${price}">
        `;
    });
    if (!hasItem) {
        alert('Pilih minimal 1 item terlebih dahulu!');
        return false;
    }
    return true;
}

// ─── Review Pesanan ───────────────────────────────────────────────────────
function buildReview() {
    const service = document.getElementById('service-select').value;
    const items   = SERVICE_ITEMS[service] || [];
    let html = `<table class="price-table"><thead><tr><th>Item</th><th>Kecepatan</th><th>Qty</th><th>Subtotal</th></tr></thead><tbody>`;
    items.forEach((item, i) => {
        if ((quantities[i] || 0) < 1) return;
        const price = item[currentSpeed] ?? item['regular'] ?? 0;
        html += `<tr>
            <td>${item.item}</td>
            <td>${SPEED_LABELS[currentSpeed]}</td>
            <td>${quantities[i]} ${item.unit}</td>
            <td>Rp${(price*quantities[i]).toLocaleString('id-ID')}</td>
        </tr>`;
    });
    html += `</tbody></table>`;
    document.getElementById('review-content').innerHTML = html;
}
</script>
@endpush