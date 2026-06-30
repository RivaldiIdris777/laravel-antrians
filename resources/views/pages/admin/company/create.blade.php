@extends('layouts.admin.master')
@section('title', 'Company Management | Admin Panel')
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

@if($errors->any())
    <div class="flex items-center gap-3 p-4 mb-6 text-sm text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm" role="alert">
        <i class="ti ti-alert-triangle text-yellow-500 text-lg flex-shrink-0"></i>
        <span class="flex-1">Terdapat {{ $errors->count() }} kesalahan pada form. Silakan periksa kembali.</span>
        <button type="button" class="text-yellow-400 hover:text-yellow-600 transition-colors" onclick="this.parentElement.remove()">
            <i class="ti ti-x text-base"></i>
        </button>
    </div>
@endif

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <!-- Form Tambah Company -->
        <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf        

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Perusahaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="company_name" 
                           id="company_name" 
                           value="{{ old('company_name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('company_name') border-red-500 @enderror"
                           placeholder="Masukkan nama perusahaan"
                           required>
                    @error('company_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Branch Company -->
                <div>
                    <label for="branch_company" class="block text-sm font-medium text-gray-700 mb-2">
                        Cabang Perusahaan
                    </label>
                    <input type="text" 
                           name="branch_company" 
                           id="branch_company" 
                           value="{{ old('branch_company') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('branch_company') border-red-500 @enderror"
                           placeholder="Masukkan cabang perusahaan">
                    @error('branch_company')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea name="address" 
                              id="address" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('address') border-red-500 @enderror"
                              placeholder="Masukkan alamat perusahaan">{{ old('address') }}</textarea>
                    @error('address')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="desc" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="desc" 
                              id="desc" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('desc') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi perusahaan">{{ old('desc') }}</textarea>
                    @error('desc')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="img" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo / Gambar Perusahaan
                    </label>
                    <input type="file" 
                           name="img" 
                           id="img" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand file:text-white hover:file:bg-brand-dark @error('img') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-400">Format: JPEG, JPG, PNG. Maksimal 200KB.</p>
                    @error('img')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('company.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-brand rounded-lg hover:bg-brand-dark transition-colors">
                    Simpan Company
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@endpush
@endsection