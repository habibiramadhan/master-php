{{-- resources/views/public/partials/featured-equipment.blade.php --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Peralatan Unggulan</h2>
            <p class="text-muted">Pilihan terbaik alat berat untuk berbagai kebutuhan proyek konstruksi</p>
        </div>
        
        @if($peralatan->count() > 0)
            <div class="row g-4">
                @foreach($peralatan as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card equipment-card h-100">
                            <div class="position-relative">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                                         alt="{{ $item->nama }}" 
                                         class="card-img-top"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="bi bi-truck fs-1 text-white"></i>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success">Tersedia</span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $item->nama }}</h5>
                                    <span class="badge bg-warning text-dark">{{ $item->kategori }}</span>
                                </div>
                                
                                @if($item->deskripsi)
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($item->deskripsi, 80) }}
                                    </p>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="h5 text-warning fw-bold">{{ $item->harga_format }}</span>
                                        <small class="text-muted">/hari</small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('peralatan.detail', $item->id) }}" 
                                           class="btn btn-outline-dark">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('booking.form') }}?peralatan={{ $item->id }}" 
                                           class="btn btn-construction">
                                            <i class="bi bi-calendar-check"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('peralatan.index') }}" class="btn btn-construction btn-lg">
                    <i class="bi bi-grid me-2"></i>Lihat Semua Peralatan
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-truck fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Peralatan Sedang Tidak Tersedia</h5>
                <p class="text-muted">Silakan hubungi kami untuk informasi lebih lanjut</p>
                <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                   class="btn btn-construction">
                    <i class="bi bi-whatsapp me-2"></i>Hubungi WhatsApp
                </a>
            </div>
        @endif
    </div>
</section>