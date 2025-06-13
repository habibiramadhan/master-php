{{-- resources/views/admin/pesanan/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-pencil me-2"></i>{{ __('Edit Status Pesanan') }}
            </h2>
            <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                <!-- Form Edit -->
                <div class="col-md-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <form action="{{ route('admin.pesanan.update', $pesanan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <h5 class="fw-semibold mb-3">Update Status Pesanan</h5>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Pesanan:</strong> {{ $pesanan->kode_pesanan }} - {{ $pesanan->nama_pelanggan }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Pesanan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="menunggu_pembayaran" {{ old('status', $pesanan->status) == 'menunggu_pembayaran' ? 'selected' : '' }}>
                                            Menunggu Pembayaran
                                        </option>
                                        <option value="bukti_bayar_diupload" {{ old('status', $pesanan->status) == 'bukti_bayar_diupload' ? 'selected' : '' }}>
                                            Bukti Bayar Diupload
                                        </option>
                                        <option value="terverifikasi" {{ old('status', $pesanan->status) == 'terverifikasi' ? 'selected' : '' }}>
                                            Terverifikasi
                                        </option>
                                        <option value="sedang_disewa" {{ old('status', $pesanan->status) == 'sedang_disewa' ? 'selected' : '' }}>
                                            Sedang Disewa
                                        </option>
                                        <option value="selesai" {{ old('status', $pesanan->status) == 'selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                        <option value="dibatalkan" {{ old('status', $pesanan->status) == 'dibatalkan' ? 'selected' : '' }}>
                                            Dibatalkan
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <strong>Status saat ini:</strong> 
                                            <span class="badge bg-primary">{{ $pesanan->nama_status }}</span>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="catatan_admin" class="form-label">Catatan Admin</label>
                                    <textarea class="form-control @error('catatan_admin') is-invalid @enderror" 
                                              id="catatan_admin" 
                                              name="catatan_admin" 
                                              rows="4" 
                                              placeholder="Tambahkan catatan untuk pesanan ini...">{{ old('catatan_admin', $pesanan->catatan_admin) }}</textarea>
                                    @error('catatan_admin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <small class="text-muted">Catatan ini akan terlihat di detail pesanan</small>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info Pesanan -->
                <div class="col-md-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h6 class="fw-semibold mb-3">Informasi Pesanan</h6>
                            
                            <table class="table table-sm">
                                <tr>
                                    <td class="text-muted">Kode</td>
                                    <td class="fw-medium">{{ $pesanan->kode_pesanan }}</td>
                                </tr>
                                @if($pesanan->kode_tracking)
                                    <tr>
                                        <td class="text-muted">Tracking</td>
                                        <td><code>{{ $pesanan->kode_tracking }}</code></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Customer</td>
                                    <td class="fw-medium">{{ $pesanan->nama_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Peralatan</td>
                                    <td class="fw-medium">{{ $pesanan->peralatan->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Periode</td>
                                    <td>
                                        {{ $pesanan->tanggal_mulai->format('d/m') }} - 
                                        {{ $pesanan->tanggal_selesai->format('d/m/Y') }}
                                        <br><small class="text-muted">{{ $pesanan->jumlah_hari }} hari</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Total</td>
                                    <td class="fw-bold text-success">{{ $pesanan->total_harga_format }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Dibuat</td>
                                    <td>{{ $pesanan->created_at->format('d M Y') }}</td>
                                </tr>
                            </table>

                            <!-- Status Flow -->
                            <div class="mt-4">
                                <h6 class="fw-semibold mb-2">Alur Status</h6>
                                <div class="small">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-circle text-warning me-2"></i>
                                        <span>Menunggu Pembayaran</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-circle text-info me-2"></i>
                                        <span>Bukti Bayar Diupload</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-circle text-success me-2"></i>
                                        <span>Terverifikasi</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-circle text-primary me-2"></i>
                                        <span>Sedang Disewa</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-circle text-secondary me-2"></i>
                                        <span>Selesai</span>
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