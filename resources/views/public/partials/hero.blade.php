{{-- resources/views/public/partials/hero.blade.php --}}
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <div class="text-center text-lg-start">
                    <h1 class="display-4 fw-bold mb-4">
                        Sewa <span class="text-warning">Alat Berat</span><br>
                        Terpercaya & Berkualitas
                    </h1>
                    <p class="lead mb-4 opacity-75">
                        Dapatkan peralatan konstruksi terbaik untuk proyek Anda. 
                        Kami menyediakan berbagai jenis alat berat dengan kondisi prima 
                        dan harga kompetitif.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('peralatan.index') }}" class="btn btn-construction btn-lg px-4">
                            <i class="bi bi-truck me-2"></i>Lihat Peralatan
                        </a>
                        <a href="{{ route('booking.form') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-calendar-check me-2"></i>Booking Sekarang
                        </a>
                    </div>
                    
                    <div class="row text-center mt-5">
                        <div class="col-4">
                            <div class="stats-number">50+</div>
                            <small class="text-warning">Unit Tersedia</small>
                        </div>
                        <div class="col-4">
                            <div class="stats-number">24/7</div>
                            <small class="text-warning">Support</small>
                        </div>
                        <div class="col-4">
                            <div class="stats-number">100%</div>
                            <small class="text-warning">Terpercaya</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                             alt="Alat Berat" 
                             class="img-fluid rounded-3 shadow-lg"
                             style="filter: brightness(0.9);">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-warning opacity-10 rounded-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Cards -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-n3 d-none d-lg-block">
        <div class="row g-3">
            <div class="col">
                <div class="card bg-warning text-dark text-center p-3 border-0 shadow">
                    <i class="bi bi-shield-check fs-4 mb-2"></i>
                    <small class="fw-semibold">Asuransi</small>
                </div>
            </div>
            <div class="col">
                <div class="card bg-white text-dark text-center p-3 border-0 shadow">
                    <i class="bi bi-tools fs-4 mb-2 text-warning"></i>
                    <small class="fw-semibold">Maintenance</small>
                </div>
            </div>
            <div class="col">
                <div class="card bg-warning text-dark text-center p-3 border-0 shadow">
                    <i class="bi bi-truck fs-4 mb-2"></i>
                    <small class="fw-semibold">Antar Jemput</small>
                </div>
            </div>
        </div>
    </div>
</section>