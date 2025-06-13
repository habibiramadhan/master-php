{{-- resources/views/public/peralatan/detail.blade.php --}}
<x-public-layout :title="$peralatan->nama" :pengaturan="$pengaturan">
    <section class="py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-warning">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('peralatan.index') }}" class="text-warning">Peralatan</a></li>
                    <li class="breadcrumb-item active">{{ $peralatan->nama }}</li>
                </ol>
            </nav>

            <div class="row g-4">
                <!-- Gambar Peralatan -->
                <div class="col-lg-6">
                    <div class="position-relative">
                        @if($peralatan->gambar)
                            <img src="{{ asset('storage/' . $peralatan->gambar) }}" 
                                 alt="{{ $peralatan->nama }}" 
                                 class="img-fluid w-100 rounded-3 shadow-sm"
                                 style="height: 400px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center rounded-3" 
                                 style="height: 400px;">
                                <i class="bi bi-truck fs-1 text-white"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success fs-6">Tersedia</span>
                        </div>
                        
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-warning text-dark fs-6">{{ $peralatan->kategori }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Peralatan -->
                <div class="col-lg-6">
                    <div class="h-100">
                        <h1 class="fw-bold mb-3">{{ $peralatan->nama }}</h1>
                        
                        <div class="mb-4">
                            <span class="h2 text-warning fw-bold">{{ $peralatan->harga_format }}</span>
                            <span class="text-muted fs-5">/hari</span>
                        </div>

                        @if($peralatan->deskripsi)
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-2">Deskripsi</h6>
                                <p class="text-muted">{{ $peralatan->deskripsi }}</p>
                            </div>
                        @endif

                        <!-- Spesifikasi -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Spesifikasi</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="text-muted small">Kategori</div>
                                        <div class="fw-semibold">{{ $peralatan->kategori }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="text-muted small">Status</div>
                                        <div class="fw-semibold text-success">{{ ucfirst($peralatan->status) }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="text-muted small">Harga per Hari</div>
                                        <div class="fw-semibold text-warning">{{ $peralatan->harga_format }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded">
                                        <div class="text-muted small">ID Peralatan</div>
                                        <div class="fw-semibold">#{{ str_pad($peralatan->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mb-4">
                            <a href="{{ route('booking.form') }}?peralatan={{ $peralatan->id }}" 
                               class="btn btn-construction btn-lg">
                                <i class="bi bi-calendar-check me-2"></i>Booking Sekarang
                            </a>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}?text=Halo, saya tertarik dengan {{ $peralatan->nama }}" 
                                       class="btn btn-outline-success w-100">
                                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="tel:{{ $pengaturan['telepon_perusahaan'] ?? '021123456789' }}" 
                                       class="btn btn-outline-primary w-100">
                                        <i class="bi bi-telephone me-1"></i>Telepon
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-check-circle text-warning me-2"></i>Yang Anda Dapatkan
                            </h6>
                            <ul class="list-unstyled mb-0 small">
                                <li><i class="bi bi-check text-success me-2"></i>Peralatan dalam kondisi prima</li>
                                <li><i class="bi bi-check text-success me-2"></i>Antar jemput gratis area Jabodetabek</li>
                                <li><i class="bi bi-check text-success me-2"></i>Operator berpengalaman (opsional)</li>
                                <li><i class="bi bi-check text-success me-2"></i>Support 24/7</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peralatan Sejenis -->
            @if($peralatanSejenis->count() > 0)
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="fw-bold mb-4">Peralatan Sejenis</h4>
                        <div class="row g-4">
                            @foreach($peralatanSejenis as $item)
                                <div class="col-lg-3 col-md-6">
                                    <div class="card equipment-card h-100">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                                 alt="{{ $item->nama }}" 
                                                 class="card-img-top"
                                                 style="height: 180px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="height: 180px;">
                                                <i class="bi bi-truck fs-2 text-white"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->nama }}</h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-warning fw-semibold">{{ $item->harga_format }}</span>
                                                <a href="{{ route('peralatan.detail', $item->id) }}" 
                                                   class="btn btn-outline-warning btn-sm">
                                                    Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-public-layout>