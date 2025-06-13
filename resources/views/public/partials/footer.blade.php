{{-- resources/views/public/partials/footer.blade.php --}}
<footer class="footer-construction mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-3">
                    @if(!empty($pengaturan['logo_perusahaan']))
                        <img src="{{ asset('storage/' . $pengaturan['logo_perusahaan']) }}" 
                             alt="Logo" 
                             height="40" 
                             class="me-2">
                    @else
                        <i class="bi bi-truck fs-3 text-warning me-2"></i>
                    @endif
                    <h5 class="text-warning mb-0">{{ $pengaturan['nama_perusahaan'] ?? 'CV Sewa Alat Berat' }}</h5>
                </div>
                <p class="text-light opacity-75">
                    {{ $pengaturan['tentang_kami'] ?? 'Penyedia layanan sewa alat berat terpercaya dengan pengalaman bertahun-tahun melayani proyek konstruksi di seluruh Indonesia.' }}
                </p>
                <div class="d-flex gap-2">
                    @if(!empty($pengaturan['facebook']))
                        <a href="{{ $pengaturan['facebook'] }}" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if(!empty($pengaturan['instagram']))
                        <a href="{{ $pengaturan['instagram'] }}" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                       class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3">
                <h6 class="text-warning mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Kontak Kami
                </h6>
                <div class="text-light opacity-75">
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2 text-warning"></i>
                        {{ $pengaturan['email_perusahaan'] ?? 'info@sewaalatberat.com' }}
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-telephone me-2 text-warning"></i>
                        {{ $pengaturan['telepon_perusahaan'] ?? '021-123456789' }}
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-whatsapp me-2 text-warning"></i>
                        {{ $pengaturan['whatsapp_perusahaan'] ?? '+62 812-3456-789' }}
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-pin-map me-2 text-warning"></i>
                        {{ $pengaturan['alamat_perusahaan'] ?? 'Jakarta, Indonesia' }}
                    </p>
                </div>
            </div>
            
            <div class="col-lg-2">
                <h6 class="text-warning mb-3">
                    <i class="bi bi-link-45deg me-2"></i>Menu
                </h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-light opacity-75 text-decoration-none">Beranda</a></li>
                    <li><a href="{{ route('peralatan.index') }}" class="text-light opacity-75 text-decoration-none">Peralatan</a></li>
                    <li><a href="{{ route('booking.form') }}" class="text-light opacity-75 text-decoration-none">Booking</a></li>
                    <li><a href="{{ route('track.form') }}" class="text-light opacity-75 text-decoration-none">Tracking</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3">
                <h6 class="text-warning mb-3">
                    <i class="bi bi-credit-card me-2"></i>Pembayaran
                </h6>
                <div class="bg-dark bg-opacity-50 p-3 rounded">
                    <p class="text-warning fw-semibold mb-2">Transfer Bank</p>
                    <p class="text-light mb-1 small">{{ $pengaturan['nama_bank'] ?? 'Bank BCA' }}</p>
                    <p class="text-light mb-1 small">{{ $pengaturan['nomor_rekening'] ?? '1234567890' }}</p>
                    <p class="text-light mb-0 small">a.n {{ $pengaturan['nama_rekening'] ?? 'CV Sewa Alat Berat' }}</p>
                </div>
                @if(!empty($pengaturan['area_layanan']))
                    <div class="mt-3">
                        <p class="text-warning fw-semibold mb-2">
                            <i class="bi bi-geo me-2"></i>Area Layanan
                        </p>
                        <p class="text-light opacity-75 small">{{ $pengaturan['area_layanan'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="border-top border-secondary">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light opacity-50 mb-0 small">
                        © {{ date('Y') }} {{ $pengaturan['nama_perusahaan'] ?? 'CV Sewa Alat Berat' }}. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-light opacity-50 mb-0 small">
                        Powered by Laravel | 
                        <a href="{{ route('login') }}" class="text-warning text-decoration-none">Admin Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>