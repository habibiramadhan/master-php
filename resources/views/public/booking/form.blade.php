{{-- resources/views/public/booking/form.blade.php --}}
<x-public-layout :title="'Booking Peralatan'" :pengaturan="$pengaturan">
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-warning">Beranda</a></li>
                    <li class="breadcrumb-item active">Booking</li>
                </ol>
            </nav>

            <div class="text-center mb-5">
                <h1 class="fw-bold">Form Booking</h1>
                <p class="text-muted">Isi data lengkap untuk menyewa alat berat</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded-3 shadow-sm">
                        @if(session('success'))
                            <div class="alert alert-success border-0">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            
                            <!-- Pilih Peralatan -->
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">
                                    <i class="bi bi-truck text-warning me-2"></i>Pilih Peralatan
                                </h5>
                                <select name="peralatan_id" class="form-select @error('peralatan_id') is-invalid @enderror" required>
                                    <option value="">Pilih Peralatan yang Ingin Disewa</option>
                                    @foreach($peralatan as $item)
                                        <option value="{{ $item->id }}" 
                                                data-harga="{{ $item->harga_per_hari }}"
                                                {{ old('peralatan_id', request('peralatan')) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }} - {{ $item->kategori }} ({{ $item->harga_format }}/hari)
                                        </option>
                                    @endforeach
                                </select>
                                @error('peralatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Data Customer -->
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">
                                    <i class="bi bi-person text-warning me-2"></i>Data Customer
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               name="nama_pelanggan" 
                                               class="form-control @error('nama_pelanggan') is-invalid @enderror" 
                                               value="{{ old('nama_pelanggan') }}" 
                                               required>
                                        @error('nama_pelanggan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" 
                                               name="email_pelanggan" 
                                               class="form-control @error('email_pelanggan') is-invalid @enderror" 
                                               value="{{ old('email_pelanggan') }}" 
                                               required>
                                        @error('email_pelanggan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="tel" 
                                               name="telepon_pelanggan" 
                                               class="form-control @error('telepon_pelanggan') is-invalid @enderror" 
                                               value="{{ old('telepon_pelanggan') }}" 
                                               placeholder="08123456789"
                                               required>
                                        @error('telepon_pelanggan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Perusahaan/Instansi</label>
                                        <input type="text" 
                                               name="perusahaan" 
                                               class="form-control" 
                                               value="{{ old('perusahaan') }}" 
                                               placeholder="PT. Konstruksi ABC">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea name="alamat_pelanggan" 
                                                  class="form-control @error('alamat_pelanggan') is-invalid @enderror" 
                                                  rows="3" 
                                                  required>{{ old('alamat_pelanggan') }}</textarea>
                                        @error('alamat_pelanggan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Periode Sewa -->
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-3">
                                    <i class="bi bi-calendar text-warning me-2"></i>Periode Sewa
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               name="tanggal_mulai" 
                                               class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                               value="{{ old('tanggal_mulai', date('Y-m-d', strtotime('+1 day'))) }}" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               required>
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               name="tanggal_selesai" 
                                               class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                               value="{{ old('tanggal_selesai') }}" 
                                               min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                               required>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Kalkulasi Hari & Total -->
                                <div class="bg-warning bg-opacity-10 p-3 rounded mt-3" id="calculation" style="display: none;">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="fw-semibold">Jumlah Hari</div>
                                            <div class="h5 text-warning" id="jumlah-hari">0</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fw-semibold">Harga per Hari</div>
                                            <div class="h5 text-warning" id="harga-per-hari">Rp 0</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fw-semibold">Total Harga</div>
                                            <div class="h4 text-warning fw-bold" id="total-harga">Rp 0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="mb-4">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea name="catatan" 
                                          class="form-control" 
                                          rows="3" 
                                          placeholder="Informasi tambahan, lokasi proyek, kebutuhan operator, dll...">{{ old('catatan') }}</textarea>
                            </div>

                            <!-- Info Pembayaran -->
                            <div class="alert alert-info border-0">
                                <h6 class="fw-semibold mb-2">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Pembayaran
                                </h6>
                                <p class="mb-2 small">Setelah submit booking, Anda akan mendapat kode pesanan dan detail pembayaran:</p>
                                <ul class="mb-0 small">
                                    <li>Transfer ke: <strong>{{ $pengaturan['nama_bank'] ?? 'Bank BCA' }}</strong></li>
                                    <li>No. Rekening: <strong>{{ $pengaturan['nomor_rekening'] ?? '1234567890' }}</strong></li>
                                    <li>a.n: <strong>{{ $pengaturan['nama_rekening'] ?? 'CV Sewa Alat Berat' }}</strong></li>
                                </ul>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-construction btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Submit Booking
                                </button>
                                <a href="{{ route('peralatan.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Auto calculate total
        function calculateTotal() {
            const peralatanSelect = document.querySelector('select[name="peralatan_id"]');
            const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]');
            const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]');
            
            if (peralatanSelect.value && tanggalMulai.value && tanggalSelesai.value) {
                const selectedOption = peralatanSelect.options[peralatanSelect.selectedIndex];
                const hargaPerHari = parseInt(selectedOption.dataset.harga) || 0;
                
                const mulai = new Date(tanggalMulai.value);
                const selesai = new Date(tanggalSelesai.value);
                
                if (selesai > mulai) {
                    const diffTime = Math.abs(selesai - mulai);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 include start day
                    const total = diffDays * hargaPerHari;
                    
                    document.getElementById('jumlah-hari').textContent = diffDays;
                    document.getElementById('harga-per-hari').textContent = 'Rp ' + hargaPerHari.toLocaleString('id-ID');
                    document.getElementById('total-harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
                    document.getElementById('calculation').style.display = 'block';
                } else {
                    document.getElementById('calculation').style.display = 'none';
                }
            } else {
                document.getElementById('calculation').style.display = 'none';
            }
        }

        // Event listeners
        document.querySelector('select[name="peralatan_id"]').addEventListener('change', calculateTotal);
        document.querySelector('input[name="tanggal_mulai"]').addEventListener('change', function() {
            // Update min date for tanggal_selesai
            const nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            document.querySelector('input[name="tanggal_selesai"]').min = nextDay.toISOString().split('T')[0];
            calculateTotal();
        });
        document.querySelector('input[name="tanggal_selesai"]').addEventListener('change', calculateTotal);

        // Initial calculation if form has values
        calculateTotal();
    </script>
    @endpush
</x-public-layout>