{{-- resources/views/admin/verifikasi.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-clipboard-check me-2"></i>{{ __('Verifikasi Pembayaran') }}
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
                                <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline-secondary w-100">
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
                                        <th>Total</th>
                                        <th>Tanggal Upload</th>
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
                                                <div class="fw-medium">{{ $item->nama_customer }}</div>
                                                <small class="text-muted">{{ $item->no_hp }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $item->peralatan->nama }}</div>
                                                <small class="text-muted">{{ $item->peralatan->kategori }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                            </td>
                                            <td>
                                                <div>{{ $item->created_at->format('d/m/Y H:i') }}</div>
                                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" 
                                                            class="btn btn-outline-success" 
                                                            onclick="showApproveModal('{{ $item->id }}', '{{ $item->kode_pesanan }}')"
                                                            title="Approve">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger" 
                                                            onclick="showRejectModal('{{ $item->id }}', '{{ $item->kode_pesanan }}')"
                                                            title="Reject">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                    <a href="#" 
                                                       class="btn btn-outline-info" 
                                                       onclick="showBuktiBayar('{{ asset('storage/' . $item->bukti_bayar) }}')"
                                                       title="Lihat Bukti Bayar">
                                                        <i class="bi bi-image"></i>
                                                    </a>
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
                            <h5 class="text-muted">Belum ada pembayaran</h5>
                            <p class="text-muted">Pembayaran yang perlu diverifikasi akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menyetujui pembayaran untuk pesanan: <span id="approveOrderCode" class="fw-medium"></span></p>
                    <form id="approveForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan_admin" 
                                      class="form-control"
                                      rows="3" 
                                      placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="approveForm" class="btn btn-success">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menolak pembayaran untuk pesanan: <span id="rejectOrderCode" class="fw-medium"></span></p>
                    <form id="rejectForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="catatan_admin" 
                                      class="form-control"
                                      rows="3" 
                                      placeholder="Jelaskan alasan penolakan..."
                                      required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="rejectForm" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bukti Bayar Modal -->
    <div class="modal fade" id="buktiBayarModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="buktiBayarImage" src="" alt="Bukti Pembayaran" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showApproveModal(id, orderCode) {
            document.getElementById('approveOrderCode').textContent = orderCode;
            document.getElementById('approveForm').action = `/admin/verifikasi/${id}/approve`;
            new bootstrap.Modal(document.getElementById('approveModal')).show();
        }

        function showRejectModal(id, orderCode) {
            document.getElementById('rejectOrderCode').textContent = orderCode;
            document.getElementById('rejectForm').action = `/admin/verifikasi/${id}/reject`;
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }

        function showBuktiBayar(imageUrl) {
            document.getElementById('buktiBayarImage').src = imageUrl;
            new bootstrap.Modal(document.getElementById('buktiBayarModal')).show();
        }
    </script>
    @endpush
</x-app-layout>