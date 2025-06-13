{{-- resources/views/public/partials/how-it-works.blade.php --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Cara Menyewa</h2>
            <p class="text-muted">Proses mudah dan cepat untuk menyewa alat berat</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <span class="fw-bold fs-3 text-dark">1</span>
                        </div>
                        <div class="position-absolute top-50 start-100 translate-middle-y d-none d-lg-block">
                            <i class="bi bi-arrow-right fs-4 text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-3">Pilih Peralatan</h5>
                    <p class="text-muted small">
                        Browse katalog peralatan kami dan pilih sesuai kebutuhan proyek. 
                        Lihat spesifikasi dan harga per hari.
                    </p>
                    <a href="{{ route('peralatan.index') }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-truck me-1"></i>Lihat Katalog
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <span class="fw-bold fs-3 text-dark">2</span>
                        </div>
                        <div class="position-absolute top-50 start-100 translate-middle-y d-none d-lg-block">
                            <i class="bi bi-arrow-right fs-4 text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-3">Isi Form Booking</h5>
                    <p class="text-muted small">
                        Lengkapi data diri dan detail proyek. Tentukan tanggal mulai dan selesai sewa. 
                        Tidak perlu registrasi.
                    </p>
                    <a href="{{ route('booking.form') }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-calendar-check me-1"></i>Booking Now
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <span class="fw-bold fs-3 text-dark">3</span>
                        </div>
                        <div class="position-absolute top-50 start-100 translate-middle-y d-none d-lg-block">
                            <i class="bi bi-arrow-right fs-4 text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-3">Transfer & Upload</h5>
                    <p class="text-muted small">
                        Lakukan pembayaran via transfer bank. Upload bukti bayar untuk mendapatkan 
                        tracking ID.
                    </p>
                    <div class="bg-dark bg-opacity-10 p-2 rounded text-center">
                        <small class="text-muted">{{ $pengaturan['nama_bank'] ?? 'Bank BCA' }}</small><br>
                        <small class="fw-semibold">{{ $pengaturan['nomor_rekening'] ?? '1234567890' }}</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="position-relative mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-check-lg fs-3 text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-3">Verifikasi & Sewa</h5>
                    <p class="text-muted small">
                        Tim kami verifikasi pembayaran. Setelah confirmed, alat berat siap 
                        diantar ke lokasi proyek.
                    </p>
                    <a href="{{ route('track.form') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-search me-1"></i>Track Status
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Timeline Visual -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-white p-4 rounded-3 shadow-sm">
                    <h6 class="text-center text-warning fw-semibold mb-3">Timeline Status Pesanan</h6>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-center small">
                            <div class="badge bg-warning text-dark mb-1">Booking</div>
                            <div class="text-muted">Form submitted</div>
                        </div>
                        <div class="text-warning d-none d-md-block">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="text-center small">
                            <div class="badge bg-info mb-1">Payment</div>
                            <div class="text-muted">Bukti upload</div>
                        </div>
                        <div class="text-warning d-none d-md-block">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="text-center small">
                            <div class="badge bg-success mb-1">Verified</div>
                            <div class="text-muted">Payment OK</div>
                        </div>
                        <div class="text-warning d-none d-md-block">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="text-center small">
                            <div class="badge bg-primary mb-1">Active</div>
                            <div class="text-muted">Alat disewa</div>
                        </div>
                        <div class="text-warning d-none d-md-block">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                        <div class="text-center small">
                            <div class="badge bg-secondary mb-1">Complete</div>
                            <div class="text-muted">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>