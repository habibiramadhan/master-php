{{-- resources/views/public/partials/stats.blade.php --}}
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="mb-3">
                    <i class="bi bi-truck fs-1 text-warning"></i>
                </div>
                <div class="stats-number">50+</div>
                <h6 class="text-warning">Unit Peralatan</h6>
                <p class="text-light opacity-75 small">
                    Berbagai jenis alat berat siap melayani proyek Anda
                </p>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="mb-3">
                    <i class="bi bi-people fs-1 text-warning"></i>
                </div>
                <div class="stats-number">500+</div>
                <h6 class="text-warning">Client Puas</h6>
                <p class="text-light opacity-75 small">
                    Kepercayaan dari berbagai perusahaan konstruksi
                </p>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="mb-3">
                    <i class="bi bi-building fs-1 text-warning"></i>
                </div>
                <div class="stats-number">1000+</div>
                <h6 class="text-warning">Proyek Selesai</h6>
                <p class="text-light opacity-75 small">
                    Track record proyek yang telah berhasil diselesaikan
                </p>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="mb-3">
                    <i class="bi bi-calendar-check fs-1 text-warning"></i>
                </div>
                <div class="stats-number">5+</div>
                <h6 class="text-warning">Tahun Pengalaman</h6>
                <p class="text-light opacity-75 small">
                    Pengalaman melayani industri konstruksi Indonesia
                </p>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="text-center">
                    <h4 class="text-warning mb-3">Area Layanan Kami</h4>
                    <p class="text-light opacity-75">
                        {{ $pengaturan['area_layanan'] ?? 'Jakarta, Bogor, Depok, Tangerang, Bekasi, dan sekitarnya' }}
                    </p>
                    <div class="row g-3 mt-4">
                        @php
                            $areas = explode(',', $pengaturan['area_layanan'] ?? 'Jakarta, Bogor, Depok, Tangerang, Bekasi');
                        @endphp
                        @foreach(array_slice($areas, 0, 5) as $area)
                            <div class="col-auto">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-geo-alt me-1"></i>{{ trim($area) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>