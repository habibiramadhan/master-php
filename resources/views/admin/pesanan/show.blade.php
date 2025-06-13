{{-- resources/views/admin/pesanan/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-eye me-2"></i>{{ __('Detail Pesanan') }}
            </h2>
            <div class="btn-group">
                <a href="{{ route('admin.pesanan.edit', $pesanan) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit Status
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                <!-- Info Pesanan -->
                <div class="col-md-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h3 class="fw-bold mb-2">{{ $pesanan->kode_pesanan }}</h3>
                                    @if($pesanan->kode_tracking)
                                        <p class="text-muted">Tracking: <code>{{ $pesanan->kode_tracking }}</code></p>
                                    @endif
                                </div>
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

                            <!-- Info Customer -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Informasi Customer</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted">Nama</td>
                                            <td class="fw-medium">{{ $pesanan->nama_pelanggan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Email</td>
                                            <td>{{ $pesanan->email_pelanggan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Telepon</td>
                                            <td>{{ $pesanan->telepon_pelanggan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Alamat</td>
                                            <td>{{ $pesanan->alamat_pelanggan }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Detail Peralatan</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted">Nama</td>
                                            <td class="fw-medium">{{ $pesanan->peralatan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kategori</td>
                                            <td>{{ $pesanan->peralatan->kategori }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Harga/Hari</td>
                                            <td class="fw-semibold text-success">{{ $pesanan->harga_per_hari_format }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Info Sewa -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Periode Sewa</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted">Tanggal Mulai</td>
                                            <td class="fw-medium">{{ $pesanan->tanggal_mulai->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tanggal Selesai</td>
                                            <td class="fw-medium">{{ $pesanan->tanggal_selesai->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Jumlah Hari</td>
                                            <td class="fw-medium">{{ $pesanan->jumlah_hari }} hari</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Total Harga</td>
                                            <td class="fw-bold text-success fs-5">{{ $pesanan->total_harga_format }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Riwayat Status</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted">Dibuat</td>
                                            <td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                        @if($pesanan->waktu_upload_bayar)
                                            <tr>
                                                <td class="text-muted">Upload Bayar</td>
                                                <td>{{ $pesanan->waktu_upload_bayar->format('d M Y, H:i') }}</td>
                                            </tr>
                                        @endif
                                        @if($pesanan->waktu_verifikasi)
                                            <tr>
                                                <td class="text-muted">Diverifikasi</td>
                                                <td>{{ $pesanan->waktu_verifikasi->format('d M Y, H:i') }}</td>
                                            </tr>
                                        @endif
                                        @if($pesanan->diverifikasiOleh)
                                            <tr>
                                                <td class="text-muted">Verifikator</td>
                                                <td>{{ $pesanan->diverifikasiOleh->name }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- Catatan -->
                            @if($pesanan->catatan || $pesanan->catatan_admin)
                                <div class="row">
                                    @if($pesanan->catatan)
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-2">Catatan Customer</h6>
                                            <div class="bg-light p-3 rounded">
                                                {{ $pesanan->catatan }}
                                            </div>
                                        </div>
                                    @endif
                                    @if($pesanan->catatan_admin)
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-2">Catatan Admin</h6>
                                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                                {{ $pesanan->catatan_admin }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bukti Bayar & Actions -->
                <div class="col-md-4">
                    <!-- Bukti Pembayaran -->
                    @if($pesanan->bukti_bayar)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                            <div class="p-6">
                                <h6 class="fw-semibold mb-3">Bukti Pembayaran</h6>
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}" 
                                         alt="Bukti Bayar" 
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 300px;">
                                </div>
                                <div class="mt-3">
                                    <a href="{{ asset('storage/' . $pesanan->bukti_bayar) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-download me-1"></i>Lihat Full Size
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-lightning me-2"></i>Quick Actions
                            </h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.pesanan.edit', $pesanan) }}" 
                                   class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>Edit Status
                                </a>

                                @if($pesanan->status == 'bukti_bayar_diupload')
                                    <button type="button" 
                                            class="btn btn-success"
                                            onclick="updateStatus('{{ $pesanan->id }}', 'terverifikasi')">
                                        <i class="bi bi-check-circle me-1"></i>Verifikasi Pembayaran
                                    </button>
                                @endif

                                @if($pesanan->status == 'terverifikasi')
                                    <button type="button" 
                                            class="btn btn-primary"
                                            onclick="updateStatus('{{ $pesanan->id }}', 'sedang_disewa')">
                                        <i class="bi bi-play-circle me-1"></i>Mulai Sewa
                                    </button>
                                @endif

                                @if($pesanan->status == 'sedang_disewa')
                                    <button type="button" 
                                            class="btn btn-secondary"
                                            onclick="updateStatus('{{ $pesanan->id }}', 'selesai')">
                                        <i class="bi bi-check-square me-1"></i>Selesai Sewa
                                    </button>
                                @endif

                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $pesanan->id }})">
                                    <i class="bi bi-trash me-1"></i>Hapus Pesanan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus pesanan <strong>{{ $pesanan->kode_pesanan }}</strong>?</p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.pesanan.destroy', $pesanan) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function updateStatus(id, status) {
            if(confirm('Apakah Anda yakin ingin mengubah status pesanan?')) {
                fetch(`/admin/pesanan/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        }
    </script>
    @endpush
</x-app-layout>