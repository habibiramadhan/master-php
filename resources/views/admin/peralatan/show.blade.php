{{-- resources/views/admin/peralatan/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-eye me-2"></i>{{ __('Detail Peralatan') }}
            </h2>
            <div class="btn-group">
                <a href="{{ route('admin.peralatan.edit', $peralatan) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('admin.peralatan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                <!-- Gambar Peralatan -->
                <div class="col-md-5">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            @if($peralatan->gambar)
                                <img src="{{ asset('storage/' . $peralatan->gambar) }}" 
                                     alt="{{ $peralatan->nama }}" 
                                     class="img-fluid rounded shadow-sm w-100">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     style="height: 300px;">
                                    <div class="text-center">
                                        <i class="bi bi-image fs-1 text-muted mb-2"></i>
                                        <p class="text-muted">Tidak ada gambar</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Peralatan -->
                <div class="col-md-7">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h1 class="h3 fw-bold mb-2">{{ $peralatan->nama }}</h1>
                                    <span class="badge bg-secondary fs-6">{{ $peralatan->kategori }}</span>
                                </div>
                                @php
                                    $statusClass = [
                                        'tersedia' => 'success',
                                        'disewa' => 'primary', 
                                        'perawatan' => 'warning'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusClass[$peralatan->status] ?? 'secondary' }} fs-6">
                                    {{ ucfirst($peralatan->status) }}
                                </span>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h5 class="text-success fw-bold">{{ $peralatan->harga_format }}</h5>
                                    <small class="text-muted">per hari</small>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <small class="text-muted">Ditambahkan: {{ $peralatan->created_at->format('d M Y') }}</small>
                                </div>
                            </div>

                            @if($peralatan->deskripsi)
                                <div class="mb-4">
                                    <h6 class="fw-semibold mb-2">Deskripsi</h6>
                                    <p class="text-muted">{{ $peralatan->deskripsi }}</p>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Informasi Detail</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted">ID</td>
                                            <td>{{ $peralatan->id }}</td>
                                        </tr>
                                        <tr>  
                                            <td class="text-muted">Kategori</td>
                                            <td>{{ $peralatan->kategori }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status</td>
                                            <td>
                                                <span class="badge bg-{{ $statusClass[$peralatan->status] ?? 'secondary' }}">
                                                    {{ ucfirst($peralatan->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Harga/Hari</td>
                                            <td class="fw-semibold text-success">{{ $peralatan->harga_format }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-2">Riwayat</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted">Dibuat</td>
                                            <td>{{ $peralatan->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Diperbarui</td>
                                            <td>{{ $peralatan->updated_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksi Cepat -->
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-lightning me-2"></i>Aksi Cepat
                            </h6>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('admin.peralatan.edit', $peralatan) }}" 
                                   class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>Edit Peralatan
                                </a>
                                
                                @if($peralatan->status == 'tersedia')
                                    <button type="button" class="btn btn-primary" disabled>
                                        <i class="bi bi-check-circle me-1"></i>Peralatan Tersedia
                                    </button>
                                @elseif($peralatan->status == 'disewa')
                                    <button type="button" class="btn btn-info" disabled>
                                        <i class="bi bi-gear me-1"></i>Sedang Disewa
                                    </button>
                                @elseif($peralatan->status == 'perawatan')
                                    <button type="button" class="btn btn-warning" disabled>
                                        <i class="bi bi-wrench me-1"></i>Dalam Perawatan
                                    </button>
                                @endif

                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $peralatan->id }})">
                                    <i class="bi bi-trash me-1"></i>Hapus Peralatan
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
                    <p>Apakah Anda yakin ingin menghapus peralatan <strong>{{ $peralatan->nama }}</strong>?</p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.peralatan.destroy', $peralatan) }}" method="POST" class="d-inline">
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
    </script>
    @endpush
</x-app-layout>