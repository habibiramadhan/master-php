{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Sewa Alat Berat' }} - {{ $pengaturan['nama_perusahaan'] ?? 'CV Sewa Alat Berat' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-yellow: #FFC107;
            --dark-yellow: #FF8F00;
            --construction-black: #212529;
            --light-gray: #F8F9FA;
        }
        
        .navbar-construction {
            background: linear-gradient(135deg, var(--construction-black) 0%, #343a40 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-construction {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--dark-yellow) 100%);
            border: none;
            color: var(--construction-black);
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-construction:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255,193,7,0.3);
            color: var(--construction-black);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--construction-black) 0%, #495057 100%);
            color: white;
        }
        
        .equipment-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .footer-construction {
            background: linear-gradient(135deg, var(--construction-black) 0%, #343a40 100%);
            color: white;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-yellow);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-yellow);
        }
    </style>
    
    @stack('styles')
</head>

<body>
    @include('public.partials.navbar')
    
    <main>
        {{ $slot }}
    </main>
    
    @include('public.partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>