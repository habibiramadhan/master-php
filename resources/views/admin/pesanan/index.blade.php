{{-- resources/views/admin/pesanan/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-clipboard-data me-2"></i>{{ __('Kelola Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Cari kode/nama/tracking..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                <option value="bukti_bayar_diupload" {{ request('status') == 'bukti_bayar_diupload' ? 'selected' : '' }}>Bukti Bayar Diupload</option>
                                <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="sedang_disewa" {{ request('status') == 'sedang_disewa' ? 'selected' : '' }}>Sedang Disewa</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($pesanan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Pesanan</th>
                                        <th>Customer</th>
                                        <th>Peralatan</th>
                                        <th>Periode</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan as $item)
                                        <tr>
                                            <td>
                                                <div class="fw-medium text-primary">{{ $item->kode_pesanan }}</div>
                                                @if($item->kode_tracking)
                                                    <small class="text-muted">{{ $item->kode_tracking }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $item->nama_pelanggan }}</div>
                                                <small class="text-muted">{{ $item->telepon_pelanggan }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $item->peralatan->nama }}</div>
                                                <small class="text-muted">{{ $item->peralatan->kategori }}</small>
                                            </td>
                                            <td>
                                                <div>{{ $item->tanggal_mulai->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $item->jumlah_hari }} hari</small>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-success">{{ $item->total_harga_format }}</span>
                                            </td>
                                            <td>
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
                                                <span class="badge bg-{{ $statusBadges[$item->status] ?? 'secondary' }}">
                                                    {{ $item->nama_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.pesanan.show', $item) }}" 
                                                       class="btn btn-outline-info" title="Lihat Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.pesanan.edit', $item) }}" 
                                                       class="btn btn-outline-warning" title="Edit Status">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="confirmDelete({{ $item->id }})" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $pesanan->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pesanan</h5>
                            <p class="text-muted">Pesanan dari customer akan muncul di sini.</p>
                        </div>
                    @endif
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
                    <p>Apakah Anda yakin ingin menghapus pesanan ini?</p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
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
            const form = document.getElementById('deleteForm');
            form.action = `/admin/pesanan/${id}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
    @endpush
</x-app-layout>