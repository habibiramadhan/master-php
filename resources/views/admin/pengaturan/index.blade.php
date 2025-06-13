{{-- resources/views/admin/pengaturan/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-sliders me-2"></i>{{ __('Pengaturan Website') }}
            </h2>
            <div class="text-muted small">
                <i class="bi bi-gear me-1"></i>Konfigurasi Sistem
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success border-0 mb-4" style="background: linear-gradient(90deg, #d4edda 0%, #c3e6cb 100%);">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle fs-4 me-3 text-success"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">Berhasil!</h6>
                            <small>{{ session('success') }}</small>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="row g-4">
                    <!-- Info Perusahaan -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-building me-2"></i>Informasi Perusahaan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_perusahaan') is-invalid @enderror" 
                                           id="nama_perusahaan" 
                                           name="nama_perusahaan" 
                                           value="{{ old('nama_perusahaan', $pengaturan['nama_perusahaan'] ?? '') }}" 
                                           required>
                                    @error('nama_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email_perusahaan" class="form-label">Email Perusahaan <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email_perusahaan') is-invalid @enderror" 
                                           id="email_perusahaan" 
                                           name="email_perusahaan" 
                                           value="{{ old('email_perusahaan', $pengaturan['email_perusahaan'] ?? '') }}" 
                                           required>
                                    @error('email_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telepon_perusahaan" class="form-label">Telepon <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('telepon_perusahaan') is-invalid @enderror" 
                                               id="telepon_perusahaan" 
                                               name="telepon_perusahaan" 
                                               value="{{ old('telepon_perusahaan', $pengaturan['telepon_perusahaan'] ?? '') }}" 
                                               required>
                                        @error('telepon_perusahaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="whatsapp_perusahaan" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('whatsapp_perusahaan') is-invalid @enderror" 
                                               id="whatsapp_perusahaan" 
                                               name="whatsapp_perusahaan" 
                                               value="{{ old('whatsapp_perusahaan', $pengaturan['whatsapp_perusahaan'] ?? '') }}" 
                                               placeholder="628123456789"
                                               required>
                                        @error('whatsapp_perusahaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat_perusahaan') is-invalid @enderror" 
                                              id="alamat_perusahaan" 
                                              name="alamat_perusahaan" 
                                              rows="3" 
                                              required>{{ old('alamat_perusahaan', $pengaturan['alamat_perusahaan'] ?? '') }}</textarea>
                                    @error('alamat_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="area_layanan" class="form-label">Area Layanan <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('area_layanan') is-invalid @enderror" 
                                           id="area_layanan" 
                                           name="area_layanan" 
                                           value="{{ old('area_layanan', $pengaturan['area_layanan'] ?? '') }}" 
                                           placeholder="Jakarta, Bogor, Depok, Tangerang, Bekasi"
                                           required>
                                    @error('area_layanan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Logo Upload -->
                                <div class="mb-3">
                                    <label for="logo_perusahaan" class="form-label">Logo Perusahaan</label>
                                    @if(!empty($pengaturan['logo_perusahaan']))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $pengaturan['logo_perusahaan']) }}" 
                                                 alt="Logo" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 100px;">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger ms-2" 
                                                    onclick="deleteLogo()">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                    @endif
                                    <input type="file" 
                                           class="form-control @error('logo_perusahaan') is-invalid @enderror" 
                                           id="logo_perusahaan" 
                                           name="logo_perusahaan" 
                                           accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                    @error('logo_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pembayaran & Sosial Media -->
                    <div class="col-lg-6">
                        <!-- Info Pembayaran -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="nama_bank" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_bank') is-invalid @enderror" 
                                           id="nama_bank" 
                                           name="nama_bank" 
                                           value="{{ old('nama_bank', $pengaturan['nama_bank'] ?? '') }}" 
                                           required>
                                    @error('nama_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nomor_rekening" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nomor_rekening') is-invalid @enderror" 
                                           id="nomor_rekening" 
                                           name="nomor_rekening" 
                                           value="{{ old('nomor_rekening', $pengaturan['nomor_rekening'] ?? '') }}" 
                                           required>
                                    @error('nomor_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_rekening" class="form-label">Nama Rekening <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_rekening') is-invalid @enderror" 
                                           id="nama_rekening" 
                                           name="nama_rekening" 
                                           value="{{ old('nama_rekening', $pengaturan['nama_rekening'] ?? '') }}" 
                                           required>
                                    @error('nama_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sosial Media -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-share me-2"></i>Sosial Media
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="url" 
                                           class="form-control @error('facebook') is-invalid @enderror" 
                                           id="facebook" 
                                           name="facebook" 
                                           value="{{ old('facebook', $pengaturan['facebook'] ?? '') }}" 
                                           placeholder="https://facebook.com/username">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="url" 
                                           class="form-control @error('instagram') is-invalid @enderror" 
                                           id="instagram" 
                                           name="instagram" 
                                           value="{{ old('instagram', $pengaturan['instagram'] ?? '') }}" 
                                           placeholder="https://instagram.com/username">
                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tentang_kami" class="form-label">Tentang Kami <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('tentang_kami') is-invalid @enderror" 
                                              id="tentang_kami" 
                                              name="tentang_kami" 
                                              rows="3" 
                                              required>{{ old('tentang_kami', $pengaturan['tentang_kami'] ?? '') }}</textarea>
                                    @error('tentang_kami')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-save me-2"></i>Simpan Pengaturan
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg px-5 ms-3">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteLogo() {
            if (confirm('Yakin ingin menghapus logo?')) {
                fetch('{{ route("admin.pengaturan.delete-logo") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus logo');
                });
            }
        }
    </script>
    @endpush
</x-app-layout>