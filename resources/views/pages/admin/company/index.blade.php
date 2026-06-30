@extends('layouts.admin.master')
@section('title', 'User Management | Admin Panel')
@push('styles')
<style></style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Company</span>
</nav>

<!-- Alert -->
@if(session('success'))
    <div class="flex items-center gap-3 p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl shadow-sm" role="alert">
        <i class="ti ti-circle-check text-green-500 text-lg flex-shrink-0"></i>
        <span class="flex-1">{{ session('success') }}</span>
        <button type="button" class="text-green-400 hover:text-green-600 transition-colors" onclick="this.parentElement.remove()">
            <i class="ti ti-x text-base"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="flex items-center gap-3 p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-xl shadow-sm" role="alert">
        <i class="ti ti-alert-circle text-red-500 text-lg flex-shrink-0"></i>
        <span class="flex-1">{{ session('error') }}</span>
        <button type="button" class="text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.remove()">
            <i class="ti ti-x text-base"></i>
        </button>
    </div>
@endif

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Company</h1>
    @if($companies->isEmpty())
        <a href="{{ route('company.create') }}"
           class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Added Company
        </a>
    @endif
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead
                class="bg-gray-50 text-xs uppercase font-medium text-gray-700 tracking-wider border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4">Name Company</th>
                    <th scope="col" class="px-6 py-4">Branch Company</th>
                    <th scope="col" class="px-6 py-4">Address</th>                    
                    <th scope="col" class="px-6 py-4">Description</th>
                    <th scope="col" class="px-6 py-4">Image Company</th>
                    <th scope="col" class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">   
                @forelse ($companies as $company)             
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $company->company_name }}</td>
                        <td class="px-6 py-4">{{ $company->branch_company }}</td>
                        <td class="px-6 py-4">{{ $company->address }}</td>                        
                        <td class="px-6 py-4">{{ $company->desc }}</td>                               
                        <td class="px-6 py-4">
                            @if ($company->img)
                                <img src="{{ asset('storage/' . $company->img) }}" 
                                     alt="{{ $company->company_name }}" 
                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">                                
                                <button type="button"
                                    onclick="openDeleteModal('{{ route('company.destroy', $company->id) }}', '{{ addslashes($company->company_name) }}')"
                                    class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 cursor-pointer">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>                
                @empty
                 <!-- Kondisi Jika Tidak Ada Data -->
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                            Empty Company Data.
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

    function openDeleteModal(actionUrl, companyName) {
        deleteForm.action = actionUrl;
        deleteMessage.textContent = `Apakah anda yakin ingin menghapus company "${companyName}"?`;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }
</script>
@endpush
@endsection