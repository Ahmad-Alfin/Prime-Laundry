{{-- resources/views/pages/syarat.blade.php --}}
@extends('layouts.app')
@section('title', 'Syarat & Ketentuan — Prime Laundry')
@section('content')

<div class="hero-section">
    <h1 style="color:#fff; font-size:1.75rem; font-weight:900">Syarat Dan Ketentuan Prime Laundry</h1>
</div>

<section class="section">
    <div style="display:flex; justify-content:center; gap:1rem; margin-bottom:2rem">
        <button class="btn btn-primary" id="tab-order" onclick="switchTab('order')">Informasi Order</button>
        <button class="btn btn-outline" id="tab-kiloan" onclick="switchTab('kiloan')">Laundry Kiloan</button>
    </div>

    <ol id="rules-order" style="padding-left:1.25rem; line-height:2.2">
        @foreach([
            "Seluruh pelayanan dan transaksi di Prime Laundry dilakukan berdasarkan sistem antrian. Cucian akan diproses setelah pelanggan melakukan pembayaran secara penuh (full payment).",
            "Minimal berat cucian adalah 3 kg. Di Prime Laundry, cucian pelanggan tidak dicampur dengan pelanggan lain (1 mesin cuci untuk 1 customer).",
            "Layanan pickup dan delivery dilakukan melalui mitra pengiriman. Pelanggan diwajibkan membungkus cucian dengan rapi sebelum diserahkan kepada driver.",
            "Pemesanan layanan Express yang dilakukan setelah pukul 13.00 WIB akan selesai pada hari berikutnya.",
            "Prime Laundry tidak bertanggung jawab atas kerusakan pakaian yang disebabkan oleh kondisi awal barang.",
            "Apabila terjadi perbedaan jumlah pakaian, maka data jumlah item yang tercatat pada nota atau sistem Prime Laundry dianggap benar.",
            "Cucian yang tidak diambil lebih dari 7 hari setelah selesai berada di luar tanggung jawab Prime Laundry.",
            "Ganti rugi kehilangan atau kerusakan diberikan maksimal sebesar Rp20.000 per pcs dengan total maksimal Rp100.000 untuk layanan laundry kiloan.",
            "Klaim komplain hanya berlaku maksimal 24 jam setelah cucian diterima pelanggan atau maksimal 7 hari sejak cucian masuk.",
            "Prime Laundry akan memberikan kompensasi sebesar Rp100.000 apabila pelanggan tidak menerima struk atau nota resmi.",
            "Prime Laundry tidak menerima cucian yang mengandung kotoran berbahaya, darah, muntahan, atau bulu hewan berlebihan.",
            "Dengan menyerahkan cucian kepada Prime Laundry, pelanggan dianggap telah menyetujui seluruh syarat dan ketentuan.",
        ] as $rule)
        <li style="margin-bottom:.5rem">{{ $rule }}</li>
        @endforeach
    </ol>

    <ol id="rules-kiloan" style="padding-left:1.25rem; line-height:2.2; display:none">
        @foreach([
            "Layanan kiloan dihitung berdasarkan berat total cucian (minimum 3 kg).",
            "Harga kiloan berlaku per kilogram sesuai daftar tarif yang berlaku.",
            "Paket kiloan mencakup: cuci, bilas, spin, dan lipat.",
            "Tidak termasuk setrika kecuali untuk paket Cuci Kering Gosok.",
            "Pelanggan wajib memisahkan cucian putih dan berwarna sebelum diserahkan.",
            "Prime Laundry berhak menolak cucian yang kondisinya terlalu kotor atau berbahaya.",
            "Estimasi selesai mengikuti antrian operasional dan jenis layanan yang dipilih.",
        ] as $rule)
        <li style="margin-bottom:.5rem">{{ $rule }}</li>
        @endforeach
    </ol>
</section>

@endsection
@push('scripts')
<script>
function switchTab(tab) {
    document.getElementById('rules-order').style.display  = tab==='order'  ? 'block' : 'none';
    document.getElementById('rules-kiloan').style.display = tab==='kiloan' ? 'block' : 'none';
    document.getElementById('tab-order').className  = 'btn ' + (tab==='order'  ? 'btn-primary' : 'btn-outline');
    document.getElementById('tab-kiloan').className = 'btn ' + (tab==='kiloan' ? 'btn-primary' : 'btn-outline');
}
</script>
@endpush
