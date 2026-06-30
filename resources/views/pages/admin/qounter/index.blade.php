@extends('layouts.admin.master')
@section('title', 'Loket Management | Admin Panel')
@push('styles')
<style></style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Loket</span>
</nav>
    
<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Loket</h1>
    <a href="{{ route('lokets.create') }}"
       class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Tambah Loket
    </a>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead
                class="bg-gray-50 text-xs uppercase font-medium text-gray-700 tracking-wider border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4">Nama Loket</th>
                    <th scope="col" class="px-6 py-4">Kode Loket</th>
                    <th scope="col" class="px-6 py-4">Layanan</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">   
                @forelse ($lokets as $loket)             
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loket->nama_loket }}</td>
                        <td class="px-6 py-4">{{ $loket->kode_loket }}</td>
                        <td class="px-6 py-4">{{ $loket->layanan?->nama_layanan ?? 'Tidak tersedia' }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $loket->status === 'buka' ? 'bg-blue-100 text-blue-600' : ($loket->status === 'tutup' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                                {{ ucfirst(str_replace('_', ' ', $loket->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('lokets.edit', $loket->id) }}"
                                    class="inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer">
                                    Edit
                                </a>
                                <button type="button"
                                    onclick="openDeleteModal('{{ route('lokets.destroy', $loket->id) }}', '{{ addslashes($loket->nama_loket) }}')"
                                    class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 cursor-pointer">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>                
                @empty
                 <!-- Kondisi Jika Tidak Ada Data -->
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                            Belum ada data loket yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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

@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteConfirmForm');
    const deleteMessage = document.getElementById('deleteMessage');

    function openDeleteModal(actionUrl, loketName) {
        deleteForm.action = actionUrl;
        deleteMessage.textContent = `Apakah anda yakin ingin menghapus loket "${loketName}"?`;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }
</script>
@endpush
@endsection