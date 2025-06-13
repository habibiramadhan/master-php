{{-- resources/views/public/partials/navbar.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-dark navbar-construction sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
            @if(!empty($pengaturan['logo_perusahaan']))
                <img src="{{ asset('storage/' . $pengaturan['logo_perusahaan']) }}" 
                     alt="Logo" 
                     height="40" 
                     class="me-2">
            @else
                <i class="bi bi-truck fs-3 text-warning me-2"></i>
            @endif
            <span class="text-warning">{{ $pengaturan['nama_perusahaan'] ?? 'CV Sewa Alat Berat' }}</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active text-warning' : '' }}" 
                       href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('peralatan.*') ? 'active text-warning' : '' }}" 
                       href="{{ route('peralatan.index') }}">
                        <i class="bi bi-truck me-1"></i>Peralatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('booking.*') ? 'active text-warning' : '' }}" 
                       href="{{ route('booking.form') }}">
                        <i class="bi bi-calendar-check me-1"></i>Booking
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('track.*') ? 'active text-warning' : '' }}" 
                       href="{{ route('track.form') }}">
                        <i class="bi bi-search me-1"></i>Tracking
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                       class="btn btn-construction btn-sm">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>