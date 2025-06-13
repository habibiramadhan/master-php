{{-- resources/views/admin/partials/stats-cards.blade.php --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-truck fs-1 opacity-75"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="fw-semibold fs-4">{{ number_format($stats['total_peralatan']) }}</div>
                        <div class="text-uppercase opacity-75 small">Total Peralatan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-clipboard-check fs-1 opacity-75"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="fw-semibold fs-4">{{ number_format($stats['total_pesanan']) }}</div>
                        <div class="text-uppercase opacity-75 small">Total Pesanan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-clock-history fs-1 opacity-75"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="fw-semibold fs-4">{{ number_format($stats['pesanan_verifikasi']) }}</div>
                        <div class="text-uppercase opacity-75 small">Perlu Verifikasi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-currency-dollar fs-1 opacity-75"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="fw-semibold fs-5">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</div>
                        <div class="text-uppercase opacity-75 small">Pendapatan Bulan Ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 bg-success bg-opacity-10 h-100">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                <h4 class="text-success fw-bold">{{ $peralatan_tersedia }}</h4>
                <small class="text-muted">Peralatan Tersedia</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="card border-0 bg-primary bg-opacity-10 h-100">
            <div class="card-body text-center">
                <i class="bi bi-gear-fill text-primary fs-1 mb-2"></i>
                <h4 class="text-primary fw-bold">{{ $peralatan_disewa }}</h4>
                <small class="text-muted">Sedang Disewa</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="card border-0 bg-warning bg-opacity-10 h-100">
            <div class="card-body text-center">
                <i class="bi bi-wrench text-warning fs-1 mb-2"></i>
                <h4 class="text-warning fw-bold">{{ $peralatan_perawatan }}</h4>
                <small class="text-muted">Dalam Perawatan</small>
            </div>
        </div>
    </div>
</div>