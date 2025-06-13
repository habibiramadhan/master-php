{{-- resources/views/public/partials/hero.blade.php --}}
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <div class="text-center text-lg-start">
                    <h1 class="display-4 fw-bold mb-4">
                        Sewa <span class="text-warning">Alat Berat</span>
                    </h1>
                    <p class="lead mb-4 opacity-75">
                        Dapatkan peralatan konstruksi terbaik untuk proyek Anda dengan harga kompetitif.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('peralatan.index') }}" class="btn btn-construction btn-lg px-4">
                            <i class="bi bi-truck me-2"></i>Lihat Peralatan
                        </a>
                        <a href="{{ route('booking.form') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-calendar-check me-2"></i>Booking
                        </a>
                    </div>
                    
                    <div class="row text-center mt-4">
                        <div class="col-6">
                            <div class="stats-number">50+</div>
                            <small class="text-warning">Unit Tersedia</small>
                        </div>
                        <div class="col-6">
                            <div class="stats-number">24/7</div>
                            <small class="text-warning">Support</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Alat Berat" 
                         class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </div>
</section>