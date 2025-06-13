{{-- resources/views/public/peralatan/partials/filter.blade.php --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="bg-white p-4 rounded-3 shadow-sm">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-funnel me-1 text-warning"></i>Kategori
                    </label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-search me-1 text-warning"></i>Cari Peralatan
                    </label>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Nama peralatan..."
                           value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-arrow-down-up me-1 text-warning"></i>Urutkan
                    </label>
                    <select name="sort" class="form-select">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="harga_rendah" {{ request('sort') == 'harga_rendah' ? 'selected' : '' }}>Harga Rendah</option>
                        <option value="harga_tinggi" {{ request('sort') == 'harga_tinggi' ? 'selected' : '' }}>Harga Tinggi</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-construction w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </form>
            
            @if(request()->hasAny(['kategori', 'search', 'sort']))
                <div class="mt-3 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small">Filter aktif:</span>
                            @if(request('kategori'))
                                <span class="badge bg-warning text-dark me-1">{{ request('kategori') }}</span>
                            @endif
                            @if(request('search'))
                                <span class="badge bg-info me-1">"{{ request('search') }}"</span>
                            @endif
                        </div>
                        <a href="{{ route('peralatan.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Reset Filter
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>