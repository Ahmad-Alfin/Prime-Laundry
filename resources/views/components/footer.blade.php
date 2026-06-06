{{-- resources/views/components/footer.blade.php --}}
<footer class="footer">
    <div class="footer-grid">
        <div>
            <div class="footer-logo">
                 <img src="{{ asset('images/Group 26.png') }}" alt="Logo Prime Laundry" width="40" height="40" style="object-fit: contain;">
                <span>Prime Laundry</span>
            </div>
            <p class="footer-desc">PRIME LAUNDRY merupakan usaha laundry yang berada di kawasan Dau, Kabupaten Malang, tepatnya di sekitar area Mulyoagung yang dekat dengan lingkungan kampus dan kos mahasiswa.</p>
            <div class="footer-socials">
                {{-- Menggunakan logo platform dari Remix Icon --}}
                <a href="https://google.com"   target="_blank" class="social-btn" aria-label="Google">
                    <i class="ri-google-fill"></i>
                </a>
                <a href="https://facebook.com" target="_blank" class="social-btn" aria-label="Facebook">
                    <i class="ri-facebook-fill"></i>
                </a>
                <a href="https://twitter.com"  target="_blank" class="social-btn" aria-label="Twitter">
                    <i class="ri-twitter-x-line"></i>
                </a>
                <a href="https://apple.com"    target="_blank" class="social-btn" aria-label="Apple">
                    <i class="ri-apple-fill"></i>
                </a>
            </div>
        </div>

        <div>
            <p class="footer-heading">Menu</p>
            @foreach(['beranda' => 'Beranda', 'harga' => 'Harga', 'cek-status' => 'Cek Status', 'syarat' => 'Syarat Ketentuan', 'kontak' => 'Kontak'] as $route => $label)
                <a href="{{ route($route) }}" class="footer-link">{{ $label }}</a>
            @endforeach
        </div>

        <div>
            <p class="footer-heading">Kontak</p>
            {{-- Mengganti emoji dengan Remix Icon dan memberikan jarak margin-right --}}
            <p class="footer-contact"><i class="ri-whatsapp-line" style="margin-right: 8px;"></i> 0895621112467</p>
            <p class="footer-contact"><i class="ri-whatsapp-line" style="margin-right: 8px;"></i> 085895440744</p>
            <p class="footer-contact"><i class="ri-mail-line" style="margin-right: 8px;"></i> PrimeLaundry@gmail.com</p>
            <p class="footer-contact" style="display: flex; align-items: flex-start;">
                <i class="ri-map-pin-line" style="margin-right: 8px; margin-top: 3px;"></i> 
                <span>Jl Margo Basuki Gg 1, Jetis,<br>Mulyoagung, Kec. Dau, Kab. Malang</span>
            </p>
        </div>
    </div>

    <div class="footer-copy">
        Copyright © Prime Laundry 2026 | Managed by: Rangga dan Alfin
    </div>
</footer>