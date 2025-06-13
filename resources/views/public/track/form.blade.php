{{-- resources/views/public/track/form.blade.php --}}
<x-public-layout :title="'Tracking Pesanan'" :pengaturan="$pengaturan">
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-warning">Beranda</a></li>
                    <li class="breadcrumb-item active">Tracking</li>
                </ol>
            </nav>

            <div class="text-center mb-5">
                <h1 class="fw-bold">Tracking Pesanan</h1>
                <p class="text-muted">Cek status pesanan dengan kode pesanan atau tracking ID</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    @if(session('success'))
                        <div class="alert alert-success border-0 mb-4">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            @if(session('tracking_id'))
                                <div class="mt-2">
                                    <strong>Tracking ID Anda: </strong>
                                    <code class="bg-white px-2 py-1 rounded">{{ session('tracking_id') }}</code>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Form Tracking -->
                    <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="bi bi-search text-warning me-2"></i>Cari Pesanan
                        </h5>

                        <form action="{{ route('track.check') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Kode Pesanan atau Tracking ID</label>
                                <input type="text" 
                                       name="search_code" 
                                       class="form-control @error('search_code') is-invalid @enderror" 
                                       value="{{ old('search_code', session('tracking_id') ?? session('kode_pesanan')) }}" 
                                       placeholder="PSN-240613-001 atau TRK-ABC123"
                                       required>
                                @error('search_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Masukkan kode pesanan (PSN-xxx) atau tracking ID (TRK-xxx)
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-construction btn-lg">
                                    <i class="bi bi-search me-2"></i>Cek Status Pesanan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Info Bantuan -->
                    <div class="bg-warning bg-opacity-10 p-4 rounded-3 shadow-sm">
                        <h6 class="fw-semibold mb-2">
                            <i class="bi bi-question-circle text-warning me-2"></i>Butuh Bantuan?
                        </h6>
                        <p class="mb-3 small">
                            Jika Anda tidak menemukan kode pesanan atau tracking ID, 
                            hubungi customer service kami untuk bantuan.
                        </p>
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                                   class="btn btn-outline-success btn-sm w-100">
                                    <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="tel:{{ $pengaturan['telepon_perusahaan'] ?? '021123456789' }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-telephone me-1"></i>Telepon
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Tracking -->
            @if(isset($pesanan))
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-10">
                        <div class="bg-white p-4 rounded-3 shadow-sm">
                            <h5 class="fw-semibold mb-4">
                                <i class="bi bi-clipboard-data text-warning me-2"></i>Detail Pesanan
                            </h5>

                            <!-- Header Info -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="text-muted small">Kode Pesanan</div>
                                            <div class="fw-bold text-primary">{{ $pesanan->kode_pesanan }}</div>
                                        </div>
                                        @if($pesanan->kode_tracking)
                                            <div class="col-6">
                                                <div class="text-muted small">Tracking ID</div>
                                                <div class="fw-bold"><code>{{ $pesanan->kode_tracking }}</code></div>
                                            </div>
                                        @endif
                                        <div class="col-6">
                                            <div class="text-muted small">Tanggal Booking</div>
                                            <div class="fw-semibold">{{ $pesanan->created_at->format('d M Y, H:i') }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">Customer</div>
                                            <div class="fw-semibold">{{ $pesanan->nama_pelanggan }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    @php
                                        $statusBadges = [
                                            'menunggu_pembayaran' => 'warning',
                                            'bukti_bayar_diupload' => 'info',
                                            'terverifikasi' => 'success',
                                            'sedang_disewa' => 'primary',
                                            'selesai' => 'secondary',
                                            'dibatalkan' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusBadges[$pesanan->status] ?? 'secondary' }} fs-6">
                                        {{ $pesanan->nama_status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Detail Peralatan -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Peralatan</h6>
                                    <div class="d-flex align-items-center">
                                        @if($pesanan->peralatan->gambar)
                                            <img src="{{ asset('storage/' . $pesanan->peralatan->gambar) }}" 
                                                 alt="{{ $pesanan->peralatan->nama }}" 
                                                 class="rounded me-3"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $pesanan->peralatan->nama }}</div>
                                            <div class="text-muted small">{{ $pesanan->peralatan->kategori }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Periode Sewa</h6>
                                    <div class="text-muted small">Tanggal Mulai</div>
                                    <div class="fw-semibold">{{ $pesanan->tanggal_mulai->format('d M Y') }}</div>
                                    <div class="text-muted small mt-1">Tanggal Selesai</div>
                                    <div class="fw-semibold">{{ $pesanan->tanggal_selesai->format('d M Y') }}</div>
                                    <div class="text-warning fw-semibold mt-1">{{ $pesanan->jumlah_hari }} hari</div>
                                </div>
                            </div>

                            <!-- Timeline Status -->
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-3">Timeline Status</h6>
                                <div class="timeline">
                                    <div class="timeline-item {{ $pesanan->status == 'menunggu_pembayaran' ? 'active' : 'completed' }}">
                                        <div class="timeline-marker">
                                            <i class="bi bi-{{ $pesanan->status == 'menunggu_pembayaran' ? 'clock' : 'check' }}"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="fw-semibold">Menunggu Pembayaran</div>
                                            <div class="text-muted small">{{ $pesanan->created_at->format('d M Y, H:i') }}</div>
                                        </div>
                                    </div>

                                    @if($pesanan->waktu_upload_bayar)
                                        <div class="timeline-item {{ in_array($pesanan->status, ['bukti_bayar_diupload']) ? 'active' : 'completed' }}">
                                            <div class="timeline-marker">
                                                <i class="bi bi-{{ in_array($pesanan->status, ['bukti_bayar_diupload']) ? 'clock' : 'check' }}"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="fw-semibold">Bukti Bayar Diupload</div>
                                                <div class="text-muted small">{{ $pesanan->waktu_upload_bayar->format('d M Y, H:i') }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($pesanan->waktu_verifikasi)
                                        <div class="timeline-item {{ in_array($pesanan->status, ['terverifikasi', 'sedang_disewa', 'selesai']) ? 'completed' : '' }}">
                                            <div class="timeline-marker">
                                                <i class="bi bi-check"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="fw-semibold">Pembayaran Terverifikasi</div>
                                                <div class="text-muted small">{{ $pesanan->waktu_verifikasi->format('d M Y, H:i') }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($pesanan->status == 'sedang_disewa')
                                        <div class="timeline-item active">
                                            <div class="timeline-marker">
                                                <i class="bi bi-truck"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="fw-semibold">Sedang Disewa</div>
                                                <div class="text-muted small">Alat sedang digunakan</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($pesanan->status == 'selesai')
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker">
                                                <i class="bi bi-check-circle"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="fw-semibold">Sewa Selesai</div>
                                                <div class="text-muted small">Alat telah dikembalikan</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Total Harga -->
                            <div class="row">
                                <div class="col-md-6">
                                    @if($pesanan->catatan_admin)
                                        <h6 class="fw-semibold mb-2">Catatan Admin</h6>
                                        <div class="alert alert-info border-0">
                                            {{ $pesanan->catatan_admin }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-warning bg-opacity-10 p-3 rounded text-end">
                                        <div class="text-muted small">Total Pembayaran</div>
                                        <div class="h4 text-warning fw-bold">{{ $pesanan->total_harga_format }}</div>
                                        
                                        {{-- Receipt Download Button --}}
                                        @if(in_array($pesanan->status, ['terverifikasi', 'sedang_disewa', 'selesai']) && $pesanan->kode_tracking)
                                            <div class="mt-3">
                                                <a href="{{ route('receipt.pdf', $pesanan->kode_tracking) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="bi bi-download me-1"></i>Download Receipt
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($error))
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-6">
                        <div class="alert alert-danger border-0 text-center">
                            <i class="bi bi-exclamation-triangle fs-1 mb-3"></i>
                            <h6 class="fw-semibold">{{ $error }}</h6>
                            <p class="mb-3">Periksa kembali kode yang Anda masukkan atau hubungi customer service.</p>
                            <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                               class="btn btn-outline-danger">
                                <i class="bi bi-whatsapp me-2"></i>Hubungi WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-marker {
            position: absolute;
            left: -22px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 14px;
        }
        
        .timeline-item.active .timeline-marker {
            background: #ffc107;
            color: #000;
        }
        
        .timeline-item.completed .timeline-marker {
            background: #198754;
            color: #fff;
        }
        
        .timeline-content {
            padding-left: 15px;
        }
    </style>
    @endpush
</x-public-layout>