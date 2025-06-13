{{-- resources/views/public/partials/why-choose-us.blade.php --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Mengapa Pilih Kami?</h2>
            <p class="text-muted">Keunggulan yang membuat kami menjadi pilihan terbaik untuk proyek Anda</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center h-100">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-check fs-1 text-warning"></i>
                    </div>
                    <h5 class="fw-semibold">Peralatan Terawat</h5>
                    <p class="text-muted small">
                        Semua alat berat kami dalam kondisi prima dan rutin menjalani maintenance berkala
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center h-100">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-clock fs-1 text-warning"></i>
                    </div>
                    <h5 class="fw-semibold">Layanan 24/7</h5>
                    <p class="text-muted small">
                        Tim support kami siap membantu kapan saja, termasuk emergency breakdown service
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center h-100">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-currency-dollar fs-1 text-warning"></i>
                    </div>
                    <h5 class="fw-semibold">Harga Kompetitif</h5>
                    <p class="text-muted small">
                        Tarif sewa yang reasonable dengan kualitas terbaik. Nego friendly untuk proyek jangka panjang
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center h-100">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-truck fs-1 text-warning"></i>
                    </div>
                    <h5 class="fw-semibold">Antar Jemput</h5>
                    <p class="text-muted small">
                        Layanan delivery dan pickup gratis dalam area Jabodetabek. Operator berpengalaman tersedia
                    </p>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="bg-dark text-white p-4 rounded-3">
                    <h5 class="text-warning mb-3">
                        <i class="bi bi-award me-2"></i>Sertifikasi & Legalitas
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-check-circle text-warning me-2"></i>Izin usaha lengkap</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-warning me-2"></i>Asuransi peralatan</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-warning me-2"></i>Operator bersertifikat</li>
                        <li><i class="bi bi-check-circle text-warning me-2"></i>Safety compliance</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="bg-warning bg-opacity-10 p-4 rounded-3">
                    <h5 class="mb-3">
                        <i class="bi bi-headset me-2 text-warning"></i>Customer Support
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-telephone text-warning me-2"></i>Hotline: {{ $pengaturan['telepon_perusahaan'] ?? '021-123456789' }}</li>
                        <li class="mb-2"><i class="bi bi-whatsapp text-warning me-2"></i>WhatsApp: {{ $pengaturan['whatsapp_perusahaan'] ?? '+62 812-3456-789' }}</li>
                        <li class="mb-2"><i class="bi bi-envelope text-warning me-2"></i>Email: {{ $pengaturan['email_perusahaan'] ?? 'info@sewaalatberat.com' }}</li>
                        <li><i class="bi bi-chat-dots text-warning me-2"></i>Live chat tersedia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>