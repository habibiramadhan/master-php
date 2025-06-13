{{-- resources/views/public/peralatan/partials/equipment-grid.blade.php --}}
@if($peralatan->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">
                    Menampilkan {{ $peralatan->firstItem() }}-{{ $peralatan->lastItem() }} 
                    dari {{ $peralatan->total() }} peralatan
                </p>
                <div class="btn-group btn-group-sm" role="group">
                    <input type="radio" class="btn-check" name="view" id="grid-view" checked>
                    <label class="btn btn-outline-warning" for="grid-view">
                        <i class="bi bi-grid"></i>
                    </label>
                    <input type="radio" class="btn-check" name="view" id="list-view">
                    <label class="btn btn-outline-warning" for="list-view">
                        <i class="bi bi-list"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid View -->
    <div id="grid-container" class="row g-4">
        @foreach($peralatan as $item)
            <div class="col-lg-4 col-md-6">
                <div class="card equipment-card h-100">
                    <div class="position-relative">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->nama }}" 
                                 class="card-img-top"
                                 style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                 style="height: 220px;">
                                <i class="bi bi-truck fs-1 text-white"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success">Tersedia</span>
                        </div>
                        
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-warning text-dark">{{ $item->kategori }}</span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $item->nama }}</h5>
                        
                        @if($item->deskripsi)
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($item->deskripsi, 80) }}
                            </p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="h5 text-warning fw-bold">{{ $item->harga_format }}</span>
                                <small class="text-muted">/hari</small>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>{{ $item->created_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <div class="btn-group">
                                <a href="{{ route('peralatan.detail', $item->id) }}" 
                                   class="btn btn-outline-dark">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                <a href="{{ route('booking.form') }}?peralatan={{ $item->id }}" 
                                   class="btn btn-construction">
                                    <i class="bi bi-calendar-check me-1"></i>Booking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- List View (Hidden by default) -->
    <div id="list-container" class="d-none">
        @foreach($peralatan as $item)
            <div class="card equipment-card mb-3">
                <div class="row g-0">
                    <div class="col-md-3">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->nama }}" 
                                 class="img-fluid h-100 w-100"
                                 style="object-fit: cover; min-height: 180px;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center h-100" 
                                 style="min-height: 180px;">
                                <i class="bi bi-truck fs-1 text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $item->nama }}</h5>
                                <div>
                                    <span class="badge bg-warning text-dark me-2">{{ $item->kategori }}</span>
                                    <span class="badge bg-success">Tersedia</span>
                                </div>
                            </div>
                            
                            @if($item->deskripsi)
                                <p class="card-text text-muted mb-3">{{ $item->deskripsi }}</p>
                            @endif
                            
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="h5 text-warning fw-bold">{{ $item->harga_format }}</span>
                                        <small class="text-muted">/hari</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $item->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('peralatan.detail', $item->id) }}" 
                                           class="btn btn-outline-dark">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                        <a href="{{ route('booking.form') }}?peralatan={{ $item->id }}" 
                                           class="btn btn-construction">
                                            <i class="bi bi-calendar-check me-1"></i>Booking
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $peralatan->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <div class="bg-white p-5 rounded-3 shadow-sm">
                    <i class="bi bi-truck fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">Peralatan Tidak Ditemukan</h5>
                    
                    @if(request()->hasAny(['kategori', 'search']))
                        <p class="text-muted mb-4">
                            Tidak ada peralatan yang sesuai dengan filter Anda. 
                            Coba ubah kriteria pencarian atau reset filter.
                        </p>
                        <a href="{{ route('peralatan.index') }}" class="btn btn-construction">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Filter
                        </a>
                    @else
                        <p class="text-muted mb-4">
                            Belum ada peralatan yang tersedia saat ini. 
                            Silakan hubungi kami untuk informasi lebih lanjut.
                        </p>
                        <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                           class="btn btn-construction">
                            <i class="bi bi-whatsapp me-2"></i>Hubungi WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
    // Toggle View
    document.getElementById('grid-view').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('grid-container').classList.remove('d-none');
            document.getElementById('list-container').classList.add('d-none');
        }
    });

    document.getElementById('list-view').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('grid-container').classList.add('d-none');
            document.getElementById('list-container').classList.remove('d-none');
        }
    });
</script>
@endpush