{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-speedometer2 me-2"></i>{{ __('Admin Dashboard') }}
            </h2>
            <div class="text-muted small">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d M Y, H:i') }}
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Welcome -->
            <div class="alert alert-info border-0 mb-4" style="background: linear-gradient(90deg, #e3f2fd 0%, #bbdefb 100%);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle fs-4 me-3 text-primary"></i>
                    <div>
                        <h6 class="mb-1 fw-semibold">Selamat datang, {{ Auth::user()->name }}!</h6>
                        <small class="text-muted">Kelola sistem sewa alat berat dengan mudah dari dashboard ini.</small>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card h-100 text-white gradient-bg border-0">
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
                    <div class="card stat-card h-100 text-white gradient-success border-0">
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
                    <div class="card stat-card h-100 text-white gradient-warning border-0">
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
                    <div class="card stat-card h-100 text-white gradient-info border-0">
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

            <!-- Status Peralatan -->
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

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Perlu Perhatian -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Perlu Perhatian
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                    <div>
                                        <i class="bi bi-clock-history text-warning me-2"></i>
                                        <span class="fw-medium">Menunggu Pembayaran</span>
                                    </div>
                                    <span class="badge bg-warning rounded-pill">{{ $stats['pesanan_menunggu'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                    <div>
                                        <i class="bi bi-credit-card text-info me-2"></i>
                                        <span class="fw-medium">Perlu Verifikasi</span>
                                    </div>
                                    <span class="badge bg-info rounded-pill">{{ $stats['pesanan_verifikasi'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                    <div>
                                        <i class="bi bi-gear text-primary me-2"></i>
                                        <span class="fw-medium">Sedang Aktif</span>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $stats['pesanan_aktif'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                    <div>
                                        <i class="bi bi-wrench text-warning me-2"></i>
                                        <span class="fw-medium">Dalam Perawatan</span>
                                    </div>
                                    <span class="badge bg-warning rounded-pill">{{ $peralatan_perawatan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="bi bi-lightning me-2 text-primary"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center py-3 text-decoration-none">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Peralatan
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center py-3 text-decoration-none">
                                        <i class="bi bi-credit-card me-2"></i>Verifikasi Pembayaran
                                        @if($stats['pesanan_verifikasi'] > 0)
                                            <span class="badge bg-danger ms-2">{{ $stats['pesanan_verifikasi'] }}</span>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center py-3 text-decoration-none">
                                        <i class="bi bi-clipboard-data me-2"></i>Kelola Pesanan
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-center py-3 text-decoration-none">
                                        <i class="bi bi-sliders me-2"></i>Pengaturan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="row g-4 mt-3">
                <div class="col-12">
                    <div class="card border-0 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="fw-bold mb-2">
                                        <i class="bi bi-gear-wide-connected me-2"></i>Sistem Sewa Alat Berat
                                    </h4>
                                    <p class="mb-0 opacity-75">
                                        Dashboard admin untuk mengelola peralatan, pesanan, dan pembayaran secara terpusat dan efisien.
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <div class="text-end me-3">
                                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                                            <small class="opacity-75">Administrator</small>
                                        </div>
                                        <i class="bi bi-person-badge" style="font-size: 3rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>