@extends('layouts.admin.master')
@section('title', 'User Management | Admin Panel')
@push('styles')
<style></style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Service</span>
</nav>

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Edit Service</h1>
    <a href="{{ route('layanans.index') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <!-- Form Edit Layanan -->         
        <form action="{{ route('layanans.update', $layanan->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="font-medium text-red-800 mb-2">Terjadi kesalahan:</div>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Layanan -->
                <div>
                    <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Layanan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_layanan" 
                           id="nama_layanan" 
                           value="{{ old('nama_layanan', $layanan->nama_layanan) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('nama_layanan') border-red-500 @enderror"
                           placeholder="Masukkan nama layanan">
                    @error('nama_layanan')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Layanan -->
                <div>
                    <label for="kode_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Layanan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="kode_layanan" 
                           id="kode_layanan" 
                           value="{{ old('kode_layanan', $layanan->kode_layanan) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('kode_layanan') border-red-500 @enderror"
                           placeholder="Contoh: SRV001">
                    @error('kode_layanan')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prefix Antrian -->
                <div>
                    <label for="prefix_antrian" class="block text-sm font-medium text-gray-700 mb-2">
                        Prefix Antrian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="prefix_antrian" 
                           id="prefix_antrian" 
                           value="{{ old('prefix_antrian', $layanan->prefix_antrian) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('prefix_antrian') border-red-500 @enderror"
                           placeholder="Contoh: A, B, C">
                    @error('prefix_antrian')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Suara Panggilan (File Audio) -->
                <div>
                    <label for="suara_panggilan" class="block text-sm font-medium text-gray-700 mb-2">
                        Suara Panggilan (Audio)
                    </label>
                    @if($layanan->suara_panggilan)
                    <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">File saat ini:</p>
                        <audio controls class="w-full">
                            <source src="{{ asset('storage/' . $layanan->suara_panggilan) }}" type="audio/mpeg">
                            Browser Anda tidak mendukung pemutar audio.
                        </audio>
                    </div>
                    @endif
                    <input type="file" 
                           name="suara_panggilan" 
                           id="suara_panggilan" 
                           accept="audio/*,.mp3,.wav,.ogg,.aac,.wma"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand file:text-white hover:file:bg-brand-dark @error('suara_panggilan') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Format yang didukung: MP3, WAV, OGG, AAC, WMA. Maksimal 10MB. Biarkan kosong jika tidak ingin mengubah file.</p>
                    @error('suara_panggilan')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif (Select Option) -->
                <div>
                    <label for="status_aktif" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Aktif <span class="text-red-500">*</span>
                    </label>
                    <select name="status_aktif" 
                            id="status_aktif" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('status_aktif') border-red-500 @enderror">
                        <option value="1" {{ old('status_aktif', $layanan->status_aktif) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status_aktif', $layanan->status_aktif) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status_aktif')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi (Full Width) -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi layanan">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('layanans.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-brand rounded-lg hover:bg-brand-dark transition-colors">
                    Update Layanan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script></script>
@endpush
@endsection