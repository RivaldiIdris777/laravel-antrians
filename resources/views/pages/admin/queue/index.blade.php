@extends('layouts.admin.master')
@section('title', 'Queue Management | Admin Panel')
@push('styles')
<style></style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Antrian</span>
</nav>
    
<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Queue</h1>
    <div class="flex gap-2">
        <button type="button" id="bulkDeleteBtn"
            onclick="openBulkDeleteModal()"
            class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 hidden">
            <i class="ti ti-trash mr-1.5"></i>
            Hapus Terpilih
        </button>
        <a href="{{ route('antrians.create') }}"
            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Tambah Antrian
        </a>
    </div>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-50 text-xs uppercase font-medium text-gray-700 tracking-wider border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-2 py-4 text-center">
                        <input type="checkbox" id="selectAll"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    </th>
                    <th scope="col" class="px-6 py-4">No. Antrian</th>
                    <th scope="col" class="px-6 py-4">Nama</th>
                    <th scope="col" class="px-6 py-4">Layanan</th>
                    <th scope="col" class="px-6 py-4">Loket</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4">Waktu Ambil</th>
                    <th scope="col" class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($antrians as $antrian)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-2 py-4 text-center">
                            <input type="checkbox" value="{{ $antrian->id }}"
                                class="antrian-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $antrian->nomor_antrian }}</td>
                        <td class="px-6 py-4">{{ $antrian->nama ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $antrian->layanan?->nama_layanan ?? 'Tidak tersedia' }}</td>
                        <td class="px-6 py-4">{{ $antrian->loket?->nama_loket ?? 'Belum ditentukan' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $antrian->status === 'selesai' ? 'bg-green-100 text-green-600' : ($antrian->status === 'dipanggil' ? 'bg-blue-100 text-blue-600' : ($antrian->status === 'batal' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600')) }}">
                                {{ ucfirst($antrian->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $antrian->waktu_ambil?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('antrians.edit', $antrian->id) }}"
                                    class="inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer">
                                    Edit
                                </a>
                                <button type="button"
                                    onclick="openDeleteModal('{{ route('antrians.destroy', $antrian->id) }}', '{{ addslashes($antrian->nama) }}')"
                                    class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 cursor-pointer">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                            Belum ada data antrian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $antrians->links() }}
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>
        <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block w-full max-w-lg transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
            <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Konfirmasi Hapus</h3>
            <p class="mt-4 text-sm text-gray-500" id="deleteMessage">Apakah anda yakin ingin menghapus data ini?</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Tidak
                </button>
                <form id="deleteConfirmForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                        Iya
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Masal -->
<div id="bulkDeleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="bulk-modal-title" role="dialog" aria-modal="true">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeBulkDeleteModal()"></div>
        <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block w-full max-w-lg transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
            <h3 class="text-lg font-semibold text-gray-900" id="bulk-modal-title">Konfirmasi Hapus Masal</h3>
            <p class="mt-4 text-sm text-gray-500" id="bulkDeleteMessage">Apakah anda yakin ingin menghapus data yang dipilih?</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeBulkDeleteModal()"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Tidak
                </button>
                <form id="bulkDeleteForm" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                    <button type="submit"
                        class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                        Iya
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteConfirmForm');
    const deleteMessage = document.getElementById('deleteMessage');

    function openDeleteModal(actionUrl, antrianName) {
        deleteForm.action = actionUrl;
        deleteMessage.textContent = `Apakah anda yakin ingin menghapus antrian "${antrianName}"?`;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }

    // ===== BULK DELETE =====
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.antrian-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    // Tampilkan/sembunyikan tombol hapus terpilih
    function toggleBulkDeleteBtn() {
        const checked = document.querySelectorAll('.antrian-checkbox:checked');
        if (checked.length > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.textContent = `Hapus ${checked.length} Terpilih`;
        } else {
            bulkDeleteBtn.classList.add('hidden');
        }
    }

    // Select all / unselect all
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        toggleBulkDeleteBtn();
    });

    // Listen perubahan setiap checkbox
    checkboxes.forEach(cb => {
        cb.addEventListener('change', toggleBulkDeleteBtn);
    });

    // Modal bulk delete
    const bulkDeleteModal = document.getElementById('bulkDeleteModal');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    const bulkDeleteIds = document.getElementById('bulkDeleteIds');
    const bulkDeleteMessage = document.getElementById('bulkDeleteMessage');

    function openBulkDeleteModal() {
        const checked = document.querySelectorAll('.antrian-checkbox:checked');
        const ids = Array.from(checked).map(cb => cb.value);
        bulkDeleteIds.value = JSON.stringify(ids);
        bulkDeleteMessage.textContent = `Apakah anda yakin ingin menghapus ${ids.length} antrian yang dipilih?`;
        bulkDeleteModal.classList.remove('hidden');
    }

    function closeBulkDeleteModal() {
        bulkDeleteModal.classList.add('hidden');
    }

    // Submit bulk delete via POST JSON
    bulkDeleteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const ids = JSON.parse(bulkDeleteIds.value);

        fetch('{{ route("antrians.destroyMultiple") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menghapus data');
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan: ' + err.message);
        });
    });
</script>
@endpush
@endsection
