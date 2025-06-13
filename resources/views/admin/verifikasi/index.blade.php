{{-- resources/views/admin/verifikasi.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Daftar Pembayaran Menunggu Verifikasi ({{ $pesanan->total() }})</h3>
                    </div>

                    @if($pesanan->count() > 0)
                        <div class="space-y-6">
                            @foreach($pesanan as $item)
                                <div class="border rounded-lg p-6 bg-gray-50">
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                        <div class="lg:col-span-2">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h4 class="font-semibold text-lg">{{ $item->kode_pesanan }}</h4>
                                                    <p class="text-sm text-gray-600">Tracking: {{ $item->kode_tracking }}</p>
                                                </div>
                                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu Verifikasi
                                                </span>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Peralatan</p>
                                                    <p class="text-lg">{{ $item->peralatan->nama }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Total Harga</p>
                                                    <p class="text-lg font-semibold text-green-600">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Nama Customer</p>
                                                    <p>{{ $item->nama_customer }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">No. HP</p>
                                                    <p>{{ $item->no_hp }}</p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Tanggal Sewa</p>
                                                    <p>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</p>
                                                    <p class="text-sm text-gray-600">({{ $item->durasi_hari }} hari)</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Upload Bukti</p>
                                                    <p class="text-sm text-gray-600">{{ $item->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            @if($item->bukti_bayar)
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</p>
                                                    <img src="{{ asset('storage/' . $item->bukti_bayar) }}" 
                                                         alt="Bukti Bayar" 
                                                         class="w-full max-w-xs rounded-lg shadow-sm cursor-pointer"
                                                         onclick="window.open(this.src, '_blank')">
                                                </div>
                                            @endif

                                            <div class="flex space-x-2">
                                                <button type="button" 
                                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                                                        onclick="showApproveModal('{{ $item->id }}', '{{ $item->kode_pesanan }}')">
                                                    Approve
                                                </button>
                                                <button type="button" 
                                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                                                        onclick="showRejectModal('{{ $item->id }}', '{{ $item->kode_pesanan }}')">
                                                    Reject
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $pesanan->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pembayaran</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada pembayaran yang perlu diverifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Pembayaran</h3>
                <p class="text-sm text-gray-600 mb-4">Anda akan menyetujui pembayaran untuk pesanan: <span id="approveOrderCode" class="font-medium"></span></p>
                
                <form id="approveForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan_admin" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  rows="3" 
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" 
                                onclick="hideApproveModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Approve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Pembayaran</h3>
                <p class="text-sm text-gray-600 mb-4">Anda akan menolak pembayaran untuk pesanan: <span id="rejectOrderCode" class="font-medium"></span></p>
                
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                        <textarea name="catatan_admin" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  rows="3" 
                                  placeholder="Jelaskan alasan penolakan..."
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" 
                                onclick="hideRejectModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showApproveModal(id, orderCode) {
            document.getElementById('approveOrderCode').textContent = orderCode;
            document.getElementById('approveForm').action = `/admin/verifikasi/${id}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function hideApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function showRejectModal(id, orderCode) {
            document.getElementById('rejectOrderCode').textContent = orderCode;
            document.getElementById('rejectForm').action = `/admin/verifikasi/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        window.onclick = function(event) {
            const approveModal = document.getElementById('approveModal');
            const rejectModal = document.getElementById('rejectModal');
            
            if (event.target == approveModal) {
                hideApproveModal();
            }
            if (event.target == rejectModal) {
                hideRejectModal();
            }
        }
    </script>
</x-app-layout>