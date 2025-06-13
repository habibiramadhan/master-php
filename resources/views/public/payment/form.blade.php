{{-- resources/views/public/payment/form.blade.php --}}
<x-public-layout :title="'Upload Pembayaran'" :pengaturan="$pengaturan">
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-warning">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('booking.form') }}" class="text-warning">Booking</a></li>
                    <li class="breadcrumb-item active">Upload Pembayaran</li>
                </ol>
            </nav>

            <div class="text-center mb-5">
                <h1 class="fw-bold">Upload Bukti Pembayaran</h1>
                <p class="text-muted">Transfer sesuai nominal dan upload bukti pembayaran</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if(session('success'))
                        <div class="alert alert-success border-0 mb-4">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if(session('kode_pesanan'))
                        <!-- Info Pesanan -->
                        <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
                            <h5 class="fw-semibold mb-3 text-success">
                                <i class="bi bi-check-circle me-2"></i>Booking Berhasil!
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted">Kode Pesanan:</span>
                                        <span class="fw-bold text-primary">{{ session('kode_pesanan') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted">Total Pembayaran:</span>
                                        <span class="fw-bold text-warning fs-5">Rp {{ number_format(session('total_harga'), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mt-3 mb-0">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    <strong>Simpan kode pesanan</strong> untuk tracking status booking Anda
                                </small>
                            </div>
                        </div>
                    @endif

                    <!-- Info Rekening -->
                    <div class="bg-warning bg-opacity-10 p-4 rounded-3 shadow-sm mb-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="bi bi-credit-card text-warning me-2"></i>Informasi Rekening
                        </h5>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="fw-semibold">Bank</div>
                                <div class="h5 text-warning">{{ $pengaturan['nama_bank'] ?? 'Bank BCA' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="fw-semibold">No. Rekening</div>
                                <div class="h5 text-warning">{{ $pengaturan['nomor_rekening'] ?? '1234567890' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="fw-semibold">Atas Nama</div>
                                <div class="h5 text-warning">{{ $pengaturan['nama_rekening'] ?? 'CV Sewa Alat Berat' }}</div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-warning btn-sm" onclick="copyRekening()">
                                <i class="bi bi-copy me-1"></i>Copy No. Rekening
                            </button>
                        </div>
                    </div>

                    <!-- Form Upload -->
                    <div class="bg-white p-4 rounded-3 shadow-sm">
                        <h5 class="fw-semibold mb-3">
                            <i class="bi bi-upload text-warning me-2"></i>Upload Bukti Transfer
                        </h5>

                        <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Kode Pesanan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="kode_pesanan" 
                                       class="form-control @error('kode_pesanan') is-invalid @enderror" 
                                       value="{{ old('kode_pesanan', session('kode_pesanan')) }}" 
                                       placeholder="PSN-240613-001"
                                       required>
                                @error('kode_pesanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Masukkan kode pesanan yang Anda terima setelah booking</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Transfer <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="jumlah_transfer" 
                                       class="form-control @error('jumlah_transfer') is-invalid @enderror" 
                                       value="{{ old('jumlah_transfer', session('total_harga')) }}" 
                                       min="0"
                                       required>
                                @error('jumlah_transfer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Masukkan nominal yang Anda transfer</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Pengirim <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="nama_pengirim" 
                                       class="form-control @error('nama_pengirim') is-invalid @enderror" 
                                       value="{{ old('nama_pengirim') }}" 
                                       placeholder="Nama sesuai rekening pengirim"
                                       required>
                                @error('nama_pengirim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
                                <input type="file" 
                                       name="bukti_bayar" 
                                       class="form-control @error('bukti_bayar') is-invalid @enderror" 
                                       accept="image/*"
                                       required>
                                @error('bukti_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPG, PNG. Maksimal 2MB</div>
                                
                                <!-- Preview -->
                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>

                            <div class="alert alert-warning border-0 mb-4">
                                <h6 class="fw-semibold">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Pastikan foto bukti transfer:
                                </h6>
                                <ul class="mb-0 small">
                                    <li>Jelas dan tidak blur</li>
                                    <li>Tampak nominal transfer</li>
                                    <li>Tampak tanggal & waktu transfer</li>
                                    <li>Tampak nama penerima</li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-construction btn-lg">
                                    <i class="bi bi-cloud-upload me-2"></i>Upload Bukti Pembayaran
                                </button>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('track.form') }}" class="btn btn-outline-primary w-100">
                                            <i class="bi bi-search me-1"></i>Cek Status
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="https://wa.me/{{ $pengaturan['whatsapp_perusahaan'] ?? '628123456789' }}" 
                                           class="btn btn-outline-success w-100">
                                            <i class="bi bi-whatsapp me-1"></i>Bantuan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white p-4 rounded-3 shadow-sm mt-4">
                        <h6 class="fw-semibold mb-3">Proses Selanjutnya</h6>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="text-center small">
                                <div class="badge bg-success mb-1">
                                    <i class="bi bi-check"></i>
                                </div>
                                <div class="text-muted">Upload Bukti</div>
                            </div>
                            <div class="text-warning d-none d-md-block">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                            <div class="text-center small">
                                <div class="badge bg-warning text-dark mb-1">2</div>
                                <div class="text-muted">Verifikasi Admin</div>
                            </div>
                            <div class="text-warning d-none d-md-block">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                            <div class="text-center small">
                                <div class="badge bg-primary mb-1">3</div>
                                <div class="text-muted">Konfirmasi</div>
                            </div>
                            <div class="text-warning d-none d-md-block">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                            <div class="text-center small">
                                <div class="badge bg-success mb-1">4</div>
                                <div class="text-muted">Alat Diantar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Preview image
        document.querySelector('input[name="bukti_bayar"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Copy rekening
        function copyRekening() {
            const rekening = '{{ $pengaturan["nomor_rekening"] ?? "1234567890" }}';
            navigator.clipboard.writeText(rekening).then(function() {
                // Show success feedback
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check me-1"></i>Copied!';
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');
                
                setTimeout(function() {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-warning');
                }, 2000);
            });
        }
    </script>
    @endpush
</x-public-layout>