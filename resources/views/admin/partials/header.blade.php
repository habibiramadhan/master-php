{{-- resources/views/admin/partials/header.blade.php --}}
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-dark">
        @yield('page-title', 'Dashboard')
    </h1>
    
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-calendar3 me-1"></i>
                {{ now()->format('d M Y') }}
            </button>
        </div>
        
        @if(request()->routeIs('admin.dashboard'))
            <button type="button" class="btn btn-sm btn-primary" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
            </button>
        @endif
        
        @yield('page-actions')
    </div>
</div>

@if(request()->routeIs('admin.dashboard'))
    <div class="alert alert-info border-0" style="background: linear-gradient(90deg, #e3f2fd 0%, #bbdefb 100%);">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle fs-4 me-3 text-primary"></i>
            <div>
                <h6 class="mb-1 fw-semibold">Selamat datang di Admin Dashboard!</h6>
                <small class="text-muted">
                    Kelola peralatan, verifikasi pembayaran, dan pantau pesanan dengan mudah.
                </small>
            </div>
        </div>
    </div>
@endif